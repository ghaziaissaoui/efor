<?php

namespace App\Components\SidebarComponent;

use App\Core\AbstractComponent;
use StoutLogic\AcfBuilder\FieldsBuilder;

use function App\getOptionField;

if (!defined('ABSPATH')) {
    exit('Cheatin&#8217; uh?');
}

class SidebarComponent extends AbstractComponent
{
    protected string $name = 'Sidebar Component';

    protected bool $isFlexibleComponent = true; //true to enable flexible
    protected bool $isGutenbergBlock = false; //true to enable gutenberg block

    /*
    * Use this method to modify the ACF field data before returning it to the component's view (default: return base ACF data)
    */
    public function sanitize($data)
    {
        global $post;

        $pageCarriere = getOptionField('page_carriere');
        $pageGroupe = getOptionField('page_groupe');

        if (!empty($pageCarriere)
            && !empty($pageGroupe)
            && $post->ID !== $pageCarriere
        ) {
            $data['link_text'] = pll__('Rejoignez-nous');
            $data['link_url'] = get_permalink($pageCarriere);
            $data['color'] = 'green';
        } elseif (!empty($pageGroupe)
            && !empty($pageCarriere)
            && $post->ID === $pageCarriere
        ) {
            $data['link_text'] = pll__('Le groupe');
            $data['link_url'] = get_permalink($pageGroupe);
            $data['color'] = 'black-graphite';
        }

        return $data;
    }

    /*
    * ACF config for both Gutenberg and flexible component are created here using the FieldsBuilder library see docs here : https://github.com/StoutLogic/acf-builder/wiki
    */
    public function setBuilder(FieldsBuilder $builder): void
    {
    }
}
