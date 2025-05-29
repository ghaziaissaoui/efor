<?php

namespace App\Components\ListingComponent;

use App\Components\FiltersComponent\FiltersComponent;
use App\Core\AbstractComponent;
use App\Core\ComponentsManager;
use App\Services\BuilderService;
use App\Services\Image;
use App\Services\PostFormatterService;
use StoutLogic\AcfBuilder\FieldsBuilder;

if (!defined('ABSPATH')) {
    exit('Cheatin&#8217; uh?');
}

class ListingComponent extends AbstractComponent
{
    protected string $name = 'Listing Component';

    protected bool $isFlexibleComponent = false; //true to enable flexible
    protected bool $isGutenbergBlock = false; //true to enable gutenberg block
    private PostFormatterService $postFormatterService;
    private Image $image;
    private ComponentsManager $componentsManager;

    public function __construct(
        BuilderService $builder,
        PostFormatterService $postFormatterService,
        Image $image,
        ComponentsManager $componentsManager
    ) {
        parent::__construct($builder);
        $this->postFormatterService = $postFormatterService;
        $this->image = $image;
        $this->componentsManager = $componentsManager;
    }

    /*
    * Use this method to modify the ACF field data before returning it to the component's view (default: return base ACF data)
    */
    public function sanitize($data)
    {
        if (!empty($_GET['content_type'])) {
            $data['post_types'] = $_GET['content_type'];
        } elseif (is_page_template('views/template-hub-contenus.blade.php')) {
            $data['post_types'] = 'post';
        } else {
            $data['post_types'] = "'post','page','talent'";
        }

        if (!empty($_GET['cat'])) {
            $data['cat'] = $_GET['cat'];
        }

        global $wp;

        $data['url'] = sprintf(
            "%s/%s",
            home_url(),
            $wp->request
        );

        return $data;
    }
}
