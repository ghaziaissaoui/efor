<?php

namespace App\Components\FiltersComponent;

use App\Core\AbstractComponent;

if (!defined('ABSPATH')) {
    exit('Cheatin&#8217; uh?');
}

class FiltersComponent extends AbstractComponent
{
    public function sanitize($data): array
    {
        return [
            'filters' => $this->getFilters($data['page']),
            'search' => $data['queryParams']['search'] ?? '',
        ];
    }

    private function getFilters(string $page): array
    {
        if ('search' === $page) {
            $filters = array_merge(
                $this->getPostTypes(),
                $this->getPostCategories()
            );
        } else {
            $filters = $this->getPostCategories();
        }

        return $this->addDefaultFilter($filters);
    }

    private function addDefaultFilter(array $filters): array
    {
        $baseUrl = $this->getBaseUrl();

        array_unshift(
            $filters,
            [
                'name' => pll__('Tout'),
                'link' => sprintf(
                    '%s/',
                    $baseUrl,
                ),
                'active' => empty($_GET),
            ]
        );

        return $filters;
    }

    private function getPostTypes(): array
    {
        $baseUrl = $this->getBaseUrl();

        $availables = [
            pll__('Pages') => 'page',
            pll__('Témoignages') => 'talent',
        ];

        $postTypes = [];

        foreach ($availables as $key => $postType) {
            $urlParams = array_merge(
                $_GET,
                [
                    'content_type' => $postType,
                ]
            );

            unset($urlParams['cat']);

            if (($_GET['content_type'] ?? '') === $postType) {
                $active = true;
                unset($urlParams['content_type']);
            } else {
                $active = false;
            }

            $postTypes[] = [
                'name' => $key,
                'link' => sprintf(
                    '%s/?%s',
                    $baseUrl,
                    http_build_query($urlParams)
                ),
                'active' => $active,
            ];
        }

        return $postTypes;
    }

    private function getPostCategories(): array
    {
        $baseUrl = $this->getBaseUrl();

        return array_filter(
            array_map(function ($cat) use ($baseUrl) {
                if (!empty($_GET['cat'])) {
                    if (str_contains($_GET['cat'], (string) $cat->term_id)) {
                        $ids = explode(',', $_GET['cat']);

                        $urlParams['cat'] = implode(',', array_filter($ids, function ($id) use ($cat) {
                            return $id != $cat->term_id;
                        }));
                        $active = true;
                    } else {
                        $urlParams['cat'] = sprintf(
                            '%s,%s',
                            $_GET['cat'],
                            $cat->term_id
                        );
                        $active = false;
                    }
                } else {
                    $active = false;
                    $urlParams['cat'] = (string) $cat->term_id;
                }

                if ($cat->term_id !== 1) {
                    $tag = [
                        'type' => 'cat',
                        'link' => sprintf(
                            '%s/?%s',
                            $baseUrl,
                            urldecode(http_build_query($urlParams))
                        ),
                        'name' => $cat->name,
                        'active' => $active,
                    ];
                }

                return $tag ?? [];
            }, get_categories())
        );
    }

    private function getBaseUrl(): string
    {
        global $wp;

        $homeUrl = preg_replace(
            '~(.*)/en$~',
            '$1',
            home_url()
        );

        return sprintf(
            "%s/%s",
            $homeUrl,
            $wp->request
        );
    }
}
