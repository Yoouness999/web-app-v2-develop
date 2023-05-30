<?php

Route::group(['prefix' => 'arxmin/modules/filemanager', 'namespace' => 'Modules\Filemanager\Http\Controllers'], function()
{
	Route::get('/', 'FileManagerController@index');
});