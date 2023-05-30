<?php

Route::group(['prefix' => 'arxmin/modules/labelmanager', 'namespace' => 'Modules\Labelmanager\Http\Controllers',
    'before' => []],
    function () {
        Route::post('/api/label/create', 'ApiLabelController@store');
        Route::get('/api/label', 'ApiLabelController@index');
        Route::any('/api/label/update/{id?}', 'ApiLabelController@update');
        Route::delete('/api/label/delete/{id?}', 'ApiLabelController@destroy');
        Route::any('/import', 'LabelManagerController@anyImport');
        Route::any('/export', 'LabelManagerController@anyExport');
        Route::any('/', 'LabelManagerController@anyIndex');
    });