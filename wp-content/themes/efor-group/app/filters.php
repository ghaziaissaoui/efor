<?php

namespace App;

use App\Services\AcfService;
use App\Services\UploaderService;

/**
 * Add <body> classes
 */
add_filter('body_class', function (array $classes) {
    /** Add page slug if it doesn't exist */
    if ((is_single() || (is_page() && !is_front_page())) && !in_array(basename(get_permalink()), $classes, true)) {
        $classes[] = basename(get_permalink());
    }

    /** Add class if sidebar is active */
    if (display_sidebar()) {
        $classes[] = 'sidebar-primary';
    }

    /** Clean up class names for custom templates */
    $classes = array_map(function ($class) {
        return preg_replace(['/-blade(-php)?$/', '/^page-template-views/'], '', $class);
    }, $classes);

    if (getEnv() !== 'prod') {
        $classes[] = 'has_debug_toolbar';
    }

    return array_filter($classes);
});

/**
 * Add "… Continued" to the excerpt
 */
add_filter('excerpt_more', function () {
    return ' &hellip; <a href="' . get_permalink() . '">' . __('Continued', 'sage') . '</a>';
});

/**
 * Template Hierarchy should search for .blade.php files
 */
collect([
    'index', '404', 'archive', 'author', 'category', 'tag', 'taxonomy', 'date', 'home',
    'frontpage', 'page', 'paged', 'search', 'single', 'singular', 'attachment', 'embed'
])->map(function ($type) {
    add_filter("{$type}_template_hierarchy", __NAMESPACE__ . '\\filter_templates');
});

/**
 * Render comments.blade.php
 */
add_filter('comments_template', function ($comments_template) {
    $comments_template = str_replace(
        [get_stylesheet_directory(), get_template_directory()],
        '',
        $comments_template
    );

    $data = collect(get_body_class())->reduce(function ($data, $class) use ($comments_template) {
        return apply_filters("sage/template/{$class}/data", $data, $comments_template);
    }, []);

    $theme_template = locate_template(["views/{$comments_template}", $comments_template]);

    if ($theme_template) {
        echo template($theme_template, $data);
        return get_stylesheet_directory() . '/index.php';
    }

    return $comments_template;
}, 100);

add_filter('script_loader_tag', function ($tag, $handle) {
    if (strpos($handle, 'async') !== false) {
        $tag = str_replace('<script ', '<script async ', $tag);
    }

    if (strpos($handle, 'defer') !== false) {
        $tag = str_replace('<script ', '<script defer ', $tag);
    }

    if (strpos($handle, 'module') !== false) {
        $tag = str_replace('<script ', '<script type="module" ', $tag);
    }

    return $tag;
}, 10, 2);

/**
 * Add the services you want to use in ajax
 */
add_filter('cv_add_services', function ($services) {
    $services['uploader_service'] = new UploaderService();
    return $services;
});

add_filter('login_headerurl', function () {
    return 'https://cosavostra.com';
});

remove_filter('the_content', 'wpautop');

add_filter('excerpt_more', function ($more) {
    return '';
});

add_filter('render_block', function ($blockContent, $block) {
    if ($block['blockName'] === 'core/video') {
        $blockContent = preg_replace(
            '~<figure ([^>]*)>(.*)</figure>~',
            '<figure $1><div class="wp-block-video__wrapper">$2</div></figure>',
            $blockContent
        );
    }

    return $blockContent;
}, 10, 2);

add_filter('starter_component_render', function (string $componentContent, string $componentName) {
    if (is_single()
        && 'HeaderComponent' !== $componentName
        && 'FooterComponent' !== $componentName
        && 'HeroTalentComponent' !== $componentName
        && 'HeroArticleComponent' !== $componentName
        && 'CardLinkComponent' !== $componentName
        && 'CardActuComponent' !== $componentName
        && 'FullWImgComponent' !== $componentName
    ) {
        $componentContent = preg_replace(
            '~\b(gs-fluid-container|gs-row)\b~',
            '',
            $componentContent
        );
    }

    return $componentContent;
}, 10, 2);

add_filter('template_single_contenu', function (string $content) {
    $content = preg_replace(
        '~\b(gs-fluid-container|gs-row)\b~',
        '',
        $content
    );

    return preg_replace(
        '~<a ([^>]*)>([^>]*)</a>~',
        '<a $1 class="c-gold t-none t-link-fx">$2</a>',
        $content
    );
});

add_filter('body_class', function (array $classes) {
    $classes[] = 'sidebar-transition';

    return $classes;
});

add_filter('template_redirect', function () {
    if (is_search()
        && !empty($_GET['s'])
        && !empty($searchUrlId = getOptionField('search_page'))
    ) {
        wp_redirect(
            sprintf(
                '%s?search=%s',
                get_permalink($searchUrlId),
                get_query_var('s')
            )
        );
        exit();
    } elseif (is_search()) {
        wp_redirect(get_permalink(getOptionField('search_page')));
        exit();
    }
});

add_action('acf/init', function () {
    if (!empty($apiKey = GOOGLE_MAPS_API_KEY)) {
        acf_update_setting('google_api_key', $apiKey);
    }
});

/**
 * Add class to link from ACF WYSIWYG
 */
add_filter('acf_the_content', function ($content) {
    return sprintf(
        '<div class="rich-text-base">%s</div>',
        $content
    );
});
