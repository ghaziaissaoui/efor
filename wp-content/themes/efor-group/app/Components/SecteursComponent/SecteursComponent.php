<?php

namespace App\Components\SecteursComponent;

use App\Components\Traits\AcfBuilderTrait;
use App\Core\AbstractComponent;
use App\Services\BuilderService;
use App\Services\Image;
use StoutLogic\AcfBuilder\FieldsBuilder;

if (!defined('ABSPATH')) {
    exit('Cheatin&#8217; uh?');
}

class SecteursComponent extends AbstractComponent
{
    use AcfBuilderTrait;

    protected string $name = 'Secteurs Component';

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
        if (!empty($id = ($data['image']['ID'] ?? null))) {
            $data['image'] = $this->image->getImageTag(
                $id,
                $this->image::HERO_FULL,
                $this->image::DEFAULT_CLASS
            );
        }

        if (!empty($data['link_color'])) {
            $data['link_color_text'] = $this->getButtonColorFromBackground($data['link_color']);
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
            ->addWysiwyg('content', [
                'label' => 'Contenu'
            ])
            ->addLink('link', [
                'label' => 'Lien'
            ])
            ->addSelect('link_color', [
                'label' => 'Couleur du bouton',
                'required' => 1,
                'choices' => $this->getColorChoices(),
                'allow_null' => 0,
            ])
            ->addField(
                'image',
                'image_aspect_ratio_crop',
                $this->getImageCropData(1390, 750),
            )
        ;
    }
}
