<?php

declare(strict_types=1);

namespace App\Services;

use App\Components\VideoComponent\VideoComponent;
use App\Core\ComponentsManager;

class Image
{
    public const SMALL_ICONS = 'icon-small';
    public const DEFAULT_CLASS = ['class' => 'ratio-block__content'];
    public const KIT_PRODUCT_SMALL = 'icon';
    public const HERO_SMALL = 'hero-small';
    public const HERO_FULL = 'hero-full';
    public const SQUARRE_MEDIUM = 'squarre-medium';
    public const CONTACT_FULL = 'contact-full';
    public const ACTU_CARD = 'actu-card';
    public const FULL_W_IMG = 'full-width-img';
    public const ALONGSIDE_SMALL = 'alongside-small';
    public const ALONGSIDE_LARGE = 'alongside-large';
    public const ALONGSIDE_EXTRA_SMALL = 'alongside-extra-small';
    public const CAROUSEL_CARD = 'carousel-card';
    public const HERO_TALENT = 'hero-talent';
    public const TALENT_CARD = 'talent-card';
    public const CERTIFICATION_SLIDE = 'certification-slide';
    public const STRATEGY_SMALL_ANCHOR = 'strategy-small-anchor';
    public const STRATEGY_LARGE_ANCHOR = 'strategy-large-anchor';
    public const STRATEGY_CONTENT = 'strategy-content';
    public const IMG_EQUALITY = 'img-equality';
    public const JOIN_LAYOUT_1_SMALL = 'join-layout-1-small';
    public const JOIN_LAYOUT_1_MEDIUM = 'join-layout-1-medium';
    public const JOIN_LAYOUT_2_LARGE = 'join-layout-2-large';
    public const JOIN_LAYOUT_2_SMALL = 'join-layout-2-small';
    public const JOIN_LAYOUT_3 = 'join-layout-3';
    public const COVER_VIDEO_EXPAND = 'cover-video-expand';
    public const REDIRECT_CARD = 'redirect-card';
    public const DIRECTION_CARD = 'direction-card';
    public const CONTACT_PAGE = 'contact-page';

    private ComponentsManager $componentsManager;

    public function __construct(ComponentsManager $componentsManager)
    {
        $this->componentsManager = $componentsManager;
    }

    public static function registerImageSizes(): void
    {
        add_image_size(self::SMALL_ICONS, 22, 22);
        add_image_size(self::KIT_PRODUCT_SMALL, 60, 60);
        add_image_size(self::HERO_SMALL, 660, 540);
        add_image_size(self::HERO_FULL, 1360, 720);
        add_image_size(self::CONTACT_FULL, 1060, 310);
        add_image_size(self::SQUARRE_MEDIUM, 502, 502);
        add_image_size(self::ACTU_CARD, 400, 250);
        add_image_size(self::FULL_W_IMG, 1260, 485);
        add_image_size(self::ALONGSIDE_SMALL, 490, 400);
        add_image_size(self::ALONGSIDE_LARGE, 490, 660);
        add_image_size(self::ALONGSIDE_EXTRA_SMALL, 490, 306);
        add_image_size(self::CAROUSEL_CARD, 1280, 720);
        add_image_size(self::HERO_TALENT, 1440, 750);
        add_image_size(self::CERTIFICATION_SLIDE, 556, 405);
        add_image_size(self::STRATEGY_SMALL_ANCHOR, 610, 180);
        add_image_size(self::STRATEGY_LARGE_ANCHOR, 1260, 180);
        add_image_size(self::STRATEGY_CONTENT, 1260, 485);
        add_image_size(self::IMG_EQUALITY, 665, 570);
        add_image_size(self::JOIN_LAYOUT_1_SMALL, 264, 310);
        add_image_size(self::JOIN_LAYOUT_1_MEDIUM, 360, 525);
        add_image_size(self::JOIN_LAYOUT_2_LARGE, 795, 300);
        add_image_size(self::JOIN_LAYOUT_2_SMALL, 325, 300);
        add_image_size(self::JOIN_LAYOUT_3, 570, 600);
        add_image_size(self::COVER_VIDEO_EXPAND, 490, 720);
        add_image_size(self::CONTACT_PAGE, 585, 400);
        add_image_size(self::REDIRECT_CARD, 393, 429);
        add_image_size(self::DIRECTION_CARD, 265, 445);
        add_image_size(self::TALENT_CARD, 358, 565);
    }

    /**
     * Get image tag from image's ID
     *
     * @param int|array|null $imageId
     * @param array $attr
     * @param string|array $size
     *
     * @return string|null
     */
    public function getImageTag($imageId, string $size = 'thumbnail', array $attr = []): ?string
    {
        if (empty($imageId)) {
            return null;
        }

        return wp_get_attachment_image(is_array($imageId) ? array_first($imageId) : $imageId, $size, false, $attr);
    }

    /**
     * @param $imageId
     * @param string $size
     * @return array|false|null
     */
    public function getImageSrc($imageId, string $size = 'thumbnail')
    {
        if (empty($imageId)) {
            return null;
        }

        $imageData = wp_get_attachment_image_src($imageId, $size, false);

        return $imageData[array_key_first($imageData)] ?? '';
    }

    public function getUrlFromEmbed(string $embed): ?string
    {
        preg_match('/src="(.+?)"/', $embed, $matches);
        $src = $matches[1] ?? null;

        if (!empty($src)) {
            $url = $src;
        }

        return $url ?? null;
    }


    /*
     * Return the VideoComponent if a video is provided from the acf fields of the block
     * Return as simple image instead
     */
    public function formatVideoOrImage(
        array $data,
        string|null $preview,
        string $classes = '',
        string $ratios = '',
        bool $autoplay = false,
        bool &$isVideo = false
    ): ?string {
        if (!empty($data['youtube'])) {
            $youtubeUrl = $this->getUrlFromEmbed($data['youtube']);
            $video = $this->getVideoTag(
                $youtubeUrl,
                $preview,
                $classes,
                $ratios,
                true
            );

            $isVideo = true;
        } elseif (!empty($url = $data['video']['url'] ?? null)) {
            $video = $this->getVideoTag(
                $url,
                $preview,
                $classes,
                $ratios,
                false,
                $autoplay
            );

            $isVideo = true;
        } elseif (!empty($preview)) {
            $video = $preview;
        }

        return $video ?? null;
    }

    public function getVideoTag(
        string $url,
        string|null $preview,
        string $classes = '',
        string $ratios = '',
        bool $isYoutube = false,
        bool $autoplay = false
    ): string {
        if (true === $isYoutube) {
            preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $url, $match);
            $youtubeId = $match[1];
        }

        return $this->componentsManager->render(
            VideoComponent::class,
            [
                'isYoutube' => $isYoutube,
                'youtube_id' => $youtubeId ?? '',
                'preview' => $preview,
                'classes' => $classes,
                'ratios' => $ratios,
                'video_url' => $url,
                'autoplay' => $autoplay,
            ]
        );
    }
}
