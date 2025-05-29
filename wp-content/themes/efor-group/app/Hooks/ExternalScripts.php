<?php

namespace App\Hooks;

use App\Core\Interfaces\HookFrontInterface;
use App\Services\Hooks\ScriptService;

class ExternalScripts implements HookFrontInterface
{
    private ScriptService $scriptService;

    public function __construct(
        ScriptService $scriptService
    ) {
        $this->scriptService = $scriptService;
    }

    public function hookFront(): void
    {
        add_action('wp_enqueue_scripts', [$this->scriptService, 'scripts'], 10, 1);
        add_action('wp_head', [$this->scriptService, 'customScript'], 10, 1);
    }
}
