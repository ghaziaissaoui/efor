<?php
/*
Plugin Name: CosaVostra disable mails & cron
Plugin URI: localhost/wp_test/wp-content/plugins/auto-advertise/
Description: Désactiver la fonction wp_mail et wp_cron si et seulement si le serveur est local ou une preprod.
Author: Emmanuel Duchesne
Version: 1.0
Author URI: http://emmanuel-duchesne.fr
*/

$whitelist = [
    'localhost',
    '127.0.0.1',
    'cosavostra',
    'local'
];
$url = 'http://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
$safe = [];

foreach ($whitelist as $key => $result) {
    if (strpos($url, $result) !== false) {

        add_filter('wp_mail', function ($args) {
            $args['message'] = ''; //Don't send the email
            return $args;
        });

        $safe[$result] = 'String is available';
        define('DISABLE_WP_CRON', true); // Disable Cron requests
        break;
    } else {
        $safe[$result] = 'String is not available';
    }
}
