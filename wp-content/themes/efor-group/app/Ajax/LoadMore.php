<?php

declare(strict_types=1);

namespace App\Ajax;

use App\Core\AjaxRequest;
use App\Services\SearchService;

use function App\template;

class LoadMore extends AjaxRequest
{
    protected string $action = 'load-more';
    protected string $scope = self::SCOPE_NOPRIV;
    private SearchService $searchService;

    public function __construct(SearchService $searchService)
    {
        $this->searchService = $searchService;
    }

    protected function execute()
    {
        if (empty($postTypes = $_POST['contentType'])) {
            $postTypes = ['post'];
        } else {
            $postTypes = explode(',', $postTypes);
        }

        $posts = $this->searchService->getListing(
            $postTypes,
            [
                'paged' => $_POST['nextPage'],
                'numberPost' => $_POST['size'],
                'cat' => $_POST['cat'],
            ],
            $_POST['url'] ?? null
        );

        if (!empty($posts)) {
            wp_send_json([
                'hasNext' => $posts['hasNext'],
                'fragment' => template('ListingComponent.partials.card-loop', ['data' => $posts])
            ]);
        } else {
            wp_send_json('no posts found');
        }
        wp_die();
    }
}
