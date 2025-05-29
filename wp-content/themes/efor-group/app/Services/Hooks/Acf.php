<?php

namespace App\Services\Hooks;

use App\Services\BuilderService;
use StoutLogic\AcfBuilder\FieldsBuilder;

use function App\sage;

class Acf
{
    private BuilderService $builder;

    public function __construct(BuilderService $builder)
    {
        $this->builder = $builder;
    }

    public function buildComponents(): void
    {
        acf_add_local_field_group($this->builder->getBuilder()->build());
    }

    public function registerPagesOptions(): void
    {
        $this->registerParentOptionsPage();
    }

    private function registerParentOptionsPage()
    {
        if (true === function_exists('acf_add_options_page')) {
            return acf_add_options_page(
                array(
                    'page_title' => __('Theme options', 'cosavostra'),
                    'menu_title' => __('Theme options', 'cosavostra'),
                    'menu_slug' => 'general-settings',
                    'capability' => 'edit_posts',
                    'redirect' => false,
                    'position' => 2
                )
            );
        }
    }

    /**
     * @param array $paths
     * @return array
     */
    public function loadJSON(array $paths): array
    {
        unset($paths[0]);
        $paths[] = $this->getJsonSavePoint();
        return $paths;
    }

    public function getJsonSavePoint(): string
    {
        return sage('config')->get('theme')['dir'] . '/config/acf-json';
    }
}
