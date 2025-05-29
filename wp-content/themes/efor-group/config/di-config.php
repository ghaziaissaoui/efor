<?php

use App\GutenbergBlock\DemoGutembergBlock;
use App\Hooks\Acf;
use App\Hooks\Admin;
use App\Hooks\ConsentAxeptio;
use App\Hooks\ExternalScripts;
use App\Hooks\Sendify;
use App\Hooks\SeoPress;
use App\Hooks\Setup;
use DI\Container;

use function DI\create;

return [
    'gutenberg' => [
        'slug' => 'cosavostra',
        'title' => __('CosaVostra')
    ],
    'debug_template' => true,
    'enable_pub_ads' => false,
    'hooks' => [
        Acf::class,
        Admin::class,
        SeoPress::class,
        Setup::class,
        DemoGutembergBlock::class,
        ExternalScripts::class,
        Sendify::class,
        ConsentAxeptio::class,
    ],
    'ajax' => [
        \App\Ajax\DemoRequest::class,
        \App\Ajax\DemoRequestError::class,
        \App\Ajax\LoadTalentModalContent::class,
        \App\Ajax\LoadMore::class,
    ],
    'Acf' => function (Container $c) {
        return new \App\Services\Acf($c);
    },
    \App\Core\Session\SessionInterface::class  => create(\App\Core\Session\PHPSession::class),
];
