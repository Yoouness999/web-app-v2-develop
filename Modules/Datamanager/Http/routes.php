<?php

Route::group([
    'prefix' => 'arxmin/modules/datamanager',
    'namespace' => 'Modules\Datamanager\Http\Controllers',
    'middleware' => ['arxmin']
], function () {
    Route::controller('data', 'DataController');
    Route::controller('structure', 'StructureController');
    Route::controller('form', 'FormController');
    Route::controller('category', 'CategoryController');
    Route::controller('tag', 'TagController');
    Route::controller('menu', 'MenuController');

    /**
     * Datamanager Api Routing
     */
    Route::resource('api/post', 'ApiPostController');
    Route::controller('api', 'ApiController');
});
