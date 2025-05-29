<?php

declare(strict_types=1);

namespace App\Services;

final class MenuService
{
    public function sanitizeMenu(array $menu): array
    {
        $menuFormatted = [];

        if (!empty($menu)) {
            foreach ($menu as $item) {
                $menuFormatted[] = [
                    'post_id' => intval($item->ID),
                    'title' => $item->title,
                    'link' => $item->url,
                ];
            }
        }

        return $menuFormatted;
    }

    public function getMainMenus(): array
    {
        $menusFormatted = [];
        $menus = [
            'group' => [
                'name' => pll__('Groupe'),
                'id' => get_nav_menu_locations()['group_navigation'],
            ],
            'solutions' => [
                'name' => pll__('Solutions'),
                'id' => get_nav_menu_locations()['solutions_navigation'],
                'expertise' => [
                    'name' => pll__('Expertises'),
                    'id' => get_nav_menu_locations()['expertise_navigation'],
                ],
            ],
            'carrier' => [
                'name' => pll__('Carrière'),
                'id' => get_nav_menu_locations()['carrier_navigation'],
            ],
        ];

        foreach ($menus as $key => $menu) {
            $menusFormatted[$key] = [
                'expertise' => !empty($menu['expertise']) ? [
                    'name' => $menu['expertise']['name'],
                    'items' => $this->sanitizeMenu(wp_get_nav_menu_items($menu['expertise']['id']))
                ] : null,
                'name' => $menu['name'],
                'items' => $this->sanitizeMenu(wp_get_nav_menu_items($menu['id']))
            ];
        }

        return $menusFormatted;
    }
}
