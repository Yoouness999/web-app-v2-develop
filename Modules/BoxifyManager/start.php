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

Arxmin::registerMenu([
        'name' => 'Boxify Manager',
        'ref' => 'manager',
        'type' => 'module',
        'ico' => 'fa-archive',
        'link' => url('/arxmin/modules/boxifymanager'),
        'position' => 0,
        'children' => [
            [
                'name' => 'Dashboard',
                'ref' => 'manager',
                'type' => 'module',
                'ico' => 'fa-archive',
                'link' => url('/arxmin/modules/boxifymanager'),
                'position' => 0,
            ],
            [
                'name' => 'Items Manager',
                'ref' => 'manager',
                'type' => 'module',
                'ico' => 'fa-archive',
                'link' => url('/arxmin/modules/boxifymanager/items'),
                'position' => 0,
            ],
            [
                'name' => 'Users Manager',
                'ref' => 'manager',
                'type' => 'module',
                'ico' => 'fa-users',
                'link' => url('/arxmin/modules/boxifymanager/users'),
                'position' => 1,
            ],
            [
                'name' => 'Invoices',
                'ref' => 'manager',
                'type' => 'module',
                'ico' => 'fa-archive',
                'link' => url('/arxmin/modules/boxifymanager/invoices'),
                'position' => 2,
            ],
            [
                'name' => 'Coupons',
                'ref' => 'manager',
                'type' => 'module',
                'ico' => 'fa-archive',
                'link' => url('/arxmin/modules/boxifymanager/coupons'),
                'position' => 2,
            ],
            [
                'name' => 'Qr Code Generator',
                'ref' => 'manager',
                'type' => 'module',
                'ico' => 'fa-archive',
                'link' => url('/arxmin/modules/boxifymanager/qrcode'),
                'position' => 2,
            ],
            [
                'name' => 'Import objet',
                'ref' => 'manager',
                'type' => 'module',
                'ico' => 'fa-archive',
                'link' => url('/arxmin/modules/boxifymanager/import'),
                'position' => 2,
            ]
        ]
]);

/*Arxmin::registerMenu([
        'name' => 'Invoices',
        'ref' => 'manager',
        'type' => 'module',
        'ico' => 'fa-archive',
        'link' => url('/arxmin/modules/boxifymanager/invoices'),
        'position' => 2,
]);

Arxmin::registerMenu([
        'name' => 'Code Generator',
        'ref' => 'manager',
        'type' => 'module',
        'ico' => 'fa-archive',
        'link' => url('/arxmin/modules/boxifymanager/generator'),
        'position' => 3,
]);

Arxmin::registerMenu([
        'name' => 'Logs',
        'ref' => 'manager',
        'type' => 'module',
        'ico' => 'fa-archive',
        'link' => url('/arxmin/modules/boxifymanager/logs'),
        'position' => 4,
]);*/

/*Arxmin::registerMenu([
        'name' => 'Fees',
        'ref' => 'manager',
        'type' => 'module',
        'ico' => 'fa-archive',
        'link' => url('/arxmin/modules/boxifymanager/fees'),
        'position' => 5,
]);*/

require __DIR__ . '/Http/routes.php';
