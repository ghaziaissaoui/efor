<?php

declare(strict_types=1);

namespace app\Controllers;

use App\Components\ListingComponent\ListingComponent;
use App\Core\ComponentsManager;
use App\Core\ControllerBase;
use App\Services\SearchService;
use Psr\Container\ContainerInterface;

class TemplateAllArticles extends ControllerBase
{
    private SearchService $searchService;

    public function __construct(
        ContainerInterface $container,
        SearchService $searchService,
        ComponentsManager $componentsManager,
    ) {
        parent::__construct($container);
        $this->searchService = $searchService;
        $this->componentsManager = $componentsManager;
    }

    public function execute(array $args): array
    {
        return [
            'title' => get_field('title'),
            'listing' => $this->componentsManager->render(
                ListingComponent::class,
                $this->searchService->findAllArticle()
            ),
        ];
    }
}
