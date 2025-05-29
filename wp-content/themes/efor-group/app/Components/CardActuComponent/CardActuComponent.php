<?php

namespace App\Components\CardActuComponent;

use App\Components\Traits\AcfBuilderTrait;
use App\Core\AbstractComponent;
use App\Core\Models\PostModel;
use App\Services\BuilderService;
use App\Services\Image;
use App\Services\PostFormatterService;
use StoutLogic\AcfBuilder\FieldsBuilder;

use function App\getOptionField;

if (!defined('ABSPATH')) {
    exit('Cheatin&#8217; uh?');
}

class CardActuComponent extends AbstractComponent
{
    use AcfBuilderTrait;

    protected string $name = 'Card Actu Component';

    protected bool $isFlexibleComponent = true; //true to enable flexible
    protected bool $isGutenbergBlock = true; //true to enable gutenberg block
    private Image $image;
    private PostModel $postModel;
    private PostFormatterService $postFormatterService;

    public function __construct(
        BuilderService $builder,
        Image $image,
        PostModel $postModel,
        PostFormatterService $postFormatterService
    ) {
        parent::__construct($builder);
        $this->image = $image;
        $this->postModel = $postModel;

        $this->postFormatterService = $postFormatterService;
    }

    /*
    * Use this method to modify the ACF field data before returning it to the component's view (default: return base ACF data)
    */
    public function sanitize($data)
    {
        global $wp;

        if (is_single()) {
            global $post;

            $postID = $post->ID;
        }

        $pageID = getOptionField('hub_content_page');
        if (!empty($pageID)) {
            $baseUrl = get_the_permalink($pageID);
        } else {
            $baseUrl = sprintf(
                "%s/%s",
                home_url(),
                $wp->request
            );
        }

        $data['listing'] = array_map(function ($post) use ($baseUrl) {
            return $this->postFormatterService->formatPost(
                $post,
                'card-actu',
                'ratio-block__content',
                baseUrl: $baseUrl
            );
        }, $this->postModel->getLatests($postID ?? null));

        if (empty($data['link_text'])) {
            $data['link_text'] = pll__('Voir toutes les actualités');
        }

        if (!empty($hubContent = getOptionField('hub_content_page'))) {
            $data['link'] = get_permalink($hubContent);
        }

        return $data;
    }

    /*
    * ACF config for both Gutenberg and flexible component are created here using the FieldsBuilder library see docs here : https://github.com/StoutLogic/acf-builder/wiki
    */
    public function setBuilder(FieldsBuilder $builder): void
    {
        $builder
            ->addText('title', [
                'label' => 'Titre',
            ])
            ->addTextarea('content', [
                'label' => 'Contenu',
            ])
            ->addText('link_text', [
                'label' => 'Texte du bouton',
            ])
        ;

        $this->addBlockMarginSelect($builder);
    }
}
