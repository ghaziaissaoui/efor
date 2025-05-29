<?php

declare(strict_types=1);

namespace App\Ajax;

use App\Core\AjaxRequest;

class DemoRequestError extends AjaxRequest
{
    protected string $action = 'demo-request-error';

    protected string $scope = self::SCOPE_NOPRIV;

    /**
     * Cette fonction execute la logique back de votre requête AJAX
     */
    protected function execute(): void
    {
        wp_send_json_error(__('Your error message', 'cosavostra'));
    }
}
