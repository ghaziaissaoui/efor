<?php

declare(strict_types=1);

namespace App\Hooks;

use App\Core\Interfaces\HookAdminInterface;
use App\Core\Interfaces\HookInterface;
use App\Services\Hooks\Acf as AcfService;

/**
 *
 * Configure all the hooks relating to the plugin AcfPro.
 *
 * Class AcfPro
 * @package App\Services
 */
class Acf implements HookInterface, HookAdminInterface
{
    /**
     * @var AcfService
     */
    private AcfService $acfService;

    public function __construct(
        AcfService $acfService
    ) {
        $this->acfService = $acfService;
    }

    public function hook(): void
    {
        add_filter('acf/init', [$this->acfService, 'buildComponents'], 10, 1);
    }

    public function hookAdmin(): void
    {
        add_action('init', [$this->acfService, 'registerPagesOptions']);
        add_filter('acf/settings/save_json', [$this->acfService, 'getJsonSavePoint']);
        add_filter('acf/settings/load_json', [$this->acfService, 'loadJSON'], 10, 1);
    }
}
