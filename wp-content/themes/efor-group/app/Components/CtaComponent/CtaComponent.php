<?php

namespace App\Components\CtaComponent;

use App\Core\AbstractComponent;
use App\Services\BuilderService;
use App\Services\Image;
use StoutLogic\AcfBuilder\FieldsBuilder;

if (!defined('ABSPATH')) {
    exit('Cheatin&#8217; uh?');
}

class CtaComponent extends AbstractComponent
{
    protected string $name = 'Cta Component';

    protected bool $isFlexibleComponent = false; //true to enable flexible
    protected bool $isGutenbergBlock = true; //true to enable gutenberg block
    private Image $image;

    /**
     * @param BuilderService $builder
     * @param Image $image
     */
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
        return array_merge(
            $data,
            [
                'image' => $this->image->getImageTag(
                    $data['image']['ID'],
                    $this->image::REDIRECT_CARD,
                )
            ]
        );
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
            ->addLink('button')->addImage('image');
    }
}
