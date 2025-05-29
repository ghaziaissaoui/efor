<?php

namespace App\Components\ExpertComponent;

use App\Components\Traits\AcfBuilderTrait;
use App\Core\AbstractComponent;
use App\Services\BuilderService;
use App\Services\Image;
use StoutLogic\AcfBuilder\FieldsBuilder;

if (!defined('ABSPATH')) {
    exit('Cheatin&#8217; uh?');
}

class ExpertComponent extends AbstractComponent
{
    use AcfBuilderTrait;

    protected string $name = 'Expert Component';

    protected bool $isFlexibleComponent = true; //true to enable flexible
    protected bool $isGutenbergBlock = true; //true to enable gutenberg block
    private Image $image;

    public function __construct(BuilderService $builder, Image $image)
    {
        parent::__construct($builder);
        $this->image = $image;
    }

    /*
    * Use this method to modify the ACF field data before returning it to the component's view (default: return base ACF data)
    * If using it outside WP, change all $data[] values by your values
    */
    public function sanitize($data)
    {
        $data['experts'] = $this->sanitizeExperts($data['experts']);

        return $data;
    }

    /*
    * ACF config for both Gutenberg and flexible component are created here using the FieldsBuilder library see docs here : https://github.com/StoutLogic/acf-builder/wiki
    */
    public function setBuilder(FieldsBuilder $builder): void
    {
        $builder
            ->addTab('Titre')
                ->addText('experts_title_default', [
                    'label' => 'Titre 1',
                    'instructions' => __('Part of title displayed with the default font family'),
                    'wrapper' => [
                        'width' => '50%',
                    ],
                ])
                ->addText('experts_title_secondary', [
                    'label' => 'Titre 2',
                    'instructions' => __('Part of title displayed with the secondary font family'),
                    'wrapper' => [
                        'width' => '50%',
                    ],
                ])
            ->addTab('Contenu')
                ->addRepeater('experts', ['label' => 'Experts','min' => 1, 'layout' => 'row'])
                    ->addField(
                        'expert_image',
                        'image_aspect_ratio_crop',
                        $this->getImageCropData(500, 500),
                    )
                    ->addText('expert_title', [
                        'label' => 'Titre',
                    ])
                    ->addText('expert_subtitle', [
                        'label' => 'Sous titre',
                    ])
                    ->addTextarea('expert_description', [
                        'label' => 'Description',
                    ])
        ;

        $this->addBlockMarginSelect($builder);
    }

    private function sanitizeExperts(array $experts): array
    {
        $formattedExperts = [];

        if (!empty($experts)) {
            foreach ($experts as $expert) {
                if (!empty($id = $expert['expert_image']['ID'])) {
                    $expertImage = $this->image->getImageTag(
                        $id,
                        $this->image::SQUARRE_MEDIUM,
                        ['class' => 'expert-component-block__image ratio-block__content']
                    );
                }

                $formattedExperts[] = [
                    'title' => $expert['expert_title'] ?? '',
                    'description' => $expert['expert_description'] ?? '',
                    'subtitle' => $expert['expert_subtitle'] ?? '',
                    'image' => $expertImage ?? '',
                ];
            }
        }

        return $formattedExperts;
    }
}
