<?php

namespace App\Core;

use App\Core\Interfaces\LoaderMethod;
use App\Core\Models\ModelFactory;
use App\Services\Mailer;
use Psr\Container\ContainerInterface;

use function App\template;

abstract class ControllerBase implements LoaderMethod
{
    /**
     * @var null
     */
    protected string $flexibleContent = '';
    /**
     * @var string|array
     */
    protected array $componentsAvailable = [];
    /**
     * @var ComponentsManager
     */
    protected $componentsManager;
    /**
     * @var ContainerInterface
     */
    private $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
        $this->componentsManager = $container->get(ComponentsManager::class);
    }

    /**
     * @param string $view
     * @param array $params
     *
     * @return string
     */
    public function render(string $view, array $params = []): void
    {
        echo template($view, $params);
    }

    /**
     * @return ContainerInterface
     */
    public function getContainer(): ContainerInterface
    {
        return $this->container;
    }

    /**
     * @return bool
     */
    public function isPostRequest(): bool
    {
        return ($_SERVER['REQUEST_METHOD'] === 'POST');
    }

    public function getParams()
    {
        return $_POST;
    }

    public function getParam($key)
    {
        return !empty($_POST[$key]) ? $_POST[$key] : '';
    }

    public function getQueryParams()
    {
        return $_GET;
    }

    public function getQueryParam($key)
    {
        return $_GET[$key];
    }

    public function woocommerceRender($view, $params = [])
    {
        global $product, $checkout;
        echo $this->container->get(RendererInterface::class)->render($view, $params);
    }

    /**
     * @return Mailer|mixed
     */
    protected function getMailer()
    {
        return $this->container->get(Mailer::class);
    }

    /**
     * @param string $model
     *
     * @return mixed
     */
    protected function loadModel(string $model)
    {
        return $this->container->get(ModelFactory::class)->load($model);
    }
}
