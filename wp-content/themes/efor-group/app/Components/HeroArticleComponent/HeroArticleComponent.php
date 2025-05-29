<?php

namespace App\Components\HeroArticleComponent;

use App\Core\AbstractComponent;
use App\Core\ComponentsManager;
use App\Services\BuilderService;
use StoutLogic\AcfBuilder\FieldsBuilder;

use function App\getOptionField;

if (!defined('ABSPATH')) {
    exit('Cheatin&#8217; uh?');
}

class HeroArticleComponent extends AbstractComponent
{
    protected string $name = 'Hero Article Component';

    protected bool $isFlexibleComponent = false; //true to enable flexible
    protected bool $isGutenbergBlock = false; //true to enable gutenberg block

    /*
    * Use this method to modify the ACF field data before returning it to the component's view (default: return base ACF data)
    */
    public function sanitize($data)
    {
        $hubId = getOptionField('hub_content_page');
        $searchPageId = getOptionField('search_page');
        $urls = [];

        if (!empty($hubId)) {
            $urls[] = get_the_permalink($hubId);
        }

        if (!empty($searchPageId)) {
            $urls[] = get_the_permalink($searchPageId);
        }

        if (!empty($_SERVER['HTTP_REFERER']) && !empty($urls)) {
            $tmp = array_filter($urls, function ($url) {
                if (str_contains($_SERVER['HTTP_REFERER'], $url)) {
                    return $_SERVER['HTTP_REFERER'];
                }
            });

            if (!empty($link = $tmp[array_key_first($tmp)])) {
                $data['back_button'] = $link;
            }
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
