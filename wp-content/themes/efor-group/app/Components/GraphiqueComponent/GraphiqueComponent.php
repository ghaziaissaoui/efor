<?php

namespace App\Components\GraphiqueComponent;

use App\Core\AbstractComponent;
use StoutLogic\AcfBuilder\FieldsBuilder;

if (!defined('ABSPATH')) {
    exit('Cheatin&#8217; uh?');
}

class GraphiqueComponent extends AbstractComponent
{
    protected string $name = 'Graphique Component';

    protected bool $isFlexibleComponent = true; //true to enable flexible
    protected bool $isGutenbergBlock = true; //true to enable gutenberg block

    /*
    * Use this method to modify the ACF field data before returning it to the component's view (default: return base ACF data)
    */
    public function sanitize($data)
    {
        if (!empty($data['data'])) {
            $index = 1;

            foreach ($data['data'] as $entry) {
                if ($index < count($data['data'])) {
                    $separator = ',';
                } else {
                    $separator = '';
                }

                $data['years'] .= $entry['year'] . $separator;
                $data['column'] .= $entry['column'] . $separator;
                $data['curve'] .= $entry['curve'] . $separator;
                $data['future'] .= (true === $entry['future'] ? '#ffffff10' : '#ffffff30') . $separator;
                $index++;
            }

            unset($data['data']);
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
            ->addText('legend_column', [
                'label' => 'Légende des colonnes',
            ])
            ->addText('legend_curve', [
                'label' => 'Légende de la courbe',
            ])
            ->addText('tooltip', [
                'label' => 'Tootltip (info-bulle)'
            ])
            ->addRepeater('data', [
                'label' => 'Données du graphique',
            ])
                ->addText('year', [
                    'label' => 'Année',
                ])
                ->addText('column', [
                    'label' => 'Colonne'
                ])
                ->addText('curve', [
                    'label' => 'Courbe',
                ])
                ->addTrueFalse('future', [
                    'label' => 'Prévision',
                    'default_value' => 0,
                ])
        ;
    }
}
