<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Theme Directory
    |--------------------------------------------------------------------------
    |
    | This is the absolute path to your theme directory.
    |
    | Example:
    |   /srv/www/example.com/current/web/app/themes/sage
    |
    */

    'dir' => get_theme_file_path(),

    /*
    |--------------------------------------------------------------------------
    | Theme Directory URI
    |--------------------------------------------------------------------------
    |
    | This is the web server URI to your theme directory.
    |
    | Example:
    |   https://example.com/app/themes/sage
    |
    */

    'uri' => get_theme_file_uri(),

    'rest_routes_disabled' => [
        '/wp/v2/users',
        '/wp/v2/posts',
        '/wp/v2/media'
    ],

    'react_front_dep' => false,

    'mapping_blocks_flexible_content' => apply_filters('mapping_blocks_flexible_content', []),

    'flexibleContent' => 'components'
];
