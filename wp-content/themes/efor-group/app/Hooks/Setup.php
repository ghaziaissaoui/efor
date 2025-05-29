<?php

namespace App\Hooks;

use App\Core\Interfaces\HookFrontInterface;
use App\Services\Hooks\AdminBarService;
use App\Services\Hooks\MaintenanceService;
use App\Services\Hooks\RestService;
use App\Services\Hooks\ThemeActivationService;

use function App\asset_path;

class Setup implements HookFrontInterface
{
    private RestService $restService;
    private AdminBarService $adminBarService;
    private MaintenanceService $maintenanceService;

    /**
     * Admin constructor.
     * @param ThemeActivationService $themeService
     */
    public function __construct(
        RestService        $restService,
        AdminBarService    $adminBarService,
        MaintenanceService $maintenanceService
    ) {
        $this->restService = $restService;
        $this->adminBarService = $adminBarService;
        $this->maintenanceService = $maintenanceService;
    }

    public function hookFront(): void
    {
        $this->disableXmlRpc();
        $this->configureHeadersXOptions();
        $this->configureHeaderHSTS();
        $this->configureContentSecurityPolicy();
        $this->adminLogo();

        add_filter('rest_authentication_errors', [$this->restService, 'protectAPI'], 10, 1);
        add_action('admin_bar_menu', [$this->adminBarService, 'adminBar'], 500);
        add_action('template_redirect', [$this->maintenanceService, 'maintenanceMode'], 10, 1);
    }

    /**
     * As mentionned in wordpres reference the hook 'xmlrpc_enabled' does not control full ensabled ou disabled XML-RPC
     * service. "it only controls whether XML-RPC methods requiring authentication – such as for publishing purposes –
     * are enabled."
     *
     * The XML-RPC service is fully disabled because of XmlRpcNullServer class. It is a mocking service : it always send
     * a 403 response.
     *
     * @see https://developer.wordpress.org/reference/hooks/xmlrpc_enabled/
     */
    private function disableXmlRpc(): void
    {
        add_filter('xmlrpc_enabled', '__return_false');
        add_filter('wp_xmlrpc_server_class', function (): string {
            return 'App\XmlRpc\XmlRpcNullServer';
        });
        remove_action('wp_head', 'rsd_link');
    }

    /**
     * @see https://developer.mozilla.org/fr/docs/Web/HTTP/Headers/X-Content-Type-Options
     * @see https://developer.mozilla.org/fr/docs/Web/HTTP/Headers/X-Frame-Options
     */
    private function configureHeadersXOptions(): void
    {
        add_action('send_headers', function () {
            header("X-Frame-Options: sameorigin");
            header("X-Content-Type-Options: nosniff");
        });
    }

    /**
     *  the max age is configured to 1 year in prod, 1 second in all others environnements
     *
     * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/Strict-Transport-Security
     */
    private function configureHeaderHSTS(): void
    {
        add_action('send_headers', function () {
            header(
                sprintf(
                    'Strict-Transport-Security: max-age=%d',
                    (\App\getEnv() === 'prod') ? 365 * 24 * 60 * 60 : 1
                )
            );
        });
    }

    /**
     * @see https://developer.mozilla.org/fr/docs/Web/HTTP/CSP
     */
    private function configureContentSecurityPolicy(): void
    {
        add_action('send_headers', function () {
            $config = require __DIR__ . '/../../config/csp.php';

            if (true === empty($config)) {
                return;
            }

            $csp = '';
            foreach ($config as $src => $allowed) {
                $csp .= sprintf('%s %s;', $src, implode(' ', $allowed));
            }

            header(sprintf('Content-Security-Policy: %s', $csp));
        });
    }

    private function adminLogo(): void
    {
        add_action('login_enqueue_scripts', function () {
            ?>
            <style type="text/css">
                #login h1 a, .login h1 a {
                    background-image: url(<?php echo asset_path('images/logo-client.png'); ?>);
                }
            </style>
            <?php
        });
    }
}
