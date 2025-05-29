<?php

namespace App\Components\CarouselComponent;

use App\Components\Traits\AcfBuilderTrait;
use App\Core\AbstractComponent;
use App\Services\BuilderService;
use App\Services\Image;
use StoutLogic\AcfBuilder\FieldsBuilder;

if (!defined('ABSPATH')) {
    exit('Cheatin&#8217; uh?');
}

class CarouselComponent extends AbstractComponent
{
    use AcfBuilderTrait;

    protected string $name = 'Carousel Component';

    protected bool $isFlexibleComponent = true; //true to enable flexible
    protected bool $isGutenbergBlock = true; //true to enable gutenberg block
    private Image $image;

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
        if (!empty($data['gallery'])) {
            foreach ($data['gallery'] as &$slide) {
                if (!empty($slide['image'])) {
                    $slide['image'] = $this->image->getImageTag(
                        $slide['image']['ID'],
                        $this->image::CAROUSEL_CARD,
                        ['class' => 'ratio-block__content']
                    );
                }
            }
        }

        return $data;
    }

    /*
    * ACF config for both Gutenberg and flexible component are created here using the FieldsBuilder library see docs here : https://github.com/StoutLogic/acf-builder/wiki
    */
    public function setBuilder(FieldsBuilder $builder): void
    {
        $builder
            ->addText('title', [
                'label' => 'titre',
            ])
            ->addRepeater('gallery', [
                'label' => 'Gallerie d\'image',
                'min' => 1,
                'layout' => 'row',
                'button_label' => 'Ajouter une slide',
            ])
                ->addField(
                    'image',
                    'image_aspect_ratio_crop',
                    $this->getImageCropData(1280, 720),
                )
                ->addText('caption', [
                    'label' => 'Legende (optionnelle)',
                ])
            ->endRepeater()
        ;

        $this->addBlockMarginSelect($builder);
    }
}
