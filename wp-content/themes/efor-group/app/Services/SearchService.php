<?php

declare(strict_types=1);

namespace App\Services;

use App\Core\Models\PostModel;

final class SearchService
{
    private PostModel $postModel;
    private PostFormatterService $postFormatterService;
    private Image $image;

    public function __construct(
        PostModel $postModel,
        PostFormatterService $postFormatterService,
        Image $image
    ) {
        $this->postModel = $postModel;
        $this->postFormatterService = $postFormatterService;
        $this->image = $image;
    }

    public function getListing(
        array $postTypes,
        array $searchParams,
        string $url = null
    ): array {
        $posts = $this->postModel->findPaginated(
            $postTypes,
            $this->formatParams($searchParams)
        );

        if (!empty($posts)) {
            $posts['posts'] = array_map(
                function ($post) use ($url) {
                    return $this->postFormatterService->formatPost(
                        $post,
                        $this->image::ACTU_CARD,
                        baseUrl: $url ?? $this->getBaseUrl(),
                    );
                },
                $posts['posts']
            );
        }

        $posts['numberPost'] = $searchParams['numberPost'] ?? get_option('posts_per_page');

        return $posts;
    }

    public function findAllArticle(): array
    {
        $posts = $this->postModel->findAll();

        if (!empty($posts)) {
            $posts['posts'] = array_map(
                function ($post) {
                    return $this->postFormatterService->formatPost(
                        $post,
                        $this->image::ACTU_CARD,
                        baseUrl: $this->getBaseUrl(),
                    );
                },
                $posts['posts']
            );
        }

        return $posts;
    }

    private function formatParams(array $params): array
    {
        if (!empty($params['content_type'])) {
            $params['post_type'] = $params['content_type'];
            unset($params['content_type']);
        }

        return $params;
    }

    private function getBaseUrl(): string
    {
        global $wp;

        if (true === is_page_template('views/search-template.blade.php')
            || true === is_page_template('views/template-hub-contenus.blade.php')
            || true === wp_doing_ajax()
        ) {
            $baseUrl = sprintf(
                "%s/%s",
                home_url(),
                $wp->request
            );
        }

        return $baseUrl ?? '';
    }
}
