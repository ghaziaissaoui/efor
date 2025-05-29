<?php

namespace App\Components\HeaderComponent;

use App\Core\AbstractComponent;
use App\Services\MenuService;

use function App\getOptionField;

if (!defined('ABSPATH')) {
    exit('Cheatin&#8217; uh?');
}

class HeaderComponent extends AbstractComponent
{
    private MenuService $menuService;

    public function __construct(MenuService $menuService)
    {
        $this->menuService = $menuService;
    }

    public function sanitize()
    {
        return [
            'menus' => $this->menuService->getMainMenus(),
            'languages' => pll_the_languages([
                'show_names' => 0,
                'raw' => 1,
                'hide_if_no_translation' => 1,
            ]),
            'cta_title' => getOptionField('cta_title') ?? pll__('Contactez-nous'),
            'cta_link' => getOptionField('cta_link') ?? home_url(),
            'header_transparent' => is_front_page() || 'talent' === get_post_type()
        ];
    }
}
