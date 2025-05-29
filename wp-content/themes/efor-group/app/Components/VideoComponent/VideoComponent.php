<?php

namespace App\Components\VideoComponent;

use App\Core\AbstractComponent;
use App\Services\BuilderService;
use App\Services\Image;
use StoutLogic\AcfBuilder\FieldsBuilder;

use function App\getOptionField;

if (!defined('ABSPATH')) {
    exit('Cheatin&#8217; uh?');
}

class VideoComponent extends AbstractComponent
{
    protected string $name = 'Video Component';

    protected bool $isFlexibleComponent = false; //true to enable flexible
    protected bool $isGutenbergBlock = false; //true to enable gutenberg block
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
        $data['bg_preview'] = $this->image->getImageSrc(getOptionField('default_card_img'), 'large');

        if (true === $data['isYoutube']
            && empty($data['preview'])
            && !empty($data['youtube_id'])
        ) {
            $data['preview'] = sprintf(
                '<img class="ratio-block__content" src="https://img.youtube.com/vi/%s/maxresdefault.jpg">',
                $data['youtube_id']
            );
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
