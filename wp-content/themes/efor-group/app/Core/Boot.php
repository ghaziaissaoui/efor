<?php

namespace App\Core;

use App\Controllers\App;
use App\Core\Interfaces\HookAdminInterface;
use App\Core\Interfaces\HookFrontInterface;
use App\Core\Interfaces\HookInterface;
use App\Services\Image;
use Brain\Hierarchy\Hierarchy;
use DI\ContainerBuilder;
use Exception;

use function App\camelCase;
use function App\sage;
use function App\template;

class Boot
{
    private static $instance;
    private $container;
    private $services = [];
    private $components = [];

    /**
     * boot constructor.
     *
     * @param string $DI_config
     *
     * @throws Exception
     */
    public function __construct(string $DI_config)
    {
        $this->initContainer($DI_config);

        foreach ($this->getContainer()->get('hooks') as $service) {
            $this->services[] = $this->getContainer()->get($service);
        }

        $this->buildComponents(dirname(get_stylesheet_directory()) . '/app/Components/', 'App\\Components\\');

        add_action('after_setup_theme', array($this, 'hooks'));
    }

    /**
     * @param $config
     *
     * @throws Exception
     */
    private function initContainer($config): void
    {
        $builder = new ContainerBuilder();
        $builder->addDefinitions($config);
        $this->container = $builder->build();
    }

    /**
     * @return mixed
     */
    public function getContainer()
    {
        return $this->container;
    }

    public function buildComponents($path, $namespace): void
    {
        $files = array_diff(scandir($path), ['..', '.', 'Services', 'partials', 'templates', 'Interfaces']);
        foreach ($files as $filename) {
            $pathCheck = $path . '/' . $filename;

            if ($filename === 'Actions.php' || $filename === 'Filters.php') {
                $this->services = array_merge(
                    [$this->container->get($namespace . str_replace('.php', '', $filename))],
                    $this->services
                );
            } else {
                if (is_dir($pathCheck)) {
                    $this->buildComponents($pathCheck, $namespace . $filename . '\\');
                    continue;
                }

                $pathinfo = pathinfo($filename);

                if ('php' !== $pathinfo['extension'] ||
                    $pathinfo['filename'] === 'view.blade' ||
                    strpos($pathinfo['filename'], '.blade') ||
                    !array_key_exists('extension', $pathinfo)
                ) {
                    continue;
                }

                $this->components[] = $namespace . str_replace('.php', '', $filename);
            }
        }
    }

    /**
     * @param string $DI_config
     *
     * @return boot
     * @throws Exception
     */
    public static function getInstance(string $DI_config): boot
    {
        if (null === self::$instance) {
            self::$instance = new boot($DI_config);
        }

        return self::$instance;
    }

    /**
     * Retourne l'instance de la classe
     *
     * @return mixed
     */
    public static function singleton()
    {
        return self::$instance;
    }

    public function hooks()
    {
        add_theme_support('woocommerce');
        /**
         * Load Image service function to register custom image sizes
         */
        Image::registerImageSizes();

        foreach ($this->getContainer()->get('ajax') as $ajax) {
            if ($this->getContainer()->get($ajax) instanceof AjaxRequest) {
                call_user_func(
                    [$this->getContainer()->get($ajax), 'listen'],
                    []
                );
            }
        }

        foreach ($this->getServices() as $service) {
            if ($service instanceof HookFrontInterface && false === is_admin()) {
                $service->hookFront();
            }

            if ($service instanceof HookAdminInterface && true === is_admin()) {
                $service->hookAdmin();
            }

            if ($service instanceof HookInterface) {
                $service->hook();
            }
        }

        foreach (apply_filters('cv_starter_components', $this->components) as $component) {
            if (false === str_contains($component, 'Traits')) {
                $this->container->get($component);
            }
        }
    }

    /**
     * @return array
     */
    public function getServices(): array
    {
        return $this->services;
    }

    /**
     *
     * @throws Exception
     */
    public function boot(): void
    {
        add_filter('template_include', [$this, 'templateLoader'], 100, 1);
    }

    /**
     * @param $template
     *
     * @return mixed
     */
    public function templateLoader($template)
    {
        global $wp_query;
        $hierarchy = new Hierarchy(0);
        $templates = $hierarchy->getTemplates($wp_query);
        $data = collect(get_body_class())->reduce(function ($data, $class) use ($template) {
            return apply_filters("sage/template/{$class}/data", $data, $template);
        }, []);

        $this->shareGlobalVars();

        $this->executeController($templates, $template, $data);

        return get_stylesheet_directory() . '/index.php';
    }

    public function shareGlobalVars(): void
    {
        if (file_exists(get_theme_file_path() . '/app/Controllers/App.php')) {
            $appClass = App::class;
            foreach (get_class_methods($this->getContainer()->get($appClass)) as $publicMethod) {
                if (strpos($publicMethod, '__') === false) {
                    sage('blade')
                        ->share(
                            $publicMethod,
                            call_user_func([$this->getContainer()->get($appClass), $publicMethod])
                        );
                }
            }
        }
    }

    private function executeController($templates, $template, $data): void
    {
        $this->interceptController($templates, $template, $data);
    }

    /**
     * @param $templates
     * @param $template
     * @param $data
     */
    private function interceptController($templates, $template, $data): void
    {
        foreach (array_merge(array_diff(get_body_class(), $templates), $templates) as $controller) {
            $controllerPath = dirname(__DIR__) . '/Controllers/' . camelCase($controller, true) . '.php';
            $controllerName = camelCase($controller, true);
            $controller = str_replace('"', '', '\App\Controllers\"' . $controllerName . '"');
            if (file_exists($controllerPath)) {
                $data = array_merge($data, call_user_func(
                    [$this->getContainer()->get($controller), 'execute'],
                    []
                ));
                if (method_exists($this->getContainer()->get($controller), 'setView')) {
                    $view = $this->getContainer()->get($controller)->setView();
                    if ($view !== null) {
                        $template = $view;
                    }
                }
                $templateEx = explode('/', $template);
                echo template(str_replace('.blade.php', '', $templateEx[count($templateEx) - 1]), $data);
                exit;
            }
        }

        echo template('404', $data);
        exit;
    }

    /**
     * @return mixed
     */
    public function getConfig()
    {
        return $this->config;
    }
}
