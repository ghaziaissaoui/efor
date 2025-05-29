<?php

namespace App\Components\ExpertisesComponent;

use App\Components\Traits\AcfBuilderTrait;
use App\Core\AbstractComponent;
use App\Services\BuilderService;
use App\Services\Image;
use StoutLogic\AcfBuilder\FieldsBuilder;

if (!defined('ABSPATH')) {
    exit('Cheatin&#8217; uh?');
}

class ExpertisesComponent extends AbstractComponent
{
    use AcfBuilderTrait;

    protected string $name = 'Expertises Component';

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
        if (!empty($data['expertises'])) {
            foreach ($data['expertises'] as &$expertise) {
                if (!empty($id = $expertise['icon']['ID'])) {
                    $expertise['icon'] = $this->image->getImageTag(
                        $id,
                        'thumbnail',
                        $this->image::DEFAULT_CLASS
                    );
                }

                $expertise['text_color'] = 'gray-40' === $expertise['color'] ? 'white' : 'black-graphite';
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
            ])
            ->addRepeater('expertises', [
                'label' => 'Expertises',
                'min' => 1,
                'button_label' => 'Ajouter une expertise',
                'layout' => 'row',
            ])
                ->addField(
                    'icon',
                    'image_aspect_ratio_crop',
                    $this->getImageCropData(100, 100),
                )
                ->addLink('lien', [
                    'label' => 'Lien de l\'expertise',
                ])
                ->addSelect('color', [
                    'label' => 'Couleur de la carte',
                    'choices' => [
                        'gray-40' => 'Gris',
                        'gray-20' => 'Gris clair',
                    ],
                    'allow_null' => 0,
                ])
        ;

        $this->addBlockMarginSelect($builder);
    }
}
