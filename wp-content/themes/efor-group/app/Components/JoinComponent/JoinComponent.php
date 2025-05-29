<?php

namespace App\Components\JoinComponent;

use App\Components\Traits\AcfBuilderTrait;
use App\Core\AbstractComponent;
use App\Services\BuilderService;
use App\Services\Image;
use StoutLogic\AcfBuilder\FieldsBuilder;

use function App\getTextColorBasedOnBackground;

if (!defined('ABSPATH')) {
    exit('Cheatin&#8217; uh?');
}

class JoinComponent extends AbstractComponent
{
    use AcfBuilderTrait;

    protected string $name = 'Join Component';

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
                $slide = $this->formatSlide($slide);
            }
        }

        if (!empty($data['background'])) {
            $data['global_text_color'] = getTextColorBasedOnBackground($data['background']);
        }

        return $data;
    }

    /*
     * Format each slides of the component depending on the selected layout chosen in the component
     */
    private function formatSlide(array $slide): array
    {
        $isVideo = false;

        switch ($slide['layout']) {
            case 'layout_1':
                if (!empty($id = ($slide['image_small_layout_1']['ID'] ?? null))) {
                    $media1 = $this->image->getImageTag(
                        $id,
                        $this->image::JOIN_LAYOUT_1_SMALL,
                        $this->image::DEFAULT_CLASS
                    );
                }

                if (!empty($id = ($slide['image_medium_layout_1']['ID'] ?? null))) {
                    $preview = $this->image->getImageTag(
                        $id,
                        $this->image::JOIN_LAYOUT_1_MEDIUM,
                        $this->image::DEFAULT_CLASS
                    );
                }

                $media2 = $this->image->formatVideoOrImage(
                    $slide,
                    $preview ?? null,
                    'img__right',
                    'ratio-block--9/16',
                    false,
                    $isVideo
                );
                break;
            case 'layout_2':
                if (!empty($id = $slide['image_large_layout_2']['ID'] ?? null)) {
                    $media1 = $this->image->getImageTag(
                        $id,
                        $this->image::JOIN_LAYOUT_2_LARGE,
                        $this->image::DEFAULT_CLASS
                    );
                }

                if (!empty($id = $slide['image_small_layout_2']['ID'] ?? null)) {
                    $media2 = $this->image->getImageTag(
                        $id,
                        $this->image::JOIN_LAYOUT_2_SMALL,
                        $this->image::DEFAULT_CLASS
                    );
                }

                break;
            case 'layout_3':
                if (!empty($id = $slide['image_layout_3']['ID'] ?? null)) {
                    $preview = $this->image->getImageTag(
                        $id,
                        $this->image::JOIN_LAYOUT_3,
                        $this->image::DEFAULT_CLASS
                    );
                }

                $media1 = $this->image->formatVideoOrImage(
                    $slide,
                    $preview ?? null,
                    '',
                    'ratio-block--418/315 @lg:ratio-block--16/9',
                    false,
                    $isVideo
                );
                break;
            default:
                break;
        }

        return [
            'title' => $slide['title'],
            'content' => $slide['content'],
            'layout' => $slide['layout'],
            'media_1' => $media1 ?? null,
            'media_2' => $media2 ?? null,
            'isVideo' => $isVideo,
        ];
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
                ->conditional('title_type', '==', 'h2')
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
            ->addRepeater('slides', [
                'label' => 'Slides',
                'min' => 1,
                'max' => 4,
                'layout' => 'row',
                'button_label' => 'Ajouter une slide',
            ])
                ->addText('title', [
                    'label' => 'Titre',
                ])
                ->addWysiwyg('content', [
                    'label' => 'Contenu',
                    'toolbar' => 'basic',
                ])
                ->addSelect('layout', [
                    'label' => 'Choix de la mise en forme',
                    'choices' => [
                        'layout_1' => 'Image et video sur la droite',
                        'layout_2' => 'Deux images sous le texte',
                        'layout_3' => 'Image ou vidéo grand simple',
                        'layout_4' => 'Texte simple (sans photo)',
                    ]
                ])
                ->addField(
                    'image_small_layout_1',
                    'image_aspect_ratio_crop',
                    $this->getImageCropData(
                        264,
                        310,
                        'Image de gauche'
                    ),
                )
                    ->conditional('layout', '==', 'layout_1')
                ->addField(
                    'image_medium_layout_1',
                    'image_aspect_ratio_crop',
                    $this->getImageCropData(
                        360,
                        525,
                        'Image de droite (Sert de preview dans le cas d`une vidéo)'
                    ),
                )
                    ->conditional('layout', '==', 'layout_1')
                ->addImage('video', [
                    'label' => 'Vidéo (prioritaire sur l\'image de droite',
                    'mime_types' => 'mp4'
                ])
                    ->conditional('layout', '==', 'layout_1')
                        ->or('layout', '==', 'layout_3')
                ->addOembed('youtube', [
                    'label' => 'Vidéo Youtube',
                ])
                    ->conditional('layout', '==', 'layout_1')
                        ->or('layout', '==', 'layout_3')
                ->addField(
                    'image_large_layout_2',
                    'image_aspect_ratio_crop',
                    $this->getImageCropData(
                        795,
                        300,
                        'Image de gauche'
                    ),
                )
                    ->conditional('layout', '==', 'layout_2')
                ->addField(
                    'image_small_layout_2',
                    'image_aspect_ratio_crop',
                    $this->getImageCropData(
                        325,
                        300,
                        'Image de droite'
                    ),
                )
                    ->conditional('layout', '==', 'layout_2')
                ->addField(
                    'image_layout_3',
                    'image_aspect_ratio_crop',
                    $this->getImageCropData(
                        570,
                        600,
                        'Image (Sert de preview dans le cas d`une vidéo)'
                    ),
                )
                    ->conditional('layout', '==', 'layout_3')
            ->endRepeater()
        ;

        $this->addBlockMarginSelect($builder);
    }
}
