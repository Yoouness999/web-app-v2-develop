<?php

namespace App\Traits;

trait SingletonTrait
{
    private static $_aInstances = array();

    public static function getInstance(){

        $sClass = static::class;

        if (!isset(self::$_aInstances[$sClass])) {
            self::$_aInstances[$sClass] = new $sClass;
        }

        return self::$_aInstances[$sClass];
    }
}
