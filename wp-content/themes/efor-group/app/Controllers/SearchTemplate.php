<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Components\FiltersComponent\FiltersComponent;
use App\Components\ListingComponent\ListingComponent;
use App\Core\ComponentsManager;
use App\Core\ControllerBase;
use App\Services\SearchService;
use Psr\Container\ContainerInterface;

use function App\getOptionField;

class SearchTemplate extends ControllerBase
{
    private SearchService $searchService;

    public function __construct(
        ContainerInterface $container,
        ComponentsManager $componentsManager,
        SearchService $searchService
    ) {
        parent::__construct($container);
        $this->componentsManager = $componentsManager;
        $this->searchService = $searchService;
    }

    public function execute(array $args): array
    {
        $queryParams = $this->getQueryParams();

        return [
            'title' => get_field('title'),
            'filters' => $this->componentsManager->render(
                FiltersComponent::class,
                [
                    'queryParams' => $queryParams,
                    'page' => 'search',
                ]
            ),
            'listing' => $this->componentsManager->render(
                ListingComponent::class,
                $this->searchService->getListing(
                    ['post', 'page', 'talent'],
                    $queryParams
                )
            ),
        ];
    }
}
