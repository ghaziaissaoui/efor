<?php

namespace App;

use App\Core\Boot;
use Roots\Sage\Config;
use Roots\Sage\Container;

/**
 * Get the sage container.
 *
 * @param null $abstract
 * @param array $parameters
 * @param Container|null $container
 * @return Container|mixed
 */
function sage($abstract = null, $parameters = [], Container $container = null)
{
    $container = $container ?: Container::getInstance();
    if (!$abstract) {
        return $container;
    }

    return $container->bound($abstract)
        ? $container->makeWith($abstract, $parameters)
        : $container->makeWith("sage.{$abstract}", $parameters);
}

/**
 * Get / set the specified configuration value.
 *
 * If an array is passed as the key, we will assume you want to set an array of values.
 *
 * @param array|string $key
 * @param mixed $default
 * @return mixed|Config
 * @copyright Taylor Otwell
 * @link https://github.com/laravel/framework/blob/c0970285/src/Illuminate/Foundation/helpers.php#L254-L265
 */
function config($key = null, $default = null)
{
    if (is_null($key)) {
        return sage('config');
    }
    if (is_array($key)) {
        return sage('config')->set($key);
    }
    return sage('config')->get($key, $default);
}

/**
 * @param string $file
 * @param array $data
 * @return string
 */
function template($file, $data = [])
{
    return sage('blade')->render($file, $data);
}

/**
 * Retrieve path to a compiled blade view
 * @param $file
 * @param array $data
 * @return string
 */
function template_path($file, $data = [])
{
    return sage('blade')->compiledPath($file, $data);
}

/**
 * @param $asset
 * @return string
 */
function asset_path($asset = null)
{
    $distUri = sage('assets')->dist;

    if ($asset === null) {
        // If $asset is null, just return the asset folder URI,
        // which by default is dist/ in the theme folder
        return $distUri;
    } else {
        $asset_trail = explode('/', $asset);
        $value = sage('assets')->manifest;

        // Return the asset URI from the manifest.
        // If the asset is not in the manifest, return $asset, unchanged
        foreach ($asset_trail as $key) {
            if (isset($value[$key])) {
                $value = $value[$key];
            } else {
                $value = $asset;
                break;
            }
        }

        return "{$distUri}/{$value}";
    }
}

function dev_asset_path($asset = null)
{
    $distUri = config('assets.dev_uri');

    return $asset === null
        ? $distUri
        : "{$distUri}/{$asset}";
}

/**
 * @param string|string[] $templates Possible template files
 * @return array
 */
function filter_templates($templates)
{
    $paths = apply_filters('sage/filter_templates/paths', [
        'views',
        'resources/views'
    ]);
    $paths_pattern = "#^(" . implode('|', $paths) . ")/#";

    return collect($templates)
        ->map(function ($template) use ($paths_pattern) {
            /** Remove .blade.php/.blade/.php from template names */
            $template = preg_replace('#\.(blade\.?)?(php)?$#', '', ltrim($template));

            /** Remove partial $paths from the beginning of template names */
            if (strpos($template, '/')) {
                $template = preg_replace($paths_pattern, '', $template);
            }

            return $template;
        })
        ->flatMap(function ($template) use ($paths) {
            return collect($paths)
                ->flatMap(function ($path) use ($template) {
                    return [
                        "{$path}/{$template}.blade.php",
                        "{$path}/{$template}.php",
                    ];
                })
                ->concat([
                    "{$template}.blade.php",
                    "{$template}.php",
                ]);
        })
        ->filter()
        ->unique()
        ->all();
}

/**
 * @param string|string[] $templates Relative path to possible template files
 * @return string Location of the template
 */
function locate_template($templates)
{
    return \locate_template(filter_templates($templates));
}

/**
 * Determine whether to show the sidebar
 * @return bool
 */
function display_sidebar()
{
    static $display;
    isset($display) || $display = apply_filters('sage/display_sidebar', false);
    return $display;
}

function asset_uri()
{
    return get_theme_file_uri() . '/dist';
}

function getEnv()
{
    return !defined('ENV') ? 'prod' : ENV;
}

function camelCase($string, $capitalizeFirstCharacter = false)
{
    $str = str_replace('-', '', ucwords($string, '-'));

    if (!$capitalizeFirstCharacter) {
        $str = lcfirst($str);
    }

    return $str;
}

function getClassName($class)
{
    $path = explode('\\', $class);
    return $path[count($path) - 2];
}

function component($cpt, $args = [])
{
    return Boot::singleton()->getContainer()->get("\\App\\Components\\$cpt\\$cpt")->render($cpt, $args);
}

function getOptionField(string $field)
{
    return get_field($field, 'option');
}

function getTextColorBasedOnBackground(string $color): string
{
    switch ($color) {
        case 'white':
        case 'gray-20':
        case 'gray-0':
            $color = 'black-graphite';
            break;
        case 'black-graphite':
        case 'green':
            $color = 'white';
            break;
        default:
            break;
    }

    return $color;
}

function slugify($text, string $divider = '-')
{
    // replace non letter or digits by divider
    $text = preg_replace('~[^\pL\d]+~u', $divider, $text);

    // transliterate
    $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

    // remove unwanted characters
    $text = preg_replace('~[^-\w]+~', '', $text);

    // trim
    $text = trim($text, $divider);

    // remove duplicate divider
    $text = preg_replace('~-+~', $divider, $text);

    // lowercase
    $text = strtolower($text);

    if (empty($text)) {
        return 'n-a';
    }

    return $text;
}
