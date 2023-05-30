<?php

Route::group(['prefix' => 'arxmin/modules/boxifymanager', 'namespace' => 'Modules\BoxifyManager\Http\Controllers',
    'middleware' => ['arxmin']], function () {
    Route::controller('/users', 'UsersController');
    Route::controller('/items', 'ItemsController');
    Route::controller('/logs', 'LogsController');
    Route::controller('/fees', 'FeesController');
    Route::controller('/coupons', 'CouponsController');
    Route::controller('/invoices', 'InvoicesController');
    Route::controller('/api', 'ApiController');
    Route::controller('/risks', 'RisksController');
    Route::controller('/', 'BoxifyManagerController');
});
