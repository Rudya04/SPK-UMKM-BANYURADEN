<?php

namespace App\Traits;

trait SlugFormatTrait
{
    public function clearString(string $value): string
    {
        return preg_replace("/[^A-Za-z0-9]/", "", $value);
    }
}
