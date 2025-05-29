<?php

namespace App\Core;

use App\Controllers\App;
use App\Services\Acf;
use Psr\Container\ContainerInterface;

use function App\getClassName;
use function App\sage;
use function App\template;

class ComponentsManager
{
    private ContainerInterface $container;
    private Acf $acf;

    /**
     * ComponentsManager constructor.
     * @param ContainerInterface $container
     */
    public function __construct(
        ContainerInterface $container,
        Acf                $acf
    ) {
        $this->container = $container;
        $this->acf = $acf;
    }

    public function renderFlexible()
    {
        return $this->acf->loadFC(sage('config')->get('theme')['flexibleContent'])->renderBlocks();
    }

    public function render(string $cpt, $args = []): string
    {
        if (class_exists($cpt)) {
            /** @var AbstractComponent $instance */
            $instance = $this->container->get($cpt);
            return $instance->render(getClassName($cpt), $args);
        }
    }
}
