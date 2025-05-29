<?php

defined('ABSPATH') or exit('Please don&rsquo;t call the plugin directly. Thanks :)');

/* Add Data, Redirects and Video tabs to Tools */
add_filter('seopress_tools_tabs', 'seopress_pro_tools_tabs');
function seopress_pro_tools_tabs($plugin_settings_tabs) {
    unset($plugin_settings_tabs['tab_seopress_tool_settings']);
    unset($plugin_settings_tabs['tab_seopress_tool_plugins']);
    unset($plugin_settings_tabs['tab_seopress_tool_reset']);

    $plugin_settings_tabs['tab_seopress_tool_data'] = __('Data', 'wp-seopress-pro');
    $plugin_settings_tabs['tab_seopress_tool_settings'] = __('Settings', 'wp-seopress-pro');
    $plugin_settings_tabs['tab_seopress_tool_plugins'] = __('Plugins', 'wp-seopress-pro');
    $plugin_settings_tabs['tab_seopress_tool_redirects'] = __('Redirections', 'wp-seopress-pro');
    $plugin_settings_tabs['tab_seopress_tool_video'] = __('Video sitemap', 'wp-seopress-pro');
    $plugin_settings_tabs['tab_seopress_tool_reset'] = __('Reset', 'wp-seopress-pro');

    return $plugin_settings_tabs;
}

/* Add CSV export to Tools page */
add_action('seopress_tools_before', 'seopress_pro_tools_before', 10, 2);
function seopress_pro_tools_before($current_tab, $docs) {
    if (version_compare(SEOPRESS_PRO_VERSION, '6.1', '>=')) { ?>
        <div class="seopress-tab <?php if ('tab_seopress_tool_data' == $current_tab) { echo 'active'; } ?>" id="tab_seopress_tool_data">
            <?php include_once SEOPRESS_PRO_PLUGIN_DIR_PATH . '/inc/admin/import/tools.php'; ?>
        </div>
    <?php } else { ?>
        <div class="seopress-tab <?php if ('tab_seopress_tool_data' == $current_tab) { echo 'active'; } ?>" id="tab_seopress_tool_data">
            <div class="seopress-notice">
                <p><?php _e('Looking for the CSV import / export tool? Please <strong>update SEOPress PRO</strong> to version 6.1.','wp-seopress-pro'); ?></p>
            </div>
        </div>
    <?php }
}

/* Add Redirection / Video sitemap to Tools page */
add_action('seopress_tools_migration', 'seopress_pro_tools_migration');
function seopress_pro_tools_migration($current_tab) { ?>
 <div class="seopress-tab <?php if ('tab_seopress_tool_redirects' == $current_tab) {
        echo 'active';
    } ?>" id="tab_seopress_tool_redirects">
            <?php if (is_plugin_active('wp-seopress-pro/seopress-pro.php')) { ?>
            <?php if ('1' == seopress_get_toggle_option('404') && function_exists('seopress_get_redirection_pro_html')) {
        seopress_get_redirection_pro_html();
    } else { ?>
            <div class="seopress-notice is-warning">
                <p><?php _e('Redirections feature is disabled. Please activate it from the <strong>PRO page</strong>.', 'wp-seopress-pro'); ?>
                </p>
                <p>
                    <a href="<?php echo admin_url('admin.php?page=seopress-pro-page'); ?>"
                        class="btn btnSecondary">
                        <?php _e('Activate Redirections', 'wp-seopress-pro'); ?>
                    </a>
                </p>
            </div>
            <?php } ?>
            <?php } ?>
        </div>
        <div class="seopress-tab <?php if ('tab_seopress_tool_video' == $current_tab) {
        echo 'active';
    } ?>" id="tab_seopress_tool_video">
            <?php if (is_plugin_active('wp-seopress-pro/seopress-pro.php')) { ?>
            <?php if ('1' === seopress_get_toggle_option('xml-sitemap') && '1' === seopress_get_service('SitemapOption')->isEnabled() && '1' === seopress_get_service('SitemapOption')->videoIsEnabled()) { ?>
                <div class="postbox section-tool">
                    <div class="sp-section-header">
                        <h2>
                            <?php _e('Video XML sitemap', 'wp-seopress-pro'); ?>
                        </h2>
                    </div>
                    <div class="inside">
                        <h3>
                            <?php _e('Add YouTube videos to the XML Video sitemap', 'wp-seopress-pro'); ?>
                        </h3>
                        <p><?php _e('Click the button below to automatically scan all your content for YouTube URL and add them to the video XML sitemap. We automatically add YouTube videos each time you save a post.','wp-seopress-pro'); ?></p>

                        <button id="seopress-video-regenerate" type="button" class="btn btnSecondary"><?php _e('Regenerate','wp-seopress-pro'); ?></button>
                        <span class="spinner"></span>
                        <div class="log"></div>
                    </div>
                </div>
    <?php } else { ?>
            <div class="seopress-notice is-warning">
                <p><?php _e('XML Video sitemap feature is disabled. Please activate it from the <strong>XML sitemaps settings page</strong>.', 'wp-seopress-pro'); ?>
                </p>
                <p>
                    <a href="<?php echo admin_url('admin.php?page=seopress-xml-sitemap'); ?>"
                        class="btn btnSecondary">
                        <?php _e('Activate XML Video sitemap', 'wp-seopress-pro'); ?>
                    </a>
                </p>
            </div>
            <?php } ?>
            <?php } ?>
        </div>
        <?php
    }
