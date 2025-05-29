<?php

namespace App\Components\TalentsSliderComponent;

use App\Components\Traits\AcfBuilderTrait;
use App\Core\AbstractComponent;
use App\Core\Models\TalentModel;
use App\Services\BuilderService;
use App\Services\TalentFormatterService;
use StoutLogic\AcfBuilder\FieldsBuilder;

use function App\getTextColorBasedOnBackground;

if (!defined('ABSPATH')) {
    exit('Cheatin&#8217; uh?');
}

class TalentsSliderComponent extends AbstractComponent
{
    use AcfBuilderTrait;

    protected string $name = 'Talents Slider Component';

    protected bool $isFlexibleComponent = true; //true to enable flexible
    protected bool $isGutenbergBlock = true; //true to enable gutenberg block
    private TalentModel $talentModel;
    private TalentFormatterService $talentFormatterService;

    public function __construct(
        BuilderService $builder,
        TalentModel $talentModel,
        TalentFormatterService $talentFormatterService
    ) {
        parent::__construct($builder);
        $this->talentModel = $talentModel;
        $this->talentFormatterService = $talentFormatterService;
    }

    /*
    * Use this method to modify the ACF field data before returning it to the component's view (default: return base ACF data)
    */
    public function sanitize($data)
    {
        $data['talents'] = array_map(
            function ($talent) {
                return $this->talentFormatterService->formatTalent($talent);
            },
            $this->talentModel->getLatests()
        );

        if (!empty($data['background'])) {
            $data['global_text_color'] = getTextColorBasedOnBackground($data['background']);
        }

        return $data;
    }

    /*
    * ACF config for both Gutenberg and flexible component are created here using the FieldsBuilder library see docs here : https://github.com/StoutLogic/acf-builder/wiki
    */
    public function setBuilder(FieldsBuilder $builder): void
    {
        $builder
            ->addGroup('title', [
                'label' => 'Titre',
            ])
                ->addText('title_1', [
                    'label' => 'Titre 1',
                ])
                ->addText('title_2', [
                    'label' => 'Titre 2',
                ])
            ->endGroup()
            ->addSelect('background', [
                'label' => 'Couleur du fond',
                'choices' => $this->getColorChoicesBackground(),
            ])
        ;

        $this->addBlockMarginSelect($builder);
    }
}
