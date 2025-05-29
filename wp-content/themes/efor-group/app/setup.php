<?php

namespace App;

use App\Core\AjaxRequest;
use Roots\Sage\Assets\JsonManifest;
use Roots\Sage\Container;
use Roots\Sage\Template\Blade;

/**
 * Theme assets
 */
add_action('wp_enqueue_scripts', function () {
    $is_dev_front = sage('config')->get('assets')['is_dev'];
    $deps = [];
    $themeConf = config('theme');
    /** Custom deregister style & script */
    wp_dequeue_style('wc-block-style');
    wp_dequeue_style('woocommerce-layout');
    wp_dequeue_style('woocommerce-general');
    wp_dequeue_style('woocommerce-smallscreen');
    wp_dequeue_style('ppress-frontend');
    wp_dequeue_style('ppress-flatpickr');
    wp_dequeue_style('ppress-select2');


    wp_dequeue_style('wp-block-library');
    wp_dequeue_style('wp-block-library-theme');
    wp_dequeue_style('wc-block-style');

    if (!is_user_logged_in()) {
        wp_deregister_style('dashicons');
    }

    wp_deregister_script('ppress-flatpickr');
    wp_deregister_script('ppress-select2');

    wp_deregister_script('wp-embed');

    if (getEnv() === 'prod') {
        wp_dequeue_script('jquery');
    }

    /** END Custom deregister style & script */
    if ($themeConf['react_front_dep']) {
        $deps[] = 'wp-element';
    }

    if ($is_dev_front) {
        wp_enqueue_style('sage/index.css', dev_asset_path('index.scss'), false, null);
        wp_enqueue_script('module-vite-client', dev_asset_path('@vite/client'), [], null, true);
        wp_enqueue_script('module-sage/index.js', dev_asset_path('index.js'), $deps, null, true);
        wp_enqueue_script('module-sage/dev.js', dev_asset_path('dev.js'), $deps, null, true);
    } else {
        wp_enqueue_style('sage/index.css', asset_path('index.html/css/0'), false, null);
        wp_enqueue_script('sage/index.js-module', asset_path('index.html/file'), $deps, null, true);
    }

    // Localize the script with new data
    wp_localize_script(
        $is_dev_front ? 'module-sage/index.js' : 'sage/index.js-module',
        'js_vars',
        [
            'ajaxUrl' => admin_url('admin-ajax.php'),
            'ajaxNonce' => wp_create_nonce(AjaxRequest::SECURITY_NONCE_ACTION),
            'env' => !defined('ENV') ? 'prod' : ENV,

            'i18n' => [
                'loadingText' => __('Chargement en cours...', 'cosavostra'),
                'loadMoreText' => __('Voir plus d\'articles', 'cosavostra')
            ]
        ]
    );
}, 100);

/**
 * Theme setup
 */
add_action('after_setup_theme', function () {
    /**
     * Enable features from Soil when plugin is activated
     * @link https://roots.io/plugins/soil/
     */
    add_theme_support('soil-clean-up');
    add_theme_support('soil-jquery-cdn');
    add_theme_support('soil-nav-walker');
    add_theme_support('soil-nice-search');
    add_theme_support('soil-relative-urls');

    /**
     * Enable plugins to manage the document title
     * @link https://developer.wordpress.org/reference/functions/add_theme_support/#title-tag
     */
    add_theme_support('title-tag');

    /**
     * Register navigation menus
     * @link https://developer.wordpress.org/reference/functions/register_nav_menus/
     */
    register_nav_menus([
        'primary_navigation' => __('Menu principal', 'sage'),
        'group_navigation' => __('Menu Groupe'),
        'solutions_navigation' => __('Menu Solutions'),
        'expertise_navigation' => __('Menu Expertises'),
        'carrier_navigation' => __('Menu Carrière'),
        'footer_legal_navigation' => __('Footer - Liens légaux'),
    ]);

    /**
     * Enable post thumbnails
     * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
     */
    add_theme_support('post-thumbnails');

    /**
     * Enable HTML5 markup support
     * @link https://developer.wordpress.org/reference/functions/add_theme_support/#html5
     */
    add_theme_support('html5', ['caption', 'comment-form', 'comment-list', 'gallery', 'search-form']);

    add_theme_support('customize-selective-refresh-widgets');
    add_theme_support('align-wide');

    if (!is_admin()) {
        remove_action('wp_head', 'print_emoji_detection_script', 7);
        remove_action('wp_print_styles', 'print_emoji_styles');
        remove_action('admin_print_scripts', 'print_emoji_detection_script');
        remove_action('admin_print_styles', 'print_emoji_styles');
        remove_filter('the_content_feed', 'wp_staticize_emoji');
        remove_filter('comment_text_rss', 'wp_staticize_emoji');
        remove_filter('embed_head', 'print_emoji_detection_script');
        remove_filter('wp_mail', 'wp_staticize_emoji_for_email');
        add_filter('tiny_mce_plugins', 'disable_emojis_tinymce');
        add_filter('option_use_smilies', '__return_false');
    }
}, 20);

/**
 * Register sidebars
 */
add_action('widgets_init', function () {
    $config = [
        'before_widget' => '<section class="widget %1$s %2$s">',
        'after_widget' => '</section>',
        'before_title' => '<h3>',
        'after_title' => '</h3>'
    ];
    register_sidebar([
            'name' => __('Primary', 'sage'),
            'id' => 'sidebar-primary'
        ] + $config);
    register_sidebar([
            'name' => __('Footer', 'sage'),
            'id' => 'sidebar-footer'
        ] + $config);
});

/**
 * Updates the `$post` variable on each iteration of the loop.
 * Note: updated value is only available for subsequently loaded views, such as partials
 */
add_action('the_post', function ($post) {
    sage('blade')->share('post', $post);
});


function strip($expression)
{
    return str_replace(["'", "\""], '', $expression);
}

/**
 * Setup Sage options
 */
add_action('after_setup_theme', function () {
    /**
     * Add JsonManifest to Sage container
     */
    sage()->singleton('sage.assets', function () {
        return new JsonManifest(config('assets.manifest'), config('assets.uri'));
    });

    /**
     * Add Blade to Sage container
     */
    sage()->singleton('sage.blade', function (Container $app) {
        $cachePath = config('view.compiled');
        if (!file_exists($cachePath)) {
            wp_mkdir_p($cachePath);
        }
        return new Blade(config('view.paths'), $cachePath, $app);
    });

    /**
     * Create @asset() Blade directive
     */
    sage('blade')->compiler()->directive('asset', function ($asset) {
        return "<?= " . __NAMESPACE__ . "\\asset_path({$asset}); ?>";
    });

    /**
     * Create @asset() Blade directive
     */
    sage('blade')->compiler()->directive('dump', function ($what) {
        return "<?php var_dump($what) ?>";
    });

    /**
     * Register string translation Polylang
     */
    $strings = [
        'Aucun résultat associé à votre recherche',
        'Voir toutes les actualités',
        'Candidatez de manière spontanée, une offre pourrait bien correspondre à votre profil',
        'Formulaire de candidature spontanée',
        'Efor - Accueil',
        'Voir plus de résultats',
        'Rejoignez-nous',
        'Le groupe',
        'Formulaire de contact',
        'Témoignages',
        'Pages',
        'Lire l\'article',
        'Filtres :',
        'Suivez-nous',
        'Contactez-nous',
        'Rechercher',
        'Formulaire de recherche',
        'Soumettre la recherche',
        'Découvrir le témoignage',
        'Voir la page',
        'Groupe',
        'Solutions',
        'Expertises',
        'Carrière',
        'Importer',
        'Maximum 1 Mo',
        'Recherche',
        'En savoir plus',
        'Tout',
        'Ce contenu n\'est pas visible à cause du paramétrage de vos cookies.',
        'Ouvrir les paramètres des cookies',
        'Page introuvable',
        'Retourner à l\'accueil',
    ];

    if (function_exists('pll_register_string')) {
        foreach ($strings as $string) {
            pll_register_string('efor', $string);
        }
    }
});

add_filter('wp_head', function () {
    echo sprintf(
        '
        <link rel="apple-touch-icon" sizes="180x180" href="%s">
        <link rel="icon" type="image/png" sizes="32x32" href="%s">
        <link rel="icon" type="image/png" sizes="16x16" href="%s">
        <link rel="mask-icon" href="%s" color="#5bbad5">
        <meta name="msapplication-TileColor" content="#da532c">
        <meta name="theme-color" content="#ffffff">',
        asset_path('images/favicon/apple-touch-icon.png'),
        asset_path('images/favicon/favicon-32x32.png'),
        asset_path('images/favicon/favicon-16x16.png'),
        asset_path('images/favicon/safari-pinned-tab.svg')
    );
});
