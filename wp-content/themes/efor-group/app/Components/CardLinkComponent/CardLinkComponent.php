<?php

namespace App\Components\CardLinkComponent;

use App\Components\Traits\AcfBuilderTrait;
use App\Core\AbstractComponent;
use App\Services\BuilderService;
use App\Services\Image;
use StoutLogic\AcfBuilder\FieldsBuilder;

if (!defined('ABSPATH')) {
    exit('Cheatin&#8217; uh?');
}

class CardLinkComponent extends AbstractComponent
{
    use AcfBuilderTrait;

    protected string $name = 'Card Link Component';

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
        foreach (['left_section', 'right_section'] as $section) {
            if (!empty($id = ($data[$section]['image']['ID'] ?? null))) {
                $data[$section]['image'] = $this->image->getImageSrc($id, $this->image::HERO_SMALL);
                $data[$section]['background'] = true;
            } else {
                $data[$section]['background'] = false;
            }

            if (!empty($color = $data[$section]['link_color'])) {
                $data[$section]['link_color_text'] = $this->getButtonColorFromBackground($color);
            }

            if (true === $data[$section]['background']) {
                $data[$section]['background_style'] = sprintf(
                    'style="background-image: url(\'%s\');"',
                    $data[$section]['image']
                );
            }
        }

        return $data;
    }

    /*
    * ACF config for both Gutenberg and flexible component are created here using the FieldsBuilder library see docs here : https://github.com/StoutLogic/acf-builder/wiki
    */
    public function setBuilder(FieldsBuilder $builder): void
    {
        $this->setGroup($builder, 'left_section', 'Section de gauche');
        $this->setGroup($builder, 'right_section', 'Section de droite');
        $this->addBlockMarginSelect($builder);
    }

    private function setGroup(FieldsBuilder $builder, string $groupName, string $groupLabel): void
    {
        $builder
            ->addGroup($groupName, [
                'label' => $groupLabel,
            ])
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
                ->addTextArea('content', [
                    'label' => 'Contenu',
                ])
                ->addField(
                    'image',
                    'image_aspect_ratio_crop',
                    $this->getImageCropData(600, 340),
                )
                ->addlink('link', [
                    'label' => 'Bouton',
                ])
                ->addSelect('link_color', [
                    'label' => 'Couleur du bouton',
                    'required' => 1,
                    'choices' => $this->getColorChoices(),
                    'allow_null' => 0,
                ])
            ->endGroup()
        ;
    }
}
