<?php

namespace App\GutenbergBlock;

use App\Core\Acf\AbstractGutenbergBlock;
use App\Core\ServicesContainer;
use App\Services\Image;

use function App\acfImageGroupImageCompo;

class DemoGutembergBlock extends AbstractGutenbergBlock
{
    private const BLOC_NAME = 'demo';

    protected function getAcfRegisterBlockArgs(): array
    {
        return $this->registerGutenbergBlock(self::BLOC_NAME, 'Block demo');
    }

    protected function extractData($block): array
    {
        return $this->formatExtractData($this->getDatas(), $block);
    }

    private function getDatas()
    {
        return [
            'cover' => ''
        ];
    }
}
