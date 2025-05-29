<?php

declare(strict_types=1);

namespace App\Services;

use App\Components\ContactComponent\ContactComponent;
use App\Components\HeroTalentComponent\HeroTalentComponent;
use App\Core\ComponentsManager;

use function App\getOptionField;
use function App\template;

class TalentFormatterService
{
    private ComponentsManager $componentsManager;
    private Image $image;

    public function __construct(
        ComponentsManager $componentsManager,
        Image $image,
    ) {
        $this->componentsManager = $componentsManager;
        $this->image = $image;
    }

    public function getContent(\WP_Post $post, bool $isModal = false): string|array
    {
        $data = [
            'header' => $this->getHeader($post),
            'title' => $this->getTheTitle($post),
            'job' => $this->getJob($post),
            'content' => $this->getBody($post),
        ];

        //Display contact bloc only on single
        if (false === $isModal) {
            $data['contact_title'] = getOptionField('title_form_talent');
            $data['contact'] = $this->getContactForm();
        } else {
            $data = template('partials.modal-single-talent', ['data' => $data]);
        }

        return $data;
    }

    private function getJob(\WP_Post $post): string
    {
        return get_field('job', $post->ID) ?? '';
    }

    private function getHeader(\WP_Post $post): string
    {
        return $this->componentsManager->render(
            HeroTalentComponent::class,
            [
                'img' => get_post_thumbnail_id($post),
                'tags' => $this->getTags($post),
            ]
        );
    }

    private function getTheTitle(\WP_Post $post): array
    {
        $titles = get_field('title', $post->ID);

        if (empty($titles['title_1']) && empty($titles['title_2'])) {
            $tmpTitle = explode(' ', $post->post_title);
            $titles = [
                'title_1' => $tmpTitle[0] ?? '',
                'title_2' => $tmpTitle[1] ?? '',
            ];
        }

        return $titles;
    }

    private function getBody(\WP_Post $post): string
    {
        return apply_filters('the_content', sprintf(
            __('%s'),
            get_the_content(null, false, $post),
        ));
    }

    private function getContactForm(): string
    {
        return $this->componentsManager->render(
            ContactComponent::class,
            [
                'image' => getOptionField('image_form'),
                'form_title' => getOptionField('title_form'),
                'form_id' => getOptionField('cf7_contact_component_id'),
                'link' => getOptionField('link_form'),
                'link_color' => getOptionField('link_color_form'),
            ]
        );
    }

    private function getTags(\WP_Post $post): array
    {
        $terms = get_the_terms($post, 'location');

        if (!empty($terms)) {
            $terms = array_map(
                function ($term) {
                    return $term->name;
                },
                $terms
            );
        } else {
            $terms = [];
        }

        return $terms;
    }

    public function formatTalent(\WP_Post $post): array
    {
        if (!empty($id = get_field('img_thumbnail_card', $post->ID)['ID'] ?? null)) {
            $imgId = $id;
        } else {
            $imgId = get_post_thumbnail_id($post->ID);
        }

        return [
            'id' => $post->ID,
            'title' => $post->post_title,
            'tags' => $this->getTags($post),
            'job' => $this->getJob($post),
            'image' => $this->image->getImageTag(
                $imgId,
                $this->image::TALENT_CARD,
                [
                    'class' => 'ratio-block__content',
                    'loading' => 'lazy',
                ]
            ),
            'permalink' => get_the_permalink($post),
        ];
    }

    public function formatTalentModal(\WP_Post $post): string
    {
        return $this->getContent($post, true);
    }
}
