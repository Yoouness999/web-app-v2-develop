<?php namespace Modules\Datamanager\Facades;

use Arx\classes\Facade;

/**
 * Class DM stands for DataManager
 *
 * As you will use it a lot, it deserves a short exception :-)
 *
 * @package Modules\Datamanager\Facades
 */
class DM extends Facade
{
    public static function getFacadeAccessor(){
        return 'DM';
    }
}