<?php
require WPMU_PLUGIN_DIR . '/class-tgm-plugin-activation.php';

if (file_exists(WPMU_PLUGIN_DIR . '/plugin-disable-emails/cv-disable-mail.php')) {
    require WPMU_PLUGIN_DIR . '/plugin-disable-emails/cv-disable-mail.php';
}

if (file_exists(WPMU_PLUGIN_DIR . '/acf-sync/acf-sync.php')) {
    require WPMU_PLUGIN_DIR . '/acf-sync/acf-sync.php';
}

if (file_exists(WPMU_PLUGIN_DIR . '/cv-paywall-cutter')) {
    require WPMU_PLUGIN_DIR . '/cv-paywall-cutter/cv-paywall-cutter.php';
}
