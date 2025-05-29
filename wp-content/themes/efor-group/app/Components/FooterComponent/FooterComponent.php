<?php

namespace App\Components\FooterComponent;

use App\Components\Traits\AcfBuilderTrait;
use App\Core\AbstractComponent;
use App\Services\BuilderService;
use App\Services\Image;
use App\Services\MenuService;

use function App\getOptionField;

if (!defined('ABSPATH')) {
    exit('Cheatin&#8217; uh?');
}

class FooterComponent extends AbstractComponent
{
    use AcfBuilderTrait;

    private Image $image;
    private MenuService $menuService;

    public function __construct(BuilderService $builder, Image $image, MenuService $menuService)
    {
        parent::__construct($builder);
        $this->image = $image;
        $this->menuService = $menuService;
    }

    /*
    * Use this method to modify the ACF field data before returning it to the component's view (default: return base ACF data)
    */
    public function sanitize(): array
    {
        return [
            'social_medias' => [
                'name' => pll__('Suivez-nous'),
                'items' => $this->sanitizeSocialMedias(),
            ],
            'menus' => $this->menuService->getMainMenus(),
            'menu_legal' => $this->menuService->sanitizeMenu(
                wp_get_nav_menu_items(
                    get_nav_menu_locations()['footer_legal_navigation'] ?? []
                )
            ),
            'title' => [
                getOptionField('footer_title_1') ?? '',
                getOptionField('footer_title_2') ?? '',
            ],
            'ctas' => getOptionField('footer_ctas') ?? [],
        ];
    }

    private function sanitizeSocialMedias(): array
    {
        $socialMedias = getOptionField('social_medias');
        $socialMediasFormatted = [];

        if (!empty($socialMedias)) {
            foreach ($socialMedias as $socialMedia) {
                if (!empty($id = $socialMedia['social_media_icon']['ID'])) {
                    $socialMediaIcon = $this->image->getImageTag(
                        $id,
                        $this->image::SMALL_ICONS,
                        ['class' => 'social-medias__icon u-icon u-icon-24 u-icon--left'],
                    );
                }

                $socialMediasFormatted[] = [
                    'title' => $socialMedia['social_media_title'] ?? '',
                    'link' => $socialMedia['social_media_link'] ?? '',
                    'icon' => $socialMediaIcon ?? '',
                ];
            }
        }

        return $socialMediasFormatted;
    }
}
