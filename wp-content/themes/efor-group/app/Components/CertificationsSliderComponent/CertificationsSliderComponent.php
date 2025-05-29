<?php

namespace App\Components\CertificationsSliderComponent;

use App\Components\Traits\AcfBuilderTrait;
use App\Core\AbstractComponent;
use App\Services\BuilderService;
use App\Services\Image;
use StoutLogic\AcfBuilder\FieldsBuilder;

use function App\getTextColorBasedOnBackground;

if (!defined('ABSPATH')) {
    exit('Cheatin&#8217; uh?');
}

class CertificationsSliderComponent extends AbstractComponent
{
    use AcfBuilderTrait;

    protected string $name = 'Certifications Slider Component';

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
        if (!empty($data['slides'])) {
            foreach ($data['slides'] as &$slide) {
                if (!empty($slide['image'])) {
                    $slide['image'] = $this->image->getImageTag(
                        $slide['image']['ID'],
                        $this->image::CERTIFICATION_SLIDE,
                        ['class' => 'ratio-block__content']
                    );
                }
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
            ->addSelect('background', [
                'label' => 'Couleur du fond',
                'choices' => $this->getColorChoicesBackground(),
            ])
            ->addSelect('with_images', [
                'label' => 'Avec ou sans image',
                'choices' => [
                    'true' => 'Avec',
                    'false' => 'Sans'
                ],
            ])
            ->addRepeater('slides', [
                'label' => 'Slide',
                'min' => 1,
                'button_label' => 'Ajouter une slide',
                'layout' => 'row',
            ])
                ->addText('title', [
                    'label' => 'Titre',
                ])
                ->addWysiwyg('content', [
                    'label' => 'Contenu',
                    'toolbar' => 'basic',
                ])
                ->addField(
                    'image',
                    'image_aspect_ratio_crop',
                    $this->getImageCropData(
                        556,
                        405,
                        'Image (optionnelle)'
                    ),
                )
            ->endRepeater()
        ;

        $this->addBlockMarginSelect($builder);
    }
}
