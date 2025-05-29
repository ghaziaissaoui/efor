<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Components\ContactPageComponent\ContactPageComponent;
use App\Core\AbstractComponent;
use App\Core\ComponentsManager;
use App\Services\BuilderService;
use App\Services\Image;

class TemplateContact extends AbstractComponent
{
    private ComponentsManager $componentsManager;
    private Image $image;

    public function __construct(
        BuilderService $builder,
        ComponentsManager $componentsManager,
        Image $image
    ) {
        parent::__construct($builder);
        $this->componentsManager = $componentsManager;
        $this->image = $image;
    }

    public function execute(): array
    {
        return [
            'contact' => $this->componentsManager->render(
                ContactPageComponent::class,
                $this->getAcfData(),
            )
        ];
    }

    private function getAcfData(): array
    {
        global $post;

        if (!empty($id = get_field('image', $post->ID))) {
            $img = $this->image->getImageTag(
                $id,
                $this->image::CONTACT_PAGE,
                ['class' => 'ratio-block__content']
            );
        }

        if (!empty($formId = get_field('form_id', $post->ID))) {
            $form = do_shortcode('[contact-form-7 id="' . $formId . '" title="'. pll__('Formulaire de contact') .'"]');
        }

        return [
            'title' => get_field('title', $post->ID) ?? [],
            'content' => get_field('content', $post->ID) ?? '',
            'image' => $img ?? '',
            'form' => $form ?? '',
        ];
    }
}
