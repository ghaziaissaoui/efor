<?php

declare(strict_types=1);

namespace App\Hooks;

use App\Core\Interfaces\HookAdminInterface;
use App\Core\Interfaces\HookFrontInterface;
use App\Core\Interfaces\HookInterface;
use App\Services\Hooks\Acf as AcfService;

/**
 *
 * Configure all the hooks relating to the CMP consent manager
 */
class ConsentAxeptio implements HookInterface
{
    /**
     * @var array
     */
    private static $config = [
        'iframe' => [
            [
                'domainName' => 'youtube.com',
                'vendor' => 'Youtube',
            ],
        ]
    ];

    public function hook(): void
    {
        add_filter('the_content', [$this, 'blockContent']);
    }

    public function blockContent(string $content): string
    {
        $dom = $this->loadHtml($content);
        $xpath = new \DOMXPath($dom);

        $this->blockIframes($xpath, $dom);

        return $dom->saveHTML();
    }

    private function blockIframes(\DOMXPath $xpath, \DOMDocument $dom): void
    {
        foreach (self::$config['iframe'] as $iframe) {
            $nodes = $xpath->query(sprintf('//iframe[contains(@src,"%s")]', $iframe['domainName']));
            $nodesDiv = $xpath->query(sprintf('//div[contains(@data-video,"%s")]', $iframe['domainName']));

            foreach ($nodes as $node) {
                $node->setAttribute('data-src', $node->getAttribute('src'));
                $node->setAttribute('data-requires-vendor-consent', $iframe['vendor']);
                $currentClass = $node->getAttribute('class');
                $node->setAttribute('class', sprintf('u-hidden %s', $currentClass));

                $node->removeAttribute("src");

                $root = $this->loadTemplate($dom, $iframe['vendor']);

                $node->parentNode->insertBefore($root, $node);
            }

            if ($nodesDiv->length != 0) {
                foreach ($nodesDiv as $nodeDiv) {
                    $nodeDiv->setAttribute('data-requires-vendor-consent', $iframe['vendor']);
                    $nodeDiv->setAttribute('class', 'u-hidden');

                    $root = $this->loadTemplate($dom, $iframe['vendor']);

                    $nodeDiv->parentNode->insertBefore($root, $nodeDiv);
                }
            }
        }
    }


    /**
     * @see https://stackoverflow.com/questions/8218230/php-domdocument-loadhtml-not-encoding-utf-8-correctly
     */
    private function loadHtml(string $html): \DOMDocument
    {
        $dom = new \DOMDocument('1.0', 'UTF-8');
        libxml_use_internal_errors(true);
        $dom->loadHTML('<?xml encoding="utf-8" ?>' . $html, LIBXML_HTML_NODEFDTD | LIBXML_HTML_NOIMPLIED);
        libxml_clear_errors();
        libxml_use_internal_errors(false);
        return $dom;
    }

    private function loadTemplate(\DOMDocument $dom, string $vendor): \DOMElement
    {
        $root = $dom->createElement('div');
        $root->setAttribute('class', 'rgpd-notice t-align-center bg-gray-40');
        $root->setAttribute('data-hide-on-vendor-consent', $vendor);

        $container = $dom->createElement('div');
        $container->setAttribute('class', 'rgpd-notice__container t-align-center u-padding-2');
        $root->appendChild($container);

        $notice = $dom->createElement('p', pll__('Ce contenu n\'est pas visible à cause du paramétrage de vos cookies.'));
        $notice->setAttribute('class', 't-header-medium');
        $container->appendChild($notice);

        $button = $dom->createElement('button');
        $button->setAttribute('onclick', 'window.axeptioSDK.requestConsent("'.$vendor.'")');
        $button->setAttribute('class', 'button bg-black c-white arrow u-margin-t-3');
        $container->appendChild($button);

        $text = $dom->createTextNode(pll__('Ouvrir les paramètres des cookies'));
        $button->appendChild($text);

        $round = $dom->createElement('div');
        $round->setAttribute('class', 'round');
        $button->appendChild($round);

        $cross = $dom->createElement('div');
        $cross->setAttribute('class', 'cross');
        $round->appendChild($cross);

        return $root;
    }
}
