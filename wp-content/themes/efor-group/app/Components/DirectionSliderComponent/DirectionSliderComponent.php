<?php

namespace App\Components\DirectionSliderComponent;

use App\Components\Traits\AcfBuilderTrait;
use App\Core\AbstractComponent;
use App\Services\BuilderService;
use App\Services\Image;
use StoutLogic\AcfBuilder\FieldsBuilder;

use function App\getTextColorBasedOnBackground;

if (!defined('ABSPATH')) {
    exit('Cheatin&#8217; uh?');
}

class DirectionSliderComponent extends AbstractComponent
{
    use AcfBuilderTrait;

    protected string $name = 'Direction Slider Component';

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
    */
    public function sanitize($data)
    {
        if (!empty($data['members'])) {
            foreach ($data['members'] as &$member) {
                $member['member_image'] = $this->image->getImageTag(
                    $member['member_image']['ID'] ?? '',
                    $this->image::DIRECTION_CARD,
                    $this->image::DEFAULT_CLASS
                );
            }
        }

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
            ->addRepeater('members', [
                'label' => 'Membres de la direction',
                'min' => 1,
                'layout' => 'row',
                'button_label' => 'Ajouter un membre',
            ])
                ->addField(
                    'member_image',
                    'image_aspect_ratio_crop',
                    $this->getImageCropData(265, 445),
                )
                ->addText('member_title', [
                    'label' => 'Nom du membre',
                ])
                ->addText('member_job', [
                    'label' => 'Poste du membre',
                ])
        ;

        $this->addBlockMarginSelect($builder);
    }
}
