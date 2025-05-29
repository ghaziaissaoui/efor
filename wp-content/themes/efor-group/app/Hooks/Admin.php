<?php

namespace App\Hooks;

use App\Core\Interfaces\HookAdminInterface;
use App\Services\Hooks\ThemeActivationService;

class Admin implements HookAdminInterface
{
    private ThemeActivationService $themeService;
    private \App\Services\Acf $acfService;

    /**
     * Admin constructor.
     * @param ThemeActivationService $themeService
     */
    public function __construct(
        ThemeActivationService $themeService,
        \App\Services\Acf $acfService
    ) {
        $this->themeService = $themeService;
        $this->acfService = $acfService;
    }

    public function hookAdmin(): void
    {
        add_action('tgmpa_register', [$this->themeService, 'activate']);
        add_action('acf/input/admin_head', [$this->acfService, 'previewImages']);
        add_filter('acf/prepare_field/name=components', [$this->acfService, 'mappingBlocks'], 10, 1);
    }
}
