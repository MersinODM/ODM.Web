<?php


namespace App\Traits;


use Illuminate\Support\Str;

trait RandomCodeGenerator
{
    /**
     * Rastgele kod oluşturucu
     * @return string
     */
    private function getRandomCode()
    {
        return strtoupper(Str::random(6));
    }
}