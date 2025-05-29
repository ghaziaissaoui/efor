<?php

namespace App\Components\StrategyComponent;

use App\Components\ContentAlongsideComponent\ContentAlongsideComponent;
use App\Components\FullWImgComponent\FullWImgComponent;
use App\Components\Traits\AcfBuilderTrait;
use App\Core\AbstractComponent;
use App\Core\ComponentsManager;
use App\Services\BuilderService;
use App\Services\Image;
use StoutLogic\AcfBuilder\FieldsBuilder;

use function App\getTextColorBasedOnBackground;
use function App\slugify;

if (!defined('ABSPATH')) {
    exit('Cheatin&#8217; uh?');
}

class StrategyComponent extends AbstractComponent
{
    use AcfBuilderTrait;

    protected string $name = 'Strategy Component';

    protected bool $isFlexibleComponent = true; //true to enable flexible
    protected bool $isGutenbergBlock = true; //true to enable gutenberg block
    private Image $image;
    private ComponentsManager $componentsManager;

    public function __construct(
        BuilderService $builder,
        Image $image,
        ComponentsManager $componentsManager
    ) {
        parent::__construct($builder);
        $this->image = $image;
        $this->componentsManager = $componentsManager;
    }

    /*
    * Use this method to modify the ACF field data before returning it to the component's view (default: return base ACF data)
    */
    public function sanitize($data)
    {
        if (!empty($data['items'])) {
            $images = [
                'image_anchor_small' => $this->image::STRATEGY_SMALL_ANCHOR,
                'image_anchor_large' => $this->image::STRATEGY_LARGE_ANCHOR,
            ];

            foreach ($data['items'] as &$item) {
                foreach ($images as $key => $size) {
                    if (!empty($id = ($item[$key]['ID'] ?? null))) {
                        $item[$key] = $this->formatImg($id, $size);
                    }
                }

                if (!empty($item['background'])) {
                    $item['global_text_color'] = getTextColorBasedOnBackground($item['background']);
                }

                if (!empty($item['link_color'])) {
                    $item['link_color_text'] = $this->getButtonColorFromBackground($item['link_color']);
                }

                $item['anchorId'] = slugify($item['title_anchor']);

                if (!empty($item['image'])) {
                    $item['image'] = $this->componentsManager->render(
                        FullWImgComponent::class,
                        [
                            'image' => $item['image'],
                            'bottom_margin' => $item['bottom_margin_image'],
                        ]
                    );
                }

                //include ContentAlongsideComponent with data
                $item['section'] = $this->componentsManager->render(ContentAlongsideComponent::class, $item);
            }
        }

        return $data;
    }

    private function formatImg(int $id, string $imgFormat = 'medium'): string
    {
        return $this->image->getImageTag(
            $id,
            $imgFormat,
            ['class' => 'ratio-block__content']
        );
    }

    /*
    * ACF config for both Gutenberg and flexible component are created here using the FieldsBuilder library see docs here : https://github.com/StoutLogic/acf-builder/wiki
    */
    public function setBuilder(FieldsBuilder $builder): void
    {
        $builder
            ->addText('title_component', [
                'label' => 'Titre',
            ])
            ->addRepeater('items', [
                'label' => 'Ancres et sections',
                'min' => 1,
                'button_label' => 'Ajouter une ancre et une section',
                'layout' => 'row',
            ])
                ->addText('title_anchor', [
                    'label' => 'Titre de l\'ancre (optionnel)',
                ])
                ->addField(
                    'image_anchor_small',
                    'image_aspect_ratio_crop',
                    $this->getImageCropData(
                        610,
                        180,
                        'Image de l\'ancre (format réduit)'
                    )
                )
                ->addSelect('alignement_vertical', [
                    'label' => 'Alignement du titre',
                    'choices' => [
                        'u-justify-content-start' => 'Haut du bloc',
                        'u-justify-content-center' => 'Milieu du bloc',
                    ]
                ])
                ->addField(
                    'image_anchor_large',
                    'image_aspect_ratio_crop',
                    $this->getImageCropData(
                        1260,
                        180,
                        'Image de l\'ancre (format étiré)'
                    )
                )
                ->addField(
                    'image',
                    'image_aspect_ratio_crop',
                    $this->getImageCropData(
                        1260,
                        485,
                        'Image de la section'
                    )
                )
                ->addSelect(
                    'bottom_margin_image',
                    [
                        'label' => 'Marge basse de l\'image de la section',
                        'choices' => [
                            'with' => 'Avec',
                            'without' => 'Sans',
                        ],
                        'default_value' => 'with',
                    ]
                )
                ->addSelect('title_type', [
                    'label' => 'Type de Titre',
                    'required' => 1,
                    'choices' => [
                        'h2' => 'Titre deux partie (h2)',
                        'h3' => 'Titre simple (h3)',
                    ],
                ])
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
                ->addText('title_simple', [
                    'label' => 'Titre',
                ])
                    ->conditional('title_type', '==', 'h3')
                ->addSelect('image_format', [
                    'label' => 'Format de l\'image',
                    'choices' => [
                        'small' => 'Petite',
                        'large' => 'Grande',
                        'extra_small' => 'Très petite',
                    ]
                ])
                ->addField(
                    'image_small',
                    'image_aspect_ratio_crop',
                    $this->getImageCropData(490, 400),
                )
                    ->conditional('image_format', '==', 'small')
                ->addField(
                    'image_large',
                    'image_aspect_ratio_crop',
                    $this->getImageCropData(490, 660),
                )
                    ->conditional('image_format', '==', 'large')
                ->addField(
                    'image_extra_small',
                    'image_aspect_ratio_crop',
                    $this->getImageCropData(490, 306),
                )
                    ->conditional('image_format', '==', 'extra_small')
                ->addSelect('background', [
                    'label' => 'Couleur du fond',
                    'choices' => $this->getColorChoicesBackground(),
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
                ->addSelect(
                    'bottom_margin',
                    [
                        'label' => 'Marge basse du composant',
                        'choices' => [
                            'with' => 'Avec',
                            'without' => 'Sans',
                        ],
                        'default_value' => 'with',
                    ]
                )
                ->addRepeater('content', [
                    'label' => 'Contenus',
                    'min' => 1,
                    'button_label' => 'Ajouter une section',
                    'layout' => 'block',
                ])
                    ->addSelect('section_type', [
                        'label' => 'Type de section',
                        'choices' => [
                            'title_and_content' => 'Texte + Titre (optionnel)',
                            'accordion' => 'Accordéon',
                            'quote' => 'Citation',
                        ]
                    ])
                    ->addText('title', [
                        'label' => 'Titre (optionnel)',
                    ])
                        ->conditional('section_type', '==', 'title_and_content')
                    ->addWysiwyg('content', [
                        'label' => 'Contenu',
                        'toolbar' => 'basic',
                    ])
                        ->conditional('section_type', '==', 'title_and_content')
                    ->addTrueFalse('display_indexes', [
                        'label' => 'Afficher les index',
                        'default_value' => 1,
                        'ui_on_text' => 'Oui',
                        'ui_off_text' => 'Non',
                    ])
                    ->conditional('section_type', '==', 'accordion')
                    ->addRepeater('accordion', [
                        'label' => 'Accordéon',
                        'min' => 1,
                        'layout' => 'block',
                        'button_label' => 'Ajouter un niveau d\'accordéon',
                    ])
                        ->conditional('section_type', '==', 'accordion')
                        ->addText('accordion_title', [
                            'label' => 'Titre du niveau',
                        ])
                        ->addWysiwyg('accordion_content', [
                            'label' => 'Contenu',
                            'toolbar' => 'basic',
                        ])
                    ->endRepeater()
                    ->addTextarea('quote', [
                        'label' => 'Citation',
                    ])
                        ->conditional('section_type', '==', 'quote')
                    ->addText('author', [
                        'label' => 'Auteur',
                    ])
                        ->conditional('section_type', '==', 'quote')
                ->endRepeater()
                ->addGroup('endbloc-quotation', [
                    'label' => 'Bloc Citation',
                ])
                    ->addSelect('color_scheme', [
                        'label' => 'Couleur du bouton',
                        'choices' => [
                            '' => 'Fond blanc & texte noir',
                            'inverted' => 'Fond noir & texte blanc',
                        ],
                        'allow_null' => 0,
                    ])
                    ->addTextarea('content', [
                        'label' => 'Contenu',
                        'instructions' => '',
                        'required' => 0,
                        'default_value' => '',
                        'placeholder' => '',
                        'maxlength' => '',
                        'rows' => '',
                        'new_lines' => '',
                    ])
                ->endGroup()
        ;
    }
}
