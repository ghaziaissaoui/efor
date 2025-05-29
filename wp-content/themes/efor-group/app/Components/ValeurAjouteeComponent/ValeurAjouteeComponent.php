<?php

namespace App\Components\ValeurAjouteeComponent;

use App\Components\Traits\AcfBuilderTrait;
use App\Core\AbstractComponent;
use App\Services\BuilderService;
use App\Services\Image;
use StoutLogic\AcfBuilder\FieldsBuilder;

use function App\getTextColorBasedOnBackground;

if (!defined('ABSPATH')) {
    exit('Cheatin&#8217; uh?');
}

class ValeurAjouteeComponent extends AbstractComponent
{
    use AcfBuilderTrait;

    protected string $name = 'Valeur Ajoutee Component';

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
        if (!empty($data['cards'])) {
            foreach ($data['cards'] as &$card) {
                if (!empty($id = $card['logo']['ID'])) {
                    $card['logo'] = $this->image->getImageTag(
                        $id,
                        'thumbnail',
                        $this->image::DEFAULT_CLASS
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
            ->addWysiwyg('content', [
                'label' => 'Content',
            ])
            ->addSelect('background', [
                'label' => 'Couleur du fond',
                'choices' => $this->getColorChoicesBackground(),
            ])
            ->addRepeater('cards', [
                'label' => 'Cartes',
            ])
                ->addField(
                    'logo',
                    'image_aspect_ratio_crop',
                    $this->getImageCropData(100, 100),
                )
                ->addText('title', [
                    'label' => 'Titre',
                ])
                ->addWysiwyg('description', [
                    'label' => 'Description',
                ])
        ;

        $this->addBlockMarginSelect($builder);
    }
}
