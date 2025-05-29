<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Components\CardActuComponent\CardActuComponent;
use App\Components\CardLinkComponent\CardLinkComponent;
use App\Components\HeroArticleComponent\HeroArticleComponent;
use App\Core\ComponentsManager;
use App\Core\ControllerBase;
use App\Services\PostFormatterService;
use Psr\Container\ContainerInterface;

use function App\getOptionField;

class Single extends ControllerBase
{
    private PostFormatterService $postFormatterService;

    public function __construct(
        ContainerInterface $container,
        PostFormatterService $postFormatterService,
        ComponentsManager $componentsManager
    ) {
        parent::__construct($container);
        $this->postFormatterService = $postFormatterService;
        $this->componentsManager = $componentsManager;
    }

    public function execute(array $args): array
    {
        return [
            'header' => $this->getHeader(),
            'content' => apply_filters('the_content', get_the_content()),
            'card_link' => $this->componentsManager->render(
                CardLinkComponent::class,
                [
                    'left_section' => getOptionField('card_link_component_left'),
                    'right_section' => getOptionField('card_link_component_right'),
                ]
            ),
            'actus' => $this->componentsManager->render(
                CardActuComponent::class,
                getOptionField('actus_component')
            )
        ];
    }

    private function getHeader(): string
    {
        global $post;

        return $this->componentsManager->render(
            HeroArticleComponent::class,
            $this->postFormatterService->formatHeroSingle(
                $post,
                get_field('hero_type', $post->ID)
            ),
        );
    }
}
