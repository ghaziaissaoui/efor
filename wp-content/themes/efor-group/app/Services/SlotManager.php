<?php

namespace App\Services;

final class SlotManager
{
    public function render(
        $wp_query
    ) {
    }

    public function configureSlot($string, $formats, $id, $targeting, $display = true, $needRefresh = false)
    {
        if ($display) {
            $slot[$id] = "";

            if ($formats !== '') {
                $slot[$id] .= "googletag.defineSlot('$string', $formats, '$id')";
            } else {
                $slot[$id] .= "googletag.defineOutOfPageSlot('$string', '$id')";
            }

            if ($targeting && is_array($targeting)) {
                foreach ($targeting as $key => $target) {
                    if (\App\getEnv() !== 'prod') {
                        $targeting = $target[0] . '-test';
                    } else {
                        $targeting = $target[0];
                    }
                    $slot[$id] .= ".setTargeting('$key', ['$targeting'])";
                }
            }

            if ($needRefresh) {
                $slot[$id] .= ".setTargeting('refresh', 'true')";
            }

            $slot[$id] .= ".addService(googletag.pubads());\n";

            echo $slot[$id];
        }
    }
}
