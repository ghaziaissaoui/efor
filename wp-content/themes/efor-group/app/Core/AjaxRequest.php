<?php

declare(strict_types=1);

namespace App\Core;

abstract class AjaxRequest
{
    public const SECURITY_NONCE_ACTION = 'cosavostra_security_nonce';
    public const SECURITY_NONCE_ARG = 'security';
    public const SCOPE_NOPRIV = 'nopriv';
    /**
     * @var string
     */
    protected string $action;

    /**
     * @var string
     */
    protected string $scope;

    /**
     * Plug ajax hooks
     */
    public function listen(): void
    {
        add_action("wp_ajax_" . $this->action, [$this, 'checkAndExecute']);

        foreach (array_filter((array)$this->scope) as $scope) {
            add_action(sprintf("wp_ajax_%s_%s", $scope, $this->action), [$this, 'checkAndExecute']);
        }
    }

    final public function checkAndExecute(): void
    {
        check_ajax_referer(self::SECURITY_NONCE_ACTION, self::SECURITY_NONCE_ARG);
        $this->execute();
        wp_die();
    }

    /**
     * Protège la requête avec un nonce
     */
    abstract protected function execute();
}
