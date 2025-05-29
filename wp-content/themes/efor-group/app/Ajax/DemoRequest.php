<?php

declare(strict_types=1);

namespace App\Ajax;

use App\Core\AjaxRequest;

class DemoRequest extends AjaxRequest
{
    protected string $action = 'demo-request';

    protected string $scope = self::SCOPE_NOPRIV;

    /**
     * Cette fonction execute la logique back de votre requête AJAX
     */
    protected function execute(): void
    {
        if (isset($_POST['message'])) {
            wp_send_json_success($_POST['message']);
        }

        wp_send_json_error(__('Your error message', 'cosavostra'));
    }
}
