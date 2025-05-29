<?php

namespace App\Hooks;

use App\Core\Interfaces\HookFrontInterface;
use App\Services\Hooks\SeoPressService;

class SeoPress implements HookFrontInterface
{
    public function hookFront()
    {
        add_action('wp_body_open', [SeoPressService::class, 'bodyOpen']);
    }
}
