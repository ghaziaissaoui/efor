<?php

defined('ABSPATH') or exit('Please don&rsquo;t call the plugin directly. Thanks :)');

//Google Search Console API
function seopress_pro_inspect_url_api_callback() {
    $docs = function_exists('seopress_get_docs_links') ? seopress_get_docs_links() : '';
    $options = get_option('seopress_instant_indexing_option_name');
    $check   = isset($options['seopress_instant_indexing_google_api_key']) ? esc_attr($options['seopress_instant_indexing_google_api_key']) : null;

    printf(
'<textarea id="seopress_instant_indexing_google_api_key" name="seopress_instant_indexing_option_name[seopress_instant_indexing_google_api_key]" rows="12" placeholder="' . esc_html__('Paste your Google JSON key file here', 'wp-seopress-pro') . '" aria-label="' . __('Paste your Google JSON key file here', 'wp-seopress-pro') . '">%s</textarea>',
esc_html($check)); ?>

<p class="seopress-help description"><?php printf(__('To use the <span class="dashicons dashicons-external"></span><a href="%1$s" target="_blank">Google Search Console API</a> and generate your JSON key file, please <span class="dashicons dashicons-external"></span><a href="%2$s" target="_blank">follow our guide.</a>'), esc_url($docs['search_console_api']['api']), esc_url($docs['inspect_url']['google'])); ?></p>

<br>

<p>
    <?php printf(__('To see Google Search Console data from your post types list, please <a href="%s">enable the GSC columns from <strong>Advanced settings</strong></a>','wp-seopress-pro'), admin_url('admin.php?page=seopress-advanced#tab=tab_seopress_advanced_appearance')); ?>
</p>

<br>

<p>
    <div id="seopress_launch_bot_search_console" class="btn btnPrimary">
        <?php _e('Get Insights from Google Search Console', 'wp-seopress-pro'); ?>
    </div>
    <span class="spinner"></span>
</p>
<div class="log"></div>

<?php
}
