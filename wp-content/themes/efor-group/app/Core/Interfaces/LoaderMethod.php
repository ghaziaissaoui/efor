<?php

namespace App\Core\Interfaces;

interface LoaderMethod
{
    public function execute(array $args): array;
}
