<?php

namespace App\Services\Hooks;

use Brain\Hierarchy\Hierarchy;
use WP_Admin_Bar;

use function App\camelCase;

class AdminBarService
{
    public function adminBar(WP_Admin_Bar $admin_bar): void
    {
        if (!current_user_can('manage_options') || \App\getEnv() === 'prod') {
            return;
        }

        $admin_bar->add_menu(array(
            'id' => 'cv-controller-hierarchy',
            'parent' => null,
            'group' => null,
            'title' => 'Controller hierarchy',
            'meta' => [
                'title' => 'debug controller hierarchy for this theme',
            ]
        ));

        global $wp_query;
        $hierarchy = new Hierarchy(0);
        $templates = $hierarchy->getTemplates($wp_query);

        foreach (array_merge(array_diff(get_body_class(), $templates), $templates) as $index => $controller) {
            $controllerName = camelCase($controller, true);
            $controller = str_replace('"', '', 'App\Controllers\"' . $controllerName . '"');
            $admin_bar->add_menu(array(
                'id' => "controller-item-$index",
                'parent' => 'cv-controller-hierarchy',
                'title' => $controller,
            ));
        }
    }
}
