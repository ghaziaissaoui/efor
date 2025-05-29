<?php

namespace App\Services\Hooks;

use App\Services\SlotManager;
use Psr\Container\ContainerInterface;

class ScriptService
{
    private ContainerInterface $container;
    private SlotManager $slotManager;

    public function __construct(
        ContainerInterface $container,
        SlotManager $slotManager
    ) {
        $this->container = $container;
        $this->slotManager = $slotManager;
    }

    public function scripts(): void
    {
        $scripts = [
            'global' => []
        ];

        if ($this->container->get('enable_pub_ads')) {
            $scripts['global']['secure-pub-ads-defer'] =
                ['https://securepubads.g.doubleclick.net/tag/js/gpt.js', [], false];
        }

        $this->registerScripts($scripts);
    }

    /**
     * @param array $scriptsConfig
     */
    private function registerScripts(array $scriptsConfig): void
    {
        foreach ($scriptsConfig as $conditionalTag => $scripts) {
            if (function_exists($conditionalTag) && $conditionalTag()) {
                $this->addScripts($scriptsConfig[$conditionalTag]);
            } elseif ($conditionalTag === 'global') {
                $this->addScripts($scriptsConfig['global']);
            }
        }
    }

    private function addScripts(array $scripts): void
    {
        foreach ($scripts as $handle => $script) {
            wp_enqueue_script($handle, $script[0], $script[1], '', $script[2]);
        }
    }

    public function customScript()
    {
        $this->definePubsSlost();
    }

    private function definePubsSlost()
    {
        global $wp_query; ?>
        <script type="text/javascript">
            var slots = {};

            window.googletag = window.googletag || {cmd: []};
            googletag.cmd.push(function () {
                <?php
                $this->slotManager->render($wp_query); ?>
                googletag.pubads().collapseEmptyDivs();
                googletag.pubads().enableLazyLoad();
                googletag.pubads().enableLazyLoad({fetchMarginPercent: -1});
                googletag.pubads().enableLazyLoad({
                    // Fetch slots within 5 viewports.
                    fetchMarginPercent: 100,
                    // Render slots within 2 viewports.
                    renderMarginPercent: 200,
                    // Double the above values on mobile, where viewports are smaller
                    // and users tend to scroll faster.
                    mobileScaling: 2.0
                });
                googletag.pubads().addEventListener('slotRequested', function (event) {
                    updateSlotStatus(event.slot.getSlotElementId(), 'fetched');
                });
                googletag.pubads().addEventListener('slotOnload', function (event) {
                    updateSlotStatus(event.slot.getSlotElementId(), 'rendered');
                });
                googletag.enableServices();
            });

            function updateSlotStatus(slotId, state) {
                console.log(slotId)
            }
        </script>
        <?php
    }
}
