<?php

declare(strict_types=1);

namespace App\Core\Models;

use App\Core\Interfaces\ModelDefaultInterface;

class TalentModel implements ModelDefaultInterface
{
    public function getLatests($numberPosts = 12): array
    {
        return (new \WP_Query([
            'post_type' => 'talent',
            'posts_per_page' => $numberPosts,
            'paged' => 1,
        ]))->posts;
    }

    public function findOneById(int $id): ?\WP_Post
    {
        $post = (new \WP_Query([
            'post_type' => 'talent',
            'posts_per_page' => 1,
        ]))->posts;

        return $post[array_key_first($post)] ?? null;
    }
}
