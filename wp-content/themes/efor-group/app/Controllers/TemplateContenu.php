<?php

declare(strict_types=1);

namespace app\Controllers;

use App\Core\ControllerBase;

class TemplateContenu extends ControllerBase
{
    public function execute(array $args): array
    {
        return [
            'content' => apply_filters(
                'template_single_contenu',
                apply_filters(
                    'the_content',
                    get_the_content()
                )
            ),
        ];
    }
}
