<?php

namespace App\Components\ContactComponent;

use App\Components\ImgLandscapeBtnComponent\ImgLandscapeBtnComponent;
use App\Components\Traits\AcfBuilderTrait;
use App\Core\AbstractComponent;
use App\Core\ComponentsManager;
use App\Services\BuilderService;
use App\Services\Image;
use StoutLogic\AcfBuilder\FieldsBuilder;

use function App\getOptionField;

if (!defined('ABSPATH')) {
    exit('Cheatin&#8217; uh?');
}

class ContactComponent extends AbstractComponent
{
    use AcfBuilderTrait;

    protected string $name = 'Contact Component';

    protected bool $isFlexibleComponent = true; //true to enable flexible
    protected bool $isGutenbergBlock = true; //true to enable gutenberg block
    private Image $image;
    private ComponentsManager $componentsManager;

    public function __construct(
        BuilderService $builder,
        Image $image,
        ComponentsManager $componentsManager
    ) {
        parent::__construct($builder);
        $this->image = $image;
        $this->componentsManager = $componentsManager;
    }

    /*
    * Use this method to modify the ACF field data before returning it to the component's view (default: return base ACF data)
    */
    public function sanitize($data)
    {
        if (!empty($id = $data['image']['ID'] ?? null)) {
            $data['image'] = $this->image->getImageTag(
                $id,
                $this->image::CONTACT_FULL,
                ['class' => 'ratio-block__content'],
            );
        }

        if (!empty($formId = getOptionField('cf7_contact_component_id'))) {
            $data['form_title'] = pll__('Candidatez de manière spontanée, une offre pourrait bien correspondre à votre profil');
            $data['form_id'] = do_shortcode('[contact-form-7 id="' . $formId . '" title="'. pll__('Formulaire de candidature spontanée') .'"]');
        }

        if (!empty($data['link_color'])) {
            $data['link_color_text'] = $this->getButtonColorFromBackground($data['link_color']);
        }

        $data['img_landscape_btn'] = $this->componentsManager->render(
            ImgLandscapeBtnComponent::class,
            [
                'image' => $data['image'],
                'link' => $data['link'] ?? [],
                'stand_alone' => false,
                'link_color' => $data['link_color'] ?? '',
                'link_color_text' => $data['link_color_text'] ?? '',
            ]
        );

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
            ->addField(
                'image',
                'image_aspect_ratio_crop',
                $this->getImageCropData(1060, 310),
            )
            ->addLink('link', [
                'label' => 'Lien',
            ])
            ->addSelect('link_color', [
                'label' => 'Couleur du bouton',
                'choices' => $this->getColorChoices(),
                'allow_null' => 0,
            ])
        ;

        $this->addBlockMarginSelect($builder);
    }
}
