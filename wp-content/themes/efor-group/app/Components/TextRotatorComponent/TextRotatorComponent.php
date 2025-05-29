<?php

namespace App\Components\TextRotatorComponent;

use App\Components\Traits\AcfBuilderTrait;
use App\Core\AbstractComponent;
use StoutLogic\AcfBuilder\FieldsBuilder;

if (!defined('ABSPATH')) {
    exit('Cheatin&#8217; uh?');
}

class TextRotatorComponent extends AbstractComponent
{
    use AcfBuilderTrait;

    protected string $name = 'Text Rotator Component';

    protected bool $isFlexibleComponent = true; //true to enable flexible
    protected bool $isGutenbergBlock = true; //true to enable gutenberg block

    /*
    * Use this method to modify the ACF field data before returning it to the component's view (default: return base ACF data)
    */
    public function sanitize($data)
    {
        return $data;
    }

    /*
    * ACF config for both Gutenberg and flexible component are created here using the FieldsBuilder library see docs here : https://github.com/StoutLogic/acf-builder/wiki
    */
    public function setBuilder(FieldsBuilder $builder): void
    {
        $builder
            ->addTrueFalse('display_number', [
                'label' => 'Afficher les numéros',
                'default_value' => 1,
                'ui' => 1,
            ])
            ->addWysiwyg('text_rotator_content', [
                'label' => 'Contenu texte',
                'instructions' => 'Contenu affiché à droite. Les contenus trop longs sont à éviter pour garder une cohérence de style.',
                'tabs' => 'visual',
                'toolbar' => 'basic',
                'media_upload' => 0,
            ])
            ->addRepeater('titles', ['label' => 'Titres','min' => 1, 'layout' => 'block'])
                ->addText('text_rotator_title', [
                    'label' => 'Titre',
                    'instructions' => 'Le numéro de ligne de ce titre correspondra au numéro affiché à droite de celui-ci. Cet ordre est modifiable (drag & drop).',
                    'required' => 1,
                ])
        ;

        $this->addBlockMarginSelect($builder);
    }
}
