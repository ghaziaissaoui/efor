<?php

namespace App\Services\Hooks;

use WP_Error;

use function App\config;

class RestService
{
    public function protectAPI($result)
    {
        $rest_route = $GLOBALS['wp']->query_vars['rest_route'];
        if (false === is_user_logged_in() && in_array($rest_route, config('theme')['rest_routes_disabled'], true)) {
            return new WP_Error('rest_not_allowed', 'Your are not allowed.', array('status' => 403));
        }

        return $result;
    }
}
