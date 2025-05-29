<?php

namespace App\Controllers;

use App\Components\FooterComponent\FooterComponent;
use App\Components\HeaderComponent\HeaderComponent;
use App\Components\SidebarComponent\SidebarComponent;
use App\Core\ComponentsManager;

use function App\getOptionField;

class App
{
    private ComponentsManager $componentsManager;

    public function __construct(ComponentsManager $componentsManager)
    {
        $this->componentsManager = $componentsManager;
    }

    public function app(): array
    {
        global $product, $checkout;
        $user_data = is_user_logged_in() ? get_userdata(get_current_user_id()) : null;

        return [
            "header" => $this->componentsManager->render(HeaderComponent::class),
            "footer" => $this->componentsManager->render(FooterComponent::class),
            'sidebar' => $this->componentsManager->render(SidebarComponent::class),
            'user' => [
                'name' => $user_data !== null ? $user_data->display_name : '',
                'email' => $user_data !== null ? $user_data->user_email : '',
                'id' => $user_data->ID ?? null
            ],
            'product'  => $product,
            'checkout' => $checkout,
            'transitionColor' => $this->transitionColor(),
            'background' => $this->displayBackground(),
        ];
    }

    private function transitionColor(): string
    {
        global $post;

        $pageCarriere = getOptionField('page_carriere');
        $pageGroupe = getOptionField('page_groupe');

        if (!empty($pageCarriere)
            && !empty($pageGroupe)
            && $post->ID !== $pageCarriere
        ) {
            $color = 'green';
        } else {
            $color = 'black-graphite';
        }

        return $color;
    }

    private function displayBackground(): array
    {
        global $post;

        $backgroundData = [
            'enabled' => false,
            'composition' => null,
        ];

        $bgComposition1 = getOptionField('pages_background');
        $bgComposition2 = getOptionField('pages_background_2');

        if (is_array($bgComposition1)
            && in_array($post->ID, $bgComposition1)
        ) {
            $backgroundData['enabled'] = true;
            $backgroundData['composition'] = 1;
        } elseif (is_array($bgComposition2)
            && in_array($post->ID, $bgComposition2)
        ) {
            $backgroundData['enabled'] = true;
            $backgroundData['composition'] = 2;
        }

        return $backgroundData;
    }
}
