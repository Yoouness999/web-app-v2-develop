<?php

namespace Blok\LaravelHook\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Blok\LaravelHook\Hook
 */
class Hook extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'hook';
    }
}
