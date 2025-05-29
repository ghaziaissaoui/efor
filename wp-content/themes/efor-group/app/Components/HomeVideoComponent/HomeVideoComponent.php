<?php

namespace App\Components\HomeVideoComponent;

use App\Core\AbstractComponent;
use StoutLogic\AcfBuilder\FieldsBuilder;

if (!defined('ABSPATH')) {
    exit('Cheatin&#8217; uh?');
}

class HomeVideoComponent extends AbstractComponent
{
    protected string $name = 'Home Video Component';

    protected bool $isFlexibleComponent = false; //true to enable flexible
    protected bool $isGutenbergBlock = true; //true to enable gutenberg block

    /*
    * Use this method to modify the ACF field data before returning it to the component's view (default: return base ACF data)
    */
    public function sanitize($data)
    {
        return [
            "video_src" => htmlspecialchars(wp_json_encode([
                'desktop' => $data['video_desktop']['url'] ?? '',
                'mobile' => $data['video_mobile']['url'] ?? '',
            ])),
            "titles" => $data['titles']
        ];
    }

    /*
    * ACF config for both Gutenberg and flexible component are created here using the FieldsBuilder library see docs here : https://github.com/StoutLogic/acf-builder/wiki
    */
    public function setBuilder(FieldsBuilder $builder): void
    {
        $builder
            ->addGroup('titles')
            ->addText('title_1')
            ->addText('title_2')
            ->endGroup()
            ->addFile('video_desktop', [
                'label' => 'Vidéo 16:9',
                'mime_types' => 'mp4'
            ])
            ->addFile('video_mobile', [
                'label' => 'Vidéo 9:16',
                'mime_types' => 'mp4'
            ]);
    }
}
