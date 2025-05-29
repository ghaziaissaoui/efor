<?php

namespace App\Components\TimelineComponent;

use App\Core\AbstractComponent;
use StoutLogic\AcfBuilder\FieldsBuilder;

if (!defined('ABSPATH')) {
    exit('Cheatin&#8217; uh?');
}

class TimelineComponent extends AbstractComponent
{
    protected string $name = 'Timeline Component';

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

            ->addRepeater('contents', [
                'label' => __('Contenus'),
                'button_label' => 'Add Content',
                'layout' => 'row',
            ])
                ->addText('content_title', [
                    'label' => __('Titre du contenu'),
                ])
                ->addWysiwyg('content_description', [
                    'label' => __('Description'),
                    'tabs' => 'visual',
                    'toolbar' => 'basic',
                    'media_upload' => 0,
                ])
                ->addNumber('year', [
                    'label' => __('Année'),
                    'min' => '0',
                    'required' => 1,
                ])
            ->endRepeater()
        ;
    }
}
