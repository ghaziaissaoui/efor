<?php

declare(strict_types=1);

namespace App\Services;

use StoutLogic\AcfBuilder\FieldsBuilder;

class BuilderService
{
    private FieldsBuilder $builder;

    public function __construct()
    {
        $this->builder = new FieldsBuilder('builder');
        $this->builder
            ->setLocation('post_type', '==', 'page')
            ->or('post_type', '==', 'post')
            ->addFlexibleContent('components', ['button_label' => 'Add Component']);
    }

    public function getBuilderField(): \StoutLogic\AcfBuilder\FieldBuilder
    {
        return $this->builder->getField('components');
    }

    public function getBuilder(): FieldsBuilder
    {
        return $this->builder;
    }
}
