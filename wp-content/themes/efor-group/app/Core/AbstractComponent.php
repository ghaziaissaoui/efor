<?php

namespace App\Core;

use App\Services\BuilderService;
use ReflectionClass;
use StoutLogic\AcfBuilder\FieldsBuilder;

use function App\template;

abstract class AbstractComponent
{
    protected string $name = '';

    protected bool $isFlexibleComponent = false;
    protected bool $isGutenbergBlock = false;

    protected ?FieldsBuilder $builder = null;
    protected FieldsBuilder $gutenbergBuilder;

    private string $childClassName = '';

    public function __construct(BuilderService $builder)
    {
        $this->childClassName = (new ReflectionClass($this))->getShortName();

        if (true === $this->isFlexibleComponent) {
            $this->builder = $builder->getBuilderField()->addLayout(
                str_replace('\\', '::', get_class($this)),
                ['title' => $this->name]
            );

            if (is_array($this->mapping ?? null)) {
                add_filter('mapping_blocks_flexible_content', [$this, 'mappingBlocksFlexibleContent']);
            }

            $this->setBuilder($this->builder);
        }

        if (true === $this->isGutenbergBlock) {
            $this->gutenbergBuilder = new FieldsBuilder(sanitize_title($this->name));
            $this->gutenbergBuilder->setLocation(
                'block',
                '==',
                'acf/' . sanitize_title($this->name)
            );

            $this->setBuilder($this->gutenbergBuilder);

            if (true === function_exists('acf_register_block')) {
                add_action('acf/init', function () {
                    acf_register_block(
                        array_merge(
                            [
                                'render_callback' => [$this, 'render']
                            ],
                            $this->getAcfRegisterBlockArgs()
                        )
                    );
                    acf_add_local_field_group($this->gutenbergBuilder->build());
                });
            }
        }
    }

    protected function setBuilder(FieldsBuilder $builder): void
    {
    }

    protected function getAcfRegisterBlockArgs(): array
    {
        return $this->registerGutenbergBlock(sanitize_title($this->name), $this->name);
    }

    protected function registerGutenbergBlock(string $blockName, string $blockTitle): array
    {
        return [
            'name' => $blockName,
            'title' => $blockTitle,
            'description' => $blockTitle,
            'category' => 'blocs-cosavostra',
            'icon' => 'admin-comments',
            'folder' => $this->childClassName,
            'keywords' => [
                'text'
            ],
            'example' => [
                'attributes' => [
                    'mode' => 'preview',
                    'data' => [
                        'preview_image_help' => $this->getPreview(),
                    ]
                ]
            ]
        ];
    }

    protected function getPreview(): string
    {
        $filePath = sprintf(
            '/app/Components/%s/screenshot.png',
            $this->childClassName
        );

        if (file_exists(dirname(get_template_directory()) . $filePath)) {
            return dirname(get_template_directory_uri()) . $filePath;
        }

        return '';
    }

    public function mappingBlocksFlexibleContent($array)
    {
        $key = str_replace('\\', '::', get_class($this));
        $array[$key] = array_reduce($this->mapping, function ($acc, $item) {
            $acc[] = $item === 'home' ? (int)get_option('page_on_front') : $item;
            return $acc;
        }, []);

        return $array;
    }

    public function render($folder, $data): string
    {
        global $current_screen;

        if (is_array($folder) && isset($folder['folder'])) {
            $data = get_fields();
            unset($data['acf_fc_layout']);

            if (method_exists($this, 'sanitize') && !is_admin() && !wp_is_json_request()) {
                $data = $this->sanitize($data);
            }

            if (file_exists(dirname(get_template_directory()) . '/app/Components/' . $folder['folder'] . '/view.blade.php')) {
                if ($current_screen !== null && $current_screen->is_block_editor()
                    || wp_is_json_request()
                ) {
                    echo '<div style="    width: 100%;
    cursor: pointer;
    display: flex;
    align-items: center;
    flex-direction: row-reverse;
    justify-content: flex-end;
    border: 1px solid #e0e0e0;
    background-color: #f8f8f8;
    border-radius: 4px">
                            <span style="margin-left: 16px">' . $this->name . '</span>
                            <img src="' . $this->getPreview() . '" style="width: 175px;height: 100px;object-fit: contain;">
                        </div>';
                } elseif (!wp_is_json_request()) {
                    echo template($folder['folder'] . '.view', ['data' => $data]);
                }
            }
        } else {
            if (method_exists($this, 'sanitize')) {
                $data = $this->sanitize($data);
            }

            if (file_exists(dirname(get_template_directory()) . '/app/Components/' . $folder . '/view.blade.php')) {
                return apply_filters(
                    'starter_component_render',
                    template($folder . '.view', ['data' => $data]),
                    $folder
                );
            }
        }

        return '';
    }
}
