<?php

namespace App\Controllers;

use App\Core\ControllerBase;

class FrontPage extends ControllerBase
{
    public function execute(array $args): array
    {
        return [
            'content' => apply_filters('the_content', get_the_content()),
        ];
    }
}
