<?php

namespace App\Components\AuditComponent;

use App\Components\Traits\AcfBuilderTrait;
use App\Core\AbstractComponent;
use App\Services\BuilderService;
use App\Services\Image;
use StoutLogic\AcfBuilder\FieldsBuilder;

use function App\getTextColorBasedOnBackground;

if (!defined('ABSPATH')) {
    exit('Cheatin&#8217; uh?');
}

class AuditComponent extends AbstractComponent
{
    use AcfBuilderTrait;

    protected string $name = 'Audit Component';

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
        foreach (['left_image', 'right_image'] as $img) {
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
            ->addField(
                'left_image',
                'image_aspect_ratio_crop',
                $this->getImageCropData(555, 400),
            )
            ->addText('title_1', [
                'label' => 'Titre',
            ])
            ->addWysiwyg('content_1', [
                'label' => 'Contenu',
            ])
            ->addField(
                'right_image',
                'image_aspect_ratio_crop',
                $this->getImageCropData(555, 400),
            )
            ->addText('title_2', [
                'label' => 'Titre',
            ])
            ->addWysiwyg('content_2', [
                'label' => 'Contenu',
            ])
            ->addSelect('background', [
                'label' => 'Couleur du fond',
                'choices' => $this->getColorChoicesBackground(),
            ])
        ;

        $this->addBlockMarginSelect($builder);
    }
}
