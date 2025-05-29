<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\ControllerBase;
use App\Services\TalentFormatterService;
use Psr\Container\ContainerInterface;

class SingleTalent extends ControllerBase
{
    private TalentFormatterService $talentFormatterService;

    public function __construct(ContainerInterface $container, TalentFormatterService $talentFormatterService)
    {
        parent::__construct($container);
        $this->talentFormatterService = $talentFormatterService;
    }

    public function execute(array $args): array
    {
        global $post;

        return ['data' => $this->talentFormatterService->getContent($post)];
    }
}
