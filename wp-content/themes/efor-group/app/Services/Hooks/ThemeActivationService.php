<?php

namespace App\Services\Hooks;

use WP_Admin_Bar;

use function App\config;

class ThemeActivationService
{
    public function activate(): void
    {
        $plugins = [
            [
                'name' => 'SeoPress',
                'slug' => 'wp-seopress',
                'required' => true,
                'force_activation' => true,
                'force_deactivation' => false,
            ],
            [
                'name' => 'CPT ui',
                'slug' => 'custom-post-type-ui',
                'required' => false,
                'force_activation' => false,
                'force_deactivation' => false,
            ],
            [
                'name' => 'Query Monitor',
                'slug' => 'query-monitor',
                'required' => true,
                'force_activation' => true,
                'force_deactivation' => false,
            ],
        ];

        $config = [
            'id' => 'tgmpa',
            'default_path' => '',
            'menu' => 'tgmpa-install-plugins',
            'parent_slug' => 'themes.php',
            'capability' => 'edit_theme_options',
            'has_notices' => true,
            'dismissable' => true,
            'dismiss_msg' => '',
            'is_automatic' => false,
            'message' => '',
        ];

        tgmpa($plugins, $config);
    }
}
