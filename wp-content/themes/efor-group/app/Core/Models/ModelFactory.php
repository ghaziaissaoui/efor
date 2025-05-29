<?php

namespace App\Core\Models;

class ModelFactory
{
    public function load($model)
    {
        return new $model();
    }
}
