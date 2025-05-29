<?php
if ( ! defined('ABSPATH')) {
    exit;
}

/**
 * Add AI JS
 */
add_action('elementor/editor/before_enqueue_scripts', 'seopress_pro_elementor_register_elements_assets', 10000);

function seopress_pro_elementor_register_elements_assets() {
    $active = seopress_get_service('ToggleOption')->getToggleAi();
    if($active === "1"){
        $seopress_ai_generate_seo_meta = [
            'seopress_nonce'            => wp_create_nonce('seopress_ai_generate_seo_meta_nonce'),
            'seopress_ai_generate_seo_meta'      => admin_url('admin-ajax.php'),
        ];

        wp_enqueue_script('seopress-pro-ai-js', SEOPRESS_PRO_PLUGIN_DIR_URL . 'inc/admin/page-builders/elementor/assets/js/base-pro.js', ['jquery'], SEOPRESS_PRO_VERSION, true);

        wp_localize_script('seopress-pro-ai-js', 'seopressAjaxAIMetaSEO', $seopress_ai_generate_seo_meta);
    }
}

/**
 * Add AI button to Elementor, SEO, Titles settings
 */
add_action('seopress_elementor_seo_titles_before', 'seopress_pro_elementor_seo_titles_before');
function seopress_pro_elementor_seo_titles_before() {
    ?>
        <# if ( data.field_type === 'text' ) { #>
            <?php if (is_plugin_active('wp-seopress-pro/seopress-pro.php') && '1' == seopress_get_toggle_option('ai')) { ?>
                <div class="elementor-control-input-wrapper" style="margin-bottom: 20px">
                    <button id="seopress_ai_generate_seo_meta" class="btn btnSecondary elementor-button elementor-button-default" type="button">
                        <?php _e('Generate meta with AI','wp-seopress-pro'); ?>
                    </button>
                    <div id="seopress_ai_generate_seo_meta_log" style="display:none"></div>
                </div>
            <?php } ?>
        <# } #>
    <?php
}
