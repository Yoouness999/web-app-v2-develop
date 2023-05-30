<?php

/**
* Helpers used by the Datamanager
*/

if (!function_exists('DM')) {
    /**
     * DM helper
     * @return Modules\Datamanager\Datamanager
     */
    function DM()
    {
        return Modules\Datamanager\Datamanager::getInstance();
    }
}