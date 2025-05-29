<?php

namespace App\Core\Models;

use App\Core\Interfaces\ModelDefaultInterface;
use WP_Post;
use WP_Query;

class PostModel implements ModelDefaultInterface
{
    public function findOneById(int $id): WP_Post
    {
        return get_post($id);
    }

    public function findAll(): array
    {
        $wpQuery = new WP_Query([
            'post_type' => 'post',
            'posts_per_page' => -1,
            'orderby' => 'date',
            'order' => 'DESC',
            'post_status' => 'publish',
            'ignore_sticky_posts' => true,
        ]);

        return [
            'hasNext' => false,
            'posts' => $wpQuery->posts,
        ];
    }

    public function findPaginated(
        array $postTypes = ['post'],
        array $params = []
    ): array {
        if (!empty($params['post_type'])) {
            $postTypes = $params['post_type'];
        }

        $numberPost = $params['numberPost'] ?? get_option('posts_per_page');
        $args = [
            'post_type' => $postTypes,
            'posts_per_page' => $numberPost,
            'paged' => $params['paged'] ?? 1,
            'post__not_in' => $params['postNotIn'] ?? [],
            'post_status' => 'publish',
            'order' => 'DESC',
            'orderby' => 'date',
            'ignore_sticky_posts' => true,
        ];

        if (!empty($params['search'])) {
            $args['s'] = $params['search'];
        }

        if (!empty($params['cat'])) {
            $args['category__in'] = explode(',', $params['cat']);
        }

        $wp_query = new WP_Query($args);
        $has_next = $args['paged'] < ceil((float)$wp_query->found_posts / $numberPost);

        return [
            'hasNext' => $has_next,
            'posts' => $wp_query->posts,
        ];
    }

    public function getLatests(?int $postNotIn, $number = 3): array
    {
        $wpQuery = new WP_Query([
            'post_status' => 'publish',
            'order' => 'DESC',
            'orderby' => 'date',
            'posts_per_page' => $number,
            'post__not_in' => [$postNotIn ?? ''],
        ]);

        return $wpQuery->posts;
    }
}
