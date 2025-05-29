<?php

declare(strict_types=1);

namespace App\Core;

use function App\sage;

class ServicesContainer
{
    public static $instance = null;
    private $services = [];

    public function __construct()
    {
        $this->services = $this->getServices();
    }

    /**
     * @return mixed
     */
    public function getServices()
    {
        return apply_filters('cv_add_services', sage('config')->get('services')['services']);
    }

    public static function getInstance(): ?ServicesContainer
    {
        if (self::$instance === null) {
            return new self();
        }

        return self::$instance;
    }

    /**
     * @param string $serviceName
     * @return mixed|null
     */
    public function getService(string $serviceName)
    {
        if (array_key_exists($serviceName, $this->services)) {
            return $this->services[$serviceName];
        }
        return null;
    }
}
