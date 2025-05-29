<?php

namespace App\Components\RejoindreComponent;

use App\Components\Traits\AcfBuilderTrait;
use App\Core\AbstractComponent;
use App\Services\BuilderService;
use App\Services\Image;
use StoutLogic\AcfBuilder\FieldsBuilder;

use function App\getTextColorBasedOnBackground;

if (!defined('ABSPATH')) {
    exit('Cheatin&#8217; uh?');
}

class RejoindreComponent extends AbstractComponent
{
    use AcfBuilderTrait;

    protected string $name = 'Rejoindre Component';

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
                'label' => 'Contenu',
                'toolbar' => 'basic',
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
        ;

        $this->addBlockMarginSelect($builder);
    }
}
