<?php

declare(strict_types=1);

namespace App\Core\Interfaces;

interface ModelDefaultInterface
{
    public function findOneById(int $id);
}
