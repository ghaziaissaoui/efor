<?php

namespace App\Hooks;

use App\Core\Interfaces\HookInterface;
use App\Services\Hooks\SendifyService;

class Sendify implements HookInterface
{
    private SendifyService $sendifyService;

    /**
     * @param SendifyService $sendifyService
     */
    public function __construct(
        SendifyService $sendifyService
    ) {
        $this->sendifyService = $sendifyService;
    }

    public function hook(): void
    {
        add_action('sendify/components/register', [$this->sendifyService, 'registerComponents']);
        add_action('sendify/editor/enqueue_script', [$this->sendifyService, 'enqueueScripts'], 9999999);
        add_filter('sendify_add_select_to_populate', [$this->sendifyService, 'fieldKeys']);
        add_filter('sendify_live_settings', [$this->sendifyService, 'liveSettings']);
        add_filter('sendify_config', [$this->sendifyService, 'config'], 10, 1);
    }
}
