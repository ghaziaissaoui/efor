<?php

namespace App\Components\ImgLandscapeBtnComponent;

use App\Components\Traits\AcfBuilderTrait;
use App\Core\AbstractComponent;
use App\Services\BuilderService;
use App\Services\Image;
use StoutLogic\AcfBuilder\FieldsBuilder;

if (!defined('ABSPATH')) {
    exit('Cheatin&#8217; uh?');
}

class ImgLandscapeBtnComponent extends AbstractComponent
{
    use AcfBuilderTrait;

    protected string $name = 'Img Landscape Btn Component';

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
                $this->image::CONTACT_FULL,
                ['class' => 'ratio-block__content'],
            );
        }

        //force stand alone use by default
        if (false === isset($data['stand_alone'])) {
            $data['stand_alone'] = true;
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
            ->addField(
                'image',
                'image_aspect_ratio_crop',
                $this->getImageCropData(1060, 310),
            )
            ->addLink('link', [
                'label' => 'Lien',
            ])
            ->addSelect('link_color', [
                'label' => 'Couleur du bouton',
                'choices' => $this->getColorChoices(),
                'allow_null' => 0,
            ])
        ;

        $this->addBlockMarginSelect($builder);
    }
}
