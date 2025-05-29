<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Assets Manifest
    |--------------------------------------------------------------------------
    |
    | Your asset manifest is used by Sage to assist WordPress and your views
    | with rendering the correct URLs for your assets. This is especially
    | useful for statically referencing assets with dynamically changing names
    | as in the case of cache-busting.
    |
    */

    'manifest' => get_theme_file_path().'/dist/manifest.json',

    /*
    |--------------------------------------------------------------------------
    | Assets Path URI
    |--------------------------------------------------------------------------
    |
    | The asset manifest contains relative paths to your assets. This URI will
    | be prepended when using Sage's asset management system. Change this if
    | you are using a CDN.
    |
    */

    'uri' => file_exists(get_theme_file_path().'/dist/manifest.json')
        ? \App\asset_uri()
        : str_replace('/dist', '/front/public', \App\asset_uri()),

    'dev_uri' => 'http://localhost:' . file_get_contents(get_theme_file_path() . '/front/config/dev-server-port'),

    'is_dev' => !file_exists(get_theme_file_path().'/dist/manifest.json')
];
