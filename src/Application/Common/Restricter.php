<?php


namespace App\Application\Common;


class Restricter
{
    public function restrict(): bool
    {
        return (bool)rand(0, 1);
    }
}