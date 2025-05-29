<?php

defined('ABSPATH') or exit('Please don&rsquo;t call the plugin directly. Thanks :)');

/* Add Tabs to Content Analysis */
add_action('seopress_ca_tab_before', 'seopress_pro_ca_tab_before');
function seopress_pro_ca_tab_before() {
    ?>
    <ul class="wrap-ca-list">
        <li><a href="#seopress-ca-tabs-2"><?php _e('Overview', 'wp-seopress-pro'); ?></a></li>
        <?php
        if (version_compare(SEOPRESS_PRO_VERSION, '5.7', '>=')) { ?>
                <?php if (seopress_get_toggle_option('inspect-url') ==='1') { ?>
                    <li><a href="#seopress-ca-tabs-1"><?php _e('Inspect with Google', 'wp-seopress-pro'); ?></a></li>
                <?php } ?>

        <?php
    }
    ?>
        <li><a href="#seopress-ca-tabs-3"><?php _e('Internal Linking', 'wp-seopress-pro'); ?></a></li>
    </ul>
    <?php
}

/* Add Google Suggestions to Content Analysis metabox */
add_action('seopress_ca_before', 'seopress_pro_ca_before');
function seopress_pro_ca_before() {
    ?>
    <div class="col-right">
        <p>
            <label for="seopress_google_suggest_kw_meta">
                <?php _e('Google suggestions', 'wp-seopress-pro'); ?>
                <?php echo seopress_tooltip(__('Google suggestions', 'wp-seopress-pro'), __('Enter a keyword, or a phrase, to find the top 10 Google suggestions instantly. This is useful if you want to work with the long tail technique.', 'wp-seopress-pro'), esc_html('my super keyword,another keyword,keyword')); ?>
            </label>
            <input id="seopress_google_suggest_kw_meta" type="text" name="seopress_google_suggest_kw"
                placeholder="<?php _e('Get suggestions from Google', 'wp-seopress-pro'); ?>"
                aria-label="Google suggestions" value="">
            <span class="description"><?php _e('Click on a suggestion below to add it as a target keyword.', 'wp-seopress-pro'); ?></span>
        </p>
        <button id="seopress_get_suggestions" type="button"
            class="<?php echo seopress_btn_secondary_classes(); ?>">
            <?php _e('Get suggestions!', 'wp-seopress-pro'); ?>
        </button>

        <ul id='seopress_suggestions'></ul>
        <?php if ('' != get_locale()) {
                $locale       = substr(get_locale(), 0, 2);
                $country_code = substr(get_locale(), -2);
            } else {
                $locale       = 'en';
                $country_code = 'US';
            } ?>
        <script>
            jQuery('#seopress_get_suggestions').on('click', function(data) {
                data.preventDefault();

                document.getElementById('seopress_suggestions').innerHTML = '';

                var kws = jQuery('#seopress_google_suggest_kw_meta').val();

                if (kws) {
                    var script = document.createElement('script');
                    script.src =
                        'https://www.google.com/complete/search?client=firefox&format=rich&hl=<?php echo $locale; ?>&q=' +
                        kws +
                        '&gl=<?php echo $country_code; ?>&callback=seopress_google_suggest';
                    document.body.appendChild(script);
                }
            });
        </script>
    </div>
    <?php
}

/* Add Inspect URL tab */
add_action('seopress_ca_tab_after', 'seopress_pro_ca_tab_after', 10, 1);
function seopress_pro_ca_tab_after($current_id) {
    if (version_compare(SEOPRESS_PRO_VERSION, '5.7', '>=')) {
        if (seopress_get_toggle_option('inspect-url') === '1') { ?>
        <div id="seopress-ca-tabs-1">
            <?php if (function_exists('seopress_pro_get_service') && !empty($current_id)) {
                seopress_pro_get_service('RenderGSCInspectUrl')->render($current_id);
            } ?>
        </div>
        <?php }
    }

        ?>
    <div id="seopress-ca-tabs-3">
        <?php if (function_exists('seopress_pro_get_service') && !empty($current_id)) {
            seopress_pro_get_service('RenderMetaboxInternalLinking')->render($current_id);
        } ?>
    </div>
    <?php
}
