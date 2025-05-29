<?php

namespace App\Components\MapComponent;

use App\Core\AbstractComponent;
use StoutLogic\AcfBuilder\FieldsBuilder;

if (!defined('ABSPATH')) {
    exit('Cheatin&#8217; uh?');
}

class MapComponent extends AbstractComponent
{
    protected string $name = 'Map Component';

    protected bool $isFlexibleComponent = false; //true to enable flexible
    protected bool $isGutenbergBlock = false; //true to enable gutenberg block

    /*
    * Use this method to modify the ACF field data before returning it to the component's view (default: return base ACF data)
    */
    public function sanitize($data)
    {
        $data['maptiler_key'] = MAPTILER_API_KEY ?? '';
        $data['maptiler_map_id'] = MAPTILER_CUSTOM_MAP_KEY ?? '';

        return $data;
    }

    /*
    * ACF config for both Gutenberg and flexible component are created here using the FieldsBuilder library see docs here : https://github.com/StoutLogic/acf-builder/wiki
    */
    public function setBuilder(FieldsBuilder $builder): void
    {
    }
}
