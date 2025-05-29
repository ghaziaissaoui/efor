<?php

declare(strict_types=1);

namespace App\Services;

use App\Components\FullWImgComponent\FullWImgComponent;
use App\Core\ComponentsManager;
use WP_Post;

use function App\getOptionField;

final class PostFormatterService
{
    private Image $image;
    private ComponentsManager $componentsManager;

    public function __construct(Image $image, ComponentsManager $componentsManager)
    {
        $this->image = $image;
        $this->componentsManager = $componentsManager;
    }

    public function formatPost(
        WP_Post $post,
        string $imgSize = 'medium',
        string $imgClass = '',
        string $loadingMode = 'lazy',
        string $baseUrl = '',
    ): array {
        $params = [
            'imgSize' => $imgSize,
            'imgClass' => $imgClass,
            'loadingMode' => $loadingMode,
        ];

        $formattedPost = match ($post->post_type) {
            'talent' => $this->formatTalent($post, $params),
            'page' => $this->formatPage($post, $params),
            default => $this->formatPostTypePost($post, $params),
        };

        $formattedPost['post_type'] = $post->post_type;
        $formattedPost['tag'] = $this->getPostTag($post, $baseUrl);

        return $formattedPost ?? [];
    }

    private function formatPostTypePost(WP_Post $post, array $params): array
    {
        return [
            'image' => $this->getImage($params, $post->ID),
            'title' => $this->getShortTitle($post),
            'permalink' => get_the_permalink($post),
            'excerpt' => $this->getTheExcerpt($post),
            'published_date' => get_the_date('j/m/Y', $post),
        ];
    }

    private function formatPage(WP_Post $post, array $params): array
    {
        return [
            'image' => $this->getImage($params, $post->ID),
            'title' => $post->post_title,
            'permalink' => get_the_permalink($post),
            'excerpt' => get_field('excerpt', $post->ID),
        ];
    }

    private function formatTalent(WP_Post $post, array $params): array
    {
        return [
            'image' => $this->getImage($params, $post->ID),
            'title' => $post->post_title,
            'published_date' => get_the_date('j/m/Y', $post),
            'excerpt' => $this->getTheExcerpt($post),
            'permalink' => get_the_permalink($post),
        ];
    }

    public function formatHeroSingle(WP_Post $post, ?string $heroType): array
    {
        if (empty($heroType) || 'sided' === $heroType) {
            if (empty($img = get_field('article_thumbnail_crop', $post->ID))) {
                $img = get_post_thumbnail_id($post->ID);
            }

            $img = $this->image->getImageTag(
                $img,
                $this->image::IMG_EQUALITY,
                [
                    'class' => 'ratio-block__content',
                    'loading' => 'lazy',
                ]
            );
        } else {
            if (empty($img['id'] = get_field('full_width_img', $post->ID))) {
                $img['id'] = get_post_thumbnail_id($post->ID);
            }

            if (is_array($img) && !empty($img[array_key_first($img)])) {
                $img = $this->componentsManager->render(
                    FullWImgComponent::class,
                    ['image' => $img]
                );
            } else {
                $img = null;
            }
        }

        return [
            'image' => $img,
            'heroType' => $heroType ?? 'sided',
            'title' => $post->post_title,
            'category' => $this->getPostCat($post),
            'published_date' => get_the_date('j/m/Y', $post),
        ];
    }

    private function getPostCat(WP_Post $post): string
    {
        $cats = wp_get_post_categories($post->ID, ['fields' => 'all', 'parent' => 0]);

        return $cats[array_key_first($cats)]->name ?? '';
    }

    private function getShortTitle(WP_Post $post): string
    {
        if (empty($title = get_field('short_title', $post->ID))) {
            $title = get_the_title($post);
        }

        return $title;
    }

    private function getTheExcerpt(WP_Post $post, int $length = 130): string
    {
        return substr(get_the_excerpt($post), 0, $length);
    }

    private function getImage(array $params, int $postId): string
    {
        if (empty($img = get_field('listing_thumbnail_card', $postId)['ID'] ?? null)) {
            $img = getOptionField('default_card_img');
        }

        return $this->image->getImageTag(
            $img,
            $params['imgSize'],
            [
                'class' => sprintf(
                    '%s %s',
                    $params['imgClass'],
                    'ratio-block__content'
                ),
                'loading' => $params['loadingMode'],
            ]
        );
    }

    private function getPostTag(WP_Post $post, string $baseUrl): array
    {
        $link = sprintf(
            '%s?%s',
            $baseUrl,
            http_build_query($this->getUrlParams($post))
        );

        $name = match ($post->post_type) {
            'talent' => pll__('Témoignages'),
            'page' => pll__('Pages'),
            default => $this->getPostCat($post) ?? '',
        };

        return [
            'name' => $name,
            'link' => $link,
        ];
    }

    private function getUrlParams(WP_Post $post): array
    {
        return match ($post->post_type) {
            'talent', 'page' => ['content_type' => $post->post_type],
            default => ['cat' => get_the_category($post->ID)[0]->term_id ?? ''],
        };
    }
}
