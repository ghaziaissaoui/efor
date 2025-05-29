<?php

namespace App\Components\ChiffresComponent;

use App\Components\Traits\AcfBuilderTrait;
use App\Core\AbstractComponent;
use StoutLogic\AcfBuilder\FieldsBuilder;

use function App\getTextColorBasedOnBackground;

if (!defined('ABSPATH')) {
    exit('Cheatin&#8217; uh?');
}

class ChiffresComponent extends AbstractComponent
{
    use AcfBuilderTrait;

    protected string $name = 'Chiffres Component';

    protected bool $isFlexibleComponent = true; //true to enable flexible
    protected bool $isGutenbergBlock = true; //true to enable gutenberg block

    /*
    * Use this method to modify the ACF field data before returning it to the component's view (default: return base ACF data)
    */
    public function sanitize($data)
    {
        if (!empty($data['chiffres'])) {
            foreach ($data['chiffres'] as &$chiffre) {
                $chiffre['text_color'] = getTextColorBasedOnBackground($chiffre['background']);
            }
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
                    'label' => 'Title 1',
                ])
                ->addText('title_2', [
                    'label' => 'Title 2',
                ])
            ->endGroup()
            ->addTextarea('content', [
                'label' => 'Contenu',
            ])
            ->addLink('link', [
                'label' => 'Bouton',
            ])
            ->addSelect('link_color', [
                'label' => 'Couleur du bouton',
                'required' => 1,
                'choices' => $this->getColorChoices(),
                'allow_null' => 0,
            ])
            ->addRepeater('chiffres', [
                'label' => 'Chiffres',
                'min' => 1,
                'max' => 3,
                'layout' => 'row',
                'button_label' => 'Ajouter une carte chiffre',
            ])
                ->addText('title', [
                    'label' => 'Titre',
                ])
                ->addText('content', [
                    'label' => 'Contenu'
                ])
                ->addSelect('background', [
                    'label' => 'Couleur du fond',
                    'choices' => $this->getColorChoices(),
                ])
            ->endRepeater()
        ;

        $this->addBlockMarginSelect($builder);
    }
}
