<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Components\MapComponent\MapComponent;
use App\Core\ComponentsManager;
use App\Core\ControllerBase;
use Psr\Container\ContainerInterface;

class TemplateImplantations extends ControllerBase
{
    public function __construct(ContainerInterface $container, ComponentsManager $componentsManager)
    {
        parent::__construct($container);
        $this->componentsManager = $componentsManager;
    }

    public function execute(array $args): array
    {
        $implantations = $this->getImplantations();

        return [
            'title' => get_field('title'),
            'content' => get_field('content'),
            'implantations' => $implantations,
            'map' => $this->componentsManager->render(
                MapComponent::class,
                ['implantations' => $this->getMapData($implantations)]
            ),
            'the_content' => apply_filters('the_content', get_the_content()),
        ];
    }

    private function getImplantations(): array
    {
        $implantations = [];

        $allImplantations = get_posts([
            'post_type' => 'implantation',
            'post_status' => 'publish',
            'numberposts' => -1,
            'tax_query' => [],
        ]);

        foreach ($allImplantations as $post) {
            $continentTerms = get_the_terms($post->ID, 'continent');
            $countryTerms = get_the_terms($post->ID, 'country');
            $regionTerms = get_the_terms($post->ID, 'region');

            $data = $this->formatImplantation($post);
            if (!empty($continentTerms)) {
                $map_coord = get_field('lat_lng', 'term_' . $continentTerms[0]->term_id);
                $order = get_field('ordre', 'term_' . $continentTerms[0]->term_id);

                $continent = $continentTerms[0]->slug ?? null;
                $continentName = $continentTerms[0]->name ?? null;
                $continentLat = $map_coord['lat'] ?? 0;
                $continentLng = $map_coord['lng'] ?? 0;
                $continentZoom = $map_coord['zoom'] ?? 3;

                $coords = json_encode([
                    'lat' => $continentLat,
                    'lng' => $continentLng,
                    'zoom' => $continentZoom
                ]);

                $order = $order ?? 0;
            }

            $country = $countryTerms[0]->name ?? null;
            $region = $regionTerms[0]->name ?? null;

            if (!empty($continent)) {
                $implantations[$continent]['name'] = $continentName;
                $implantations[$continent]['coords'] = $coords;
                $implantations[$continent]['order'] = $order;

                if ($region) {
                    $implantations[$continent][$country][$region][] = $data;
                } elseif ($country) {
                    $implantations[$continent][$country][] = $data;
                } else {
                    $implantations[$continent][] = $data;
                }
            }
        }

        uasort($implantations, function ($a, $b) {
            $orderA = isset($a['order']) && $a['order'] > 0 ? $a['order'] : PHP_INT_MAX;
            $orderB = isset($b['order']) && $b['order'] > 0 ? $b['order'] : PHP_INT_MAX;

            return $orderA <=> $orderB;
        });

        return $implantations;
    }

    private function formatImplantation(\WP_Post $post): array
    {
        return [
            'title' => $post->post_title,
            'subtitle' => get_field('subtitle', $post->ID),
            'phone' => get_field('phone_number', $post->ID),
            'mail' => get_field('email', $post->ID),
            'address' => get_field('adresse_postale', $post->ID),
            'id' => $post->ID,
        ];
    }

    private function getMapData(array $implantations): array
    {
        $mapData = [];

        $iterator = new \RecursiveIteratorIterator(
            new \RecursiveArrayIterator($implantations),
            \RecursiveIteratorIterator::SELF_FIRST
        );

        foreach ($iterator as $value) {
            if (is_array($value) && isset($value[0]['id'])) {
                foreach ($value as $implantation) {
                    if (!empty($implantation['address']['lat']) && !empty($implantation['address']['lng'])) {
                        $mapData[] = [
                            $implantation['id'],
                            $implantation['address']['lat'],
                            $implantation['address']['lng'],
                        ];
                    }
                }
            }
        }

        return $mapData;
    }
}
