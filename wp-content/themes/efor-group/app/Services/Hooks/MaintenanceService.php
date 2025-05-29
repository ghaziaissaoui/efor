<?php

declare(strict_types=1);

namespace App\Services\Hooks;

class MaintenanceService
{
    private const MAINTENANCE_PAGE_ID = 'maintenance_page_id';
    private const MAINTENANCE_MODE = 'maintenance_mode';
    private const OPTION_FIELD_NAME = 'option';

    public function maintenanceMode(): void
    {
        if (function_exists('get_field') && get_field(self::MAINTENANCE_PAGE_ID, self::OPTION_FIELD_NAME)) {
            $maitenancePage = get_page_link(get_field(self::MAINTENANCE_PAGE_ID, self::OPTION_FIELD_NAME));
            if (!is_admin() &&
                !is_user_logged_in() &&
                get_field(self::MAINTENANCE_MODE, self::OPTION_FIELD_NAME) &&
                !is_page(get_field(self::MAINTENANCE_PAGE_ID, self::OPTION_FIELD_NAME))
            ) {
                wp_safe_redirect($maitenancePage);
            } elseif (!get_field(self::MAINTENANCE_MODE, self::OPTION_FIELD_NAME) &&
                is_page(get_field(self::MAINTENANCE_PAGE_ID, self::OPTION_FIELD_NAME))
            ) {
                wp_safe_redirect(home_url('/'));
            }
        }
    }
}
