<?php

namespace App\Core\AbstractModel;

use Psr\Container\ContainerInterface;

abstract class AbstractHooks
{
    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * AbastractHooks constructor.
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function getContainer(): ContainerInterface
    {
        return $this->container;
    }
}
