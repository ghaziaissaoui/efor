<?php

declare(strict_types=1);

namespace App\Components\Traits;

use StoutLogic\AcfBuilder\FieldsBuilder;

trait AcfBuilderTrait
{
    private function getColorChoices(): array
    {
        return [
            'white' => 'Blanc',
            'black-graphite' => 'Noir graphite',
            'green' => 'Vert',
            'gold' => 'Doré',
        ];
    }

    private function getColorChoicesBackground(): array
    {
        return [
            'white' => 'Blanc',
            'gray-20' => 'Gris clair',
            'green' => 'Vert',
            'black-graphite' => 'Noir',
        ];
    }

    private function getImageCropData(
        int $width,
        int $height,
        string $label = 'Image'
    ): array {
        return [
            'crop_type' => 'aspect_ratio',
            'aspect_ratio_width' => $width,
            'aspect_ratio_height' => $height,
            'label' => $label,
        ];
    }

    private function getButtonColorFromBackground(string $color): string
    {
        return match ($color) {
            'green', 'gold-secondary' => 'black',
            'black-graphite' => 'gold',
            default => 'black-graphite',
        };
    }

    private function alongsideComponentBuilder(FieldsBuilder $builder): void
    {
        $builder
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
            ->addSelect('alignement_vertical', [
                    'label' => 'Alignement du titre',
                    'choices' => [
                        'u-justify-content-start' => 'Haut du bloc',
                        'u-justify-content-center' => 'Milieu du bloc',
                    ]
                ])
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
                    'label' => 'Citation'
                ])
                    ->conditional('section_type', '==', 'quote')
                ->addText('author', [
                    'label' => 'Auteur',
                ])
                    ->conditional('section_type', '==', 'quote')
                ->endRepeater()
        ;

        $this->addBlockMarginSelect($builder);
    }

    private function addBlockMarginSelect(FieldsBuilder $builder): void
    {
        $builder
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
        ;
    }
}
