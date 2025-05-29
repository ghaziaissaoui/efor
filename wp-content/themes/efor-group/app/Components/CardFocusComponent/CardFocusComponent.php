<?php

namespace App\Components\CardFocusComponent;

use App\Components\Traits\AcfBuilderTrait;
use App\Core\AbstractComponent;
use StoutLogic\AcfBuilder\FieldsBuilder;

use function App\getTextColorBasedOnBackground;

if (!defined('ABSPATH')) {
    exit('Cheatin&#8217; uh?');
}

class CardFocusComponent extends AbstractComponent
{
    use AcfBuilderTrait;

    protected string $name = 'CardFocus Component';

    protected bool $isFlexibleComponent = true; //true to enable flexible
    protected bool $isGutenbergBlock = true; //true to enable gutenberg block

    /*
    * Use this method to modify the ACF field data before returning it to the component's view (default: return base ACF data)
    */
    public function sanitize($data)
    {
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
            ->addText('title', [
                'label' => 'Titre',
            ])
            ->addTextarea('content', [
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
