<?php

namespace App\Services\Hooks;

abstract class SeoPressService
{
    /**
     * SeoPress wp body open
     */
    public function bodyOpen(): void
    {
        if (in_array('wp-seopress/seopress.php', apply_filters('active_plugins', get_option('active_plugins')), true)) {
            wp_body_open();
        }
    }
}
