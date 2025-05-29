<?php

declare(strict_types=1);

namespace App\Services;

use App\Core\AbstractComponent;
use Psr\Container\ContainerInterface;

use function App\config;
use function App\getClassName;
use function App\template;

class Acf
{
    public array $blocks;

    public string $html;
    private ContainerInterface $container;

    /**
     * Acf constructor.
     * @param ContainerInterface $container
     */
    public function __construct(
        ContainerInterface $container
    ) {
        $this->container = $container;
    }

    public function loadFC(string $fieldID): Acf
    {
        global $post;

        if (!function_exists('get_field')) {
            $this->blocks = [];
            $this->html = '';
        } else {
            $this->blocks = get_field($fieldID, $post->ID) ?: [];
            $this->html = '';
        }

        return $this;
    }

    /**
     * @param array $blocks
     */
    public function renderBlocks(): string
    {
        foreach ($this->blocks as $block) {
            $acf_fc_layout = $block['acf_fc_layout'];
            $cpt_class = str_replace('::', '\\', $acf_fc_layout);
            if (class_exists($cpt_class)) {
                /** @var AbstractComponent $instance */
                $instance = $this->container->get($cpt_class);
                $this->html .= $instance->render(
                    getClassName($cpt_class),
                    array_filter($block, function ($key) {
                        return $key !== 'acf_fc_layout';
                    }, ARRAY_FILTER_USE_KEY)
                );
            }
        }

        return $this->render();
    }

    private function render(): string
    {
        return apply_filters('the_content_acf_fc', $this->html);
    }

    /**
     * Allow to add preview images for Flexible content block inside admin (better for client)
     * @see /resources/views/partials/blocks/preview
     * Image format : PNG
     * Image name = ${block-name}.png
     */
    public function previewImages(): void
    {
        $siteURL = dirname(get_template_directory_uri()) . '/'; ?>
        <style type="text/css">
            .imagePreview {
                position: absolute;
                right: calc(100% + 12px);
                bottom: 0;
                z-index: 999999;
                border: 1px solid #f2f2f2;
                box-shadow: 0px 0px 3px #b6b6b6;
                background-color: #fff;
                padding: 20px;
            }

            .imagePreview img {
                width: 300px;
                height: auto;
                display: block;
                object-fit: cover
            }

            .acf-tooltip li:hover {
                background-color: #0074a9;
                position: relative
            }
        </style>
        <script>
            jQuery(document).ready(function ($) {
                $('a[data-name=add-layout]').click(function () {
                    waitForEl('.acf-tooltip li', function () {
                        $('.acf-tooltip li a').hover(function () {
                            const imageName = $(this).attr('data-layout').split('::').slice(0, -1);
                            const path = imageName.join('/') + '/screenshot.png';
                            $(this).append('<div class="imagePreview">' +
                                '<img src="<?php echo $siteURL; ?>' + path + '">' +
                                '</div>'
                            );
                        }, function () {
                            $(this).find('.imagePreview').remove();
                        });
                    });
                })
                const waitForEl = function (selector, callback) {
                    if (jQuery(selector).length) {
                        callback();
                    } else {
                        setTimeout(function () {
                            waitForEl(selector, callback);
                        }, 100);
                    }
                };
            })
        </script>
        <?php
    }

    public function mappingBlocks($field)
    {
        global $post;
        $template = get_page_template_slug($post->ID);
        // get the layout mapping, or an empty array
        // just in case it's not defined
        $mapping = array_key_exists('mapping_blocks_flexible_content', config('theme')) ?
            config('theme')['mapping_blocks_flexible_content'] :
            [];

        // from John Huebner's clever approach...
        $layouts = $field['layouts'];
        $field['layouts'] = [];

        foreach ($layouts as $layout) {
            $key = $layout['name'];

            // if the layout name isn't in our mapping array
            // assume it available for all posts that the field rules allow
            if (!array_key_exists($key, $mapping)) {
                $field['layouts'][] = $layout;
                continue;
            }

            $allow_type = in_array($post->post_type, $mapping[$key], true);
            $allow_template = in_array($template, $mapping[$key], true);
            $allow_id = in_array($post->ID, $mapping[$key], true);
            $block_id = in_array(-1 * $post->ID, $mapping[$key], true);

            // enable the layout if the current post type or post ID is allowed
            // and the current ID is not explicitly excluded (note negative ID)
            if (($allow_type || $allow_id || $allow_template) && !$block_id) {
                $field['layouts'][] = $layout;
            }
        }

        return $field;
    }
}
