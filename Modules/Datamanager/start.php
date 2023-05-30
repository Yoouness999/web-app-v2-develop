<?php

/*
|--------------------------------------------------------------------------
| Register Namespaces And Routes
|--------------------------------------------------------------------------
|
| When a module starting, this file will executed automatically. This helps
| to register some namespaces like translator or view. Also this file
| will load the routes file for each module. You may also modify
| this file as you want.
|
*/

Arxmin::registerMenu(array(
    'name' => 'Data Manager',
    'link' => url('/arxmin/modules/datamanager/form'),
    'type' => 'module',
    'ico' => 'fa-pencil',
    'position' => 100,
    'children' => Modules\Datamanager\Datamanager::getMenu()
));

require __DIR__ . '/Http/routes.php';
