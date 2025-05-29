<?php

namespace App\Components\ExpandVideoComponent;

use App\Components\Traits\AcfBuilderTrait;
use App\Core\AbstractComponent;
use App\Services\BuilderService;
use App\Services\Image;
use StoutLogic\AcfBuilder\FieldsBuilder;

if (!defined('ABSPATH')) {
    exit('Cheatin&#8217; uh?');
}

class ExpandVideoComponent extends AbstractComponent
{
    use AcfBuilderTrait;

    protected string $name = 'Expand Video Component';

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
        if (!empty($data['youtube'])) {
            preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $data['youtube'], $match);
            $data['youtube'] = $match[1] ?? '';
        }

        if (!empty($data['video']['url'])) {
            $data['video'] = $data['video']['url'];
        }

        return $data;
    }

    /*
    * ACF config for both Gutenberg and flexible component are created here using the FieldsBuilder library see docs here : https://github.com/StoutLogic/acf-builder/wiki
    */
    public function setBuilder(FieldsBuilder $builder): void
    {
        $builder
            ->addOembed('youtube', [
                'label' => 'Vidéo Youtube',
            ])
            ->addImage('video', [
                'label' => 'Vidéo',
                'mime_types' => 'mp4'
            ])
        ;

        $this->addBlockMarginSelect($builder);
    }
}
