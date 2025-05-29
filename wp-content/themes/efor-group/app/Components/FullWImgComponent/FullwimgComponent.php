<?php

namespace App\Components\FullWImgComponent;

use App\Components\Traits\AcfBuilderTrait;
use App\Core\AbstractComponent;
use App\Services\BuilderService;
use App\Services\Image;
use StoutLogic\AcfBuilder\FieldsBuilder;

if (!defined('ABSPATH')) {
    exit('Cheatin&#8217; uh?');
}

class FullWImgComponent extends AbstractComponent
{
    use AcfBuilderTrait;

    protected string $name = 'Full With Image Component';

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
        if (!empty($id = ($data['image']['id'] ?? null))) {
            $data['image'] = $this->image->getImageTag(
                $id,
                $this->image::FULL_W_IMG,
                ['class' => 'ratio-block__content']
            );
        }

        return $data;
    }

    /*
    * ACF config for both Gutenberg and flexible component are created here using the FieldsBuilder library see docs here : https://github.com/StoutLogic/acf-builder/wiki
    */
    public function setBuilder(FieldsBuilder $builder): void
    {
        $builder
            ->addField(
                'image',
                'image_aspect_ratio_crop',
                $this->getImageCropData(
                    1260,
                    485,
                    'Image'
                ),
            )
        ;

        $this->addBlockMarginSelect($builder);
    }
}
