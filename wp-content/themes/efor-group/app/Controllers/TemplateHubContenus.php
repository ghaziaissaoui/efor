<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Components\FiltersComponent\FiltersComponent;
use App\Components\ListingComponent\ListingComponent;
use App\Core\ComponentsManager;
use App\Core\ControllerBase;
use App\Services\Image;
use App\Services\SearchService;
use Psr\Container\ContainerInterface;

use function App\getOptionField;

class TemplateHubContenus extends ControllerBase
{
    private const CARDS_REDIRECT = [
        6,
        10,
    ];

    private SearchService $searchService;
    private Image $image;

    public function __construct(
        ContainerInterface $container,
        ComponentsManager $componentsManager,
        SearchService $searchService,
        Image $image
    ) {
        parent::__construct($container);
        $this->componentsManager = $componentsManager;
        $this->searchService = $searchService;
        $this->image = $image;
    }

    public function execute(array $args): array
    {
        $queryParams = $this->getQueryParams();

        $queryParams['numberPost'] = 13;

        return [
            'title' => get_field('title'),
            'filters' => $this->componentsManager->render(
                FiltersComponent::class,
                [
                    'queryParams' => $queryParams ?? null,
                    'page' => 'hub',
                ]
            ),
            'listing' => $this->componentsManager->render(
                ListingComponent::class,
                $this->addRedirectionCard(
                    $this->searchService->getListing(
                        ['post'],
                        $queryParams
                    )
                )
            ),
        ];
    }

    private function addRedirectionCard(array $listing): array
    {
        $posts = $listing['posts'];

        for ($i = 0; $i < count($posts); $i++) {
            $cardRedirectIndex = array_search(
                $i - 1,
                self::CARDS_REDIRECT
            );

            $endOfArray = array_slice($posts, $i - 2);
            $startOfArray = array_slice($posts, 0, $i - 2);

            $newCard = null;
            if (false !== $cardRedirectIndex) {
                $newCard = $this->formatRedirectCard(self::CARDS_REDIRECT[$cardRedirectIndex]);
            }

            $posts = array_values(
                array_filter(
                    array_merge_recursive(
                        $startOfArray,
                        [$newCard],
                        $endOfArray
                    )
                )
            );
        }

        $listing['posts'] = $posts;

        return $listing;
    }

    private function formatRedirectCard(int $cardPosition): array
    {
        if (6 === $cardPosition) {
            $data = get_field('card_redirection_1');
        } elseif (10 === $cardPosition) {
            $data = get_field('card_redirection_2');
        }

        return [
            'img' => $this->image->getImageTag(
                $data['image'] ?? '',
                $this->image::REDIRECT_CARD,
                $this->image::DEFAULT_CLASS
            ),
            'link' => $data['link'] ?? [],
            'title' => $data['title'] ?? [],
            'post_type' => 'redirect',
        ];
    }
}
