<?php

namespace App\Components\HeroComponent;

use App\Components\Traits\AcfBuilderTrait;
use App\Core\AbstractComponent;
use App\Services\BuilderService;
use App\Services\Image;
use StoutLogic\AcfBuilder\FieldsBuilder;

if (!defined('ABSPATH')) {
    exit('Cheatin&#8217; uh?');
}

class HeroComponent extends AbstractComponent
{
    use AcfBuilderTrait;

    protected string $name = 'Hero Component';

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
        if (!empty($id = $data['image_small']['ID'] ?? null)) {
            $data['image_small'] = $this->image->getImageTag(
                $id,
                $this->image::HERO_SMALL,
                ['class' => 'ratio-block__content']
            );
        }

        if (!empty($id = $data['image_full']['ID'] ?? null)) {
            $data['image_full'] = $this->image->getImageTag(
                $id,
                $this->image::HERO_FULL,
                ['class' => 'ratio-block__content']
            );
        }

        if (!empty($data['link_1_color'])) {
            $data['link_1_color_text'] = $this->getButtonColorFromBackground($data['link_1_color']);
        }

        if (!empty($data['link_2_color'])) {
            $data['link_2_color_text'] = $this->getButtonColorFromBackground($data['link_2_color']);
        }

        return $data;
    }

    /*
    * ACF config for both Gutenberg and flexible component are created here using the FieldsBuilder library see docs here : https://github.com/StoutLogic/acf-builder/wiki
    */
    public function setBuilder(FieldsBuilder $builder): void
    {
        $builder
            ->addSelect('hero_type', [
                'label' => 'Type de Hero',
                'required' => 1,
                'choices' => [
                    'sided' => 'Sided image',
                    'no_image' => 'No image',
                    'full_image' => 'Full image',
                ],
                'allow_null' => 0,
            ])
            ->addField(
                'image_small',
                'image_aspect_ratio_crop',
                $this->getImageCropData(661, 539),
            )
                ->conditional('hero_type', '==', 'sided')
            ->addField(
                'image_full',
                'image_aspect_ratio_crop',
                $this->getImageCropData(1360, 720),
            )
                ->conditional('hero_type', '==', 'full_image')
            ->addGroup('title', [
                'label' => 'Titre',
            ])
            ->addText('title_1', [
                'label' => 'Titre 1',
            ])
            ->addText('title_2', [
                'label' => 'Titre 2',
            ])
            ->addSelect('title_type_html', [
                'label' => 'Niveau de titre',
                'required' => 1,
                'choices' => [
                    'h1' => 'Titre principal (h1)',
                    'h2' => 'Titre secondaire (h2)',
                ]
            ])
            ->endGroup()
            ->addSelect('content_type', [
                'label' => 'Type de contenu',
                'choices' => [
                    'content' => 'Contenu',
                    'baseline' => 'Baseline',
                ]
            ])
            ->addTextArea('content', [
                'label' => 'Contenu',
            ])
                ->conditional('content_type', '==', 'content')
            ->addTextArea('baseline', [
                'label' => 'Baseline',
            ])
                ->conditional('content_type', '==', 'baseline')
            ->addlink('link_1', [
                'label' => 'Bouton 1',
            ])
            ->addTrueFalse('link_1_icon', [
                'label' => 'Icon Téléchargement',
                'default_value' => 0,
            ])
            ->addSelect('link_1_color', [
                'label' => 'Couleur du bouton',
                'choices' => $this->getColorChoices(),
                'allow_null' => 0,
            ])
            ->addlink('link_2', [
                'label' => 'Bouton 2',
            ])
            ->addTrueFalse('link_2_icon', [
                'label' => 'Icon Téléchargement',
                'default_value' => 0,
            ])
            ->addSelect('link_2_color', [
                'label' => 'Couleur du bouton',
                'choices' => $this->getColorChoices(),
                'allow_null' => 0,
            ])
        ;

        $this->addBlockMarginSelect($builder);
    }
}
