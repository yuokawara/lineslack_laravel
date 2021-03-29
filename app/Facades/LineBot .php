<?php

namespace App\Facades;

// use Illuminate\Support\Facades\Facade;

/**
 * Class LineBot
 * @package App\Facades
 *
 * @mixin \LINE\LINEBot
 */

class LineBot
{
    protected static function getFacadeAccessor()
    {
        return 'line-bot';
    }
}