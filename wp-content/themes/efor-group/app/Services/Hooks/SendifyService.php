<?php

namespace App\Services\Hooks;

use App\Sendify\Components\FeaturedPost\FeaturedPost;
use App\Sendify\Components\HeaderComponent\HeaderComponent;
use App\Sendify\Components\ImageText\ImageText;
use App\Sendify\components\RecentPostsComponents\RecentPostsComponents;
use VostraPress\Plugin;

class SendifyService
{
    public function registerComponents(): void
    {
    }

    public function config(array $config): array
    {
        return $config;
    }

    /**
     * @param $array
     * @return mixed
     */
    public function fieldKeys($array): array
    {
        $array[] = 'field_61a1f4ce2e08b';
        return $array;
    }

    public function enqueueScripts(): void
    {
        wp_enqueue_script('sendify-live-customize.js', get_theme_file_uri() . '/app/Sendify/live.js');
    }

    public function liveSettings(array $settings): array
    {
        return $settings;
    }
}
