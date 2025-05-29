<?php

declare(strict_types=1);

namespace App\Core\Acf;

use App\Core\Interfaces\HookInterface;

use function App\template;

abstract class AbstractGutenbergBlock implements HookInterface
{
    public function hook()
    {
        if (true === function_exists('acf_register_block')) {
            add_action('init', function () {
                acf_register_block(
                    array_merge(
                        [
                            'render_callback' => [$this, 'render']
                        ],
                        $this->getAcfRegisterBlockArgs()
                    )
                );
            });
        }
    }

    abstract protected function getAcfRegisterBlockArgs(): array;

    /**
     * Each block  have a dedicated template to render its content
     *
     * @param array $block
     */
    public function render(array $block): void
    {
        echo template(
            $this->getPath($block),
            array_merge(
                $this->extractData($block),
                ['block' => $block]
            )
        );
    }

    /**
     * extract from acf fields declare into each gutenberg block
     * @return array
     */
    abstract protected function extractData($block): array;

    protected function getPath(array $block): string
    {
        return 'gutenberg-blocks.'.str_replace('acf/', '', $block['name']);
    }

    protected function formatExtractData($data, $block): array
    {
        return [
            'data' => $data,
            'template' => str_replace('/', '.', $block['name'])
        ];
    }

    protected function getPreview(string $blockName): string
    {
        return get_template_directory_uri(). '/views/partials/blocks/preview/'. $blockName . '.png';
    }

    protected function registerGutenbergBlock(string $blockName, string $blockTitle): array
    {
        return [
            'name' => $blockName,
            'title' => $blockTitle,
            'description' => $blockTitle,
            'category' => 'blocs-cosavostra',
            'icon' => 'admin-comments',
            'keywords' => [
                'text'
            ],
            'example'  => [
                'attributes' => [
                    'mode' => 'preview',
                    'data' => [
                        'preview_image_help' => $this->getPreview($blockName),
                    ]
                ]
            ]
        ];
    }
}
