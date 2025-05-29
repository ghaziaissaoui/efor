<?php

namespace App\Components\ContentAlongsideComponent;

use App\Components\Traits\AcfBuilderTrait;
use App\Core\AbstractComponent;
use App\Services\BuilderService;
use App\Services\Image;
use StoutLogic\AcfBuilder\FieldsBuilder;

use function App\getTextColorBasedOnBackground;

if (!defined('ABSPATH')) {
    exit('Cheatin&#8217; uh?');
}

class ContentAlongsideComponent extends AbstractComponent
{
    use AcfBuilderTrait;

    protected string $name = 'Content Alongside Component';

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
        if (!empty($id = $data['image_small']['ID'] ?? null)) {
            $data['image_small'] = $this->image->getImageTag(
                $id,
                $this->image::ALONGSIDE_SMALL,
                ['class' => 'ratio-block__content']
            );
        }

        if (!empty($id = $data['image_large']['ID'] ?? null)) {
            $data['image_large'] = $this->image->getImageTag(
                $id,
                $this->image::ALONGSIDE_LARGE,
                ['class' => 'ratio-block__content']
            );
        }

        if (!empty($id = $data['image_extra_small']['ID'] ?? null)) {
            $data['image_extra_small'] = $this->image->getImageTag(
                $id,
                $this->image::ALONGSIDE_EXTRA_SMALL,
                ['class' => 'ratio-block__content']
            );
        }

        if (!empty($data['background'])) {
            $data['global_text_color'] = getTextColorBasedOnBackground($data['background']);
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
        $this->alongsideComponentBuilder($builder);
    }
}
