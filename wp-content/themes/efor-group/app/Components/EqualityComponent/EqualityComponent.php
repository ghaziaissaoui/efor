<?php

namespace App\Components\EqualityComponent;

use App\Components\Traits\AcfBuilderTrait;
use App\Core\AbstractComponent;
use App\Services\BuilderService;
use App\Services\Image;
use StoutLogic\AcfBuilder\FieldsBuilder;

use function App\getTextColorBasedOnBackground;

if (!defined('ABSPATH')) {
    exit('Cheatin&#8217; uh?');
}

class EqualityComponent extends AbstractComponent
{
    use AcfBuilderTrait;

    protected string $name = 'Equality Component';
    private Image $image;

    protected bool $isFlexibleComponent = true; //true to enable flexible
    protected bool $isGutenbergBlock = true; //true to enable gutenberg block

    public function __construct(BuilderService $builder, Image $image)
    {
        parent::__construct($builder);
        $this->image = $image;
    }

    /*
    * Use this method to modify the ACF field data before returning it to the component's view (default: return base ACF data)
    */
    public function sanitize($data)
    {
        foreach (['image_left', 'image_right'] as $img) {
            if (!empty($id = $data[$img]['ID'])) {
                $data[$img] = $this->image->getImageTag(
                    $id,
                    $this->image::IMG_EQUALITY,
                    ['class' => 'ratio-block__content']
                );
            }
        }

        if (!empty($data['background'])) {
            $data['global_text_color'] = getTextColorBasedOnBackground($data['background']);
        }

        return $data;
    }

    /*
    * ACF config for both Gutenberg and flexible component are created here using the FieldsBuilder library see docs here : https://github.com/StoutLogic/acf-builder/wiki
    */
    public function setBuilder(FieldsBuilder $builder): void
    {
        $builder
            ->addGroup('title', [
                'label' => 'Titre',
            ])
                ->addText('title_1', [
                    'label' => 'Titre 1',
                ])
                ->addText('title_2', [
                    'label' => 'Titre 2',
                ])
            ->endGroup()
            ->addField(
                'image_left',
                'image_aspect_ratio_crop',
                $this->getImageCropData(
                    665,
                    570,
                    'Image de gauche'
                ),
            )
            ->addField(
                'image_right',
                'image_aspect_ratio_crop',
                $this->getImageCropData(
                    665,
                    570,
                    'Image de droite'
                ),
            )
            ->addSelect('background', [
                'label' => 'Couleur du fond',
                'choices' => $this->getColorChoicesBackground(),
            ])
            ->addSelect(
                'bottom_padding',
                [
                    'label' => 'Padding bas du composant',
                    'choices' => [
                        'with' => 'Avec',
                        'without' => 'Sans',
                    ],
                    'default_value' => 'with',
                ]
            )
        ;

        $this->addBlockMarginSelect($builder);
    }
}
