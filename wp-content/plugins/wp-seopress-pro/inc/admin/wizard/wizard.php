<?php if ( ! defined('ABSPATH')) {
    exit;
}

add_action('seopress_wizard_setup_ready', 'seopress_pro_wizard_setup_ready');
function seopress_pro_wizard_setup_ready() {
    $seo_title = 'SEOPress PRO';
    if (function_exists('seopress_get_toggle_white_label_option') && '1' == seopress_get_toggle_white_label_option()) {
        $seo_title = seopress_white_label_plugin_list_title_pro_option() ? seopress_white_label_plugin_list_title_pro_option() : 'SEOPress PRO';
    }
    ?>
    <li class="seopress-wizard-next-step-item">
        <!-- SEOPress PRO -->
        <?php if ('valid' != get_option('seopress_pro_license_status') && ! is_multisite()) { ?>
        <div class="seopress-wizard-next-step-description">
            <p class="next-step-heading"><?php esc_html_e('Next step', 'wp-seopress-pro'); ?>
            </p>
            <h3 class="next-step-description">
                <?php printf(esc_html__('Welcome to %s!', 'wp-seopress-pro'), $seo_title); ?>
            </h3>
            <p class="next-step-extra-info">
                <?php esc_html_e('Please activate your license to receive automatic updates and get premium support.', 'wp-seopress-pro'); ?>
            </p>
        </div>
        <div class="seopress-wizard-next-step-action">
            <p class="seopress-setup-actions step">
                <a class="btn btnPrimary"
                    href="<?php echo admin_url('admin.php?page=seopress-license'); ?>">
                    <?php _e('Activate License', 'wp-seopress-pro'); ?>
                </a>
            </p>
        </div>
        <?php } ?>
    </li>
<?php
}
