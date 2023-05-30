<?php

// Tests
Route::get('/tests/get', 'ApiTestsController@get');
Route::get('/tests/add', 'ApiTestsController@add');
Route::get('/tests/save', 'ApiTestsController@save');
Route::get('/tests/delete', 'ApiTestsController@delete');

Route::get('/api/maps/polygons', 'Api\ApiMapsController@getPolygons');

Route::group(['prefix' => 'api/v2', 'namespace' => 'Api\v2'], function(){
	// Api doc
	Route::get('/docs', function(){
		return View::make('docs.api.v2.index');
	});

	// Server infos
	Route::get('/server-time', 'ApiController@getServerTime');

	// Country
    Route::get('/countries', 'ApiCountriesController@get');

	// Coupons
    Route::get('/coupons', 'ApiCouponsController@get');
	Route::post('/coupons', 'ApiCouponsController@add');
	Route::put('/coupons', 'ApiCouponsController@save');

	// Unaivalables Dates
    Route::get('/unavailable-dates', [\App\Http\Controllers\Api\v2\ApiUnavailableDatesController::class, 'get']);
	Route::post('/unavailable-dates', [\App\Http\Controllers\Api\v2\ApiUnavailableDatesController::class, 'add']);
	Route::put('/unavailable-dates', [\App\Http\Controllers\Api\v2\ApiUnavailableDatesController::class, 'save']);
    Route::delete('/unavailable-dates', [\App\Http\Controllers\Api\v2\ApiUnavailableDatesController::class, 'delete']);

    // Posts
    Route::get('/posts', 'ApiPostsController@get');
    Route::post('/posts', 'ApiPostsController@add');
    Route::put('/posts', 'ApiPostsController@save');
    Route::delete('/posts', 'ApiPostsController@delete');

	// Event guests
    Route::get('/events/guests', 'ApiEventGuestsController@get');
	Route::post('/events/guests', 'ApiEventGuestsController@add');
	Route::put('/events/guests', 'ApiEventGuestsController@save');

	// Events
    Route::get('/events', 'ApiEventsController@get');
	Route::post('/events', 'ApiEventsController@add');
	Route::put('/events', 'ApiEventsController@save');

	// Fees
    Route::get('/fees', 'ApiFeesController@getList');
	Route::post('/fees', 'ApiFeesController@add');

	// Historicals
    Route::get('/historicals', 'ApiHistoricalsController@get');
	Route::post('/historicals', 'ApiHistoricalsController@add');
	Route::put('/historicals', 'ApiHistoricalsController@save');
	Route::delete('/historicals', 'ApiHistoricalsController@delete');

	// Historical categories
    Route::get('/historicals/categories', 'ApiHistoricalCategoriesController@get');
	Route::post('/historicals/categories', 'ApiHistoricalCategoriesController@add');
	Route::put('/historicals/categories', 'ApiHistoricalCategoriesController@save');

	// Invoices
    Route::get('/invoices', 'ApiInvoicesController@get');
	Route::post('/invoices', 'ApiInvoicesController@add');
	Route::put('/invoices', 'ApiInvoicesController@save');
    Route::delete('/invoices', 'ApiInvoicesController@delete');
	Route::get('/invoices/download', 'ApiInvoicesController@pdf');

	// Items
    Route::get('/items', 'ApiItemsController@get');
	Route::post('/items', 'ApiItemsController@add');
	Route::put('/items', 'ApiItemsController@save');
    Route::get('/items/types', 'ApiItemsController@types');
    Route::get('/items/statuses', 'ApiItemsController@statuses');
    Route::get('/items/pickup-options', 'ApiItemsController@pickupOptions');
    Route::post('/items/remove-file', 'ApiItemsController@removeFile');
    Route::delete('/items', 'ApiItemsController@delete');

	// Pickups
    Route::get('/pickups', 'ApiPickupsController@get');
	Route::post('/pickups', 'ApiPickupsController@add');
	Route::put('/pickups', 'ApiPickupsController@save');
    Route::get('/pickups/delivery-man/autocomplete', 'ApiPickupsController@autocompleteDeliveryMan');
    Route::get('/pickups/customer/autocomplete', 'ApiPickupsController@autocompleteCustomer');

	// Todos
    Route::get('/todos', 'ApiTodosController@get');
	Route::post('/todos', 'ApiTodosController@add');
	Route::put('/todos', 'ApiTodosController@save');

	// Users
    Route::get('/users', 'ApiUsersController@get');
	Route::post('/users', 'ApiUsersController@add');
	Route::put('/users', 'ApiUsersController@save');
	Route::get('/users/cities', 'ApiUsersController@cities');
	Route::any('/users/login', 'ApiUsersController@login');
    Route::delete('/users', 'ApiUsersController@delete');
    Route::get('/users/autocomplete', 'ApiUsersController@autocompleteUser');

	/*
	 * Order
	 */

	// Answers
    Route::get('/order/answers', 'ApiOrderAnswersController@get');
	Route::post('/order/answers', 'ApiOrderAnswersController@add');
	Route::put('/order/answers', 'ApiOrderAnswersController@save');

    // Area
    Route::get('/areas', 'ApiAreasController@get');
    Route::post('/areas', 'ApiAreasController@add');
    Route::put('/areas', 'ApiAreasController@save');
    Route::delete('/areas', 'ApiAreasController@delete');

	// Assurances
    Route::get('/order/assurances', 'ApiOrderAssurancesController@get');
	Route::post('/order/assurances', 'ApiOrderAssurancesController@add');
	Route::put('/order/assurances', 'ApiOrderAssurancesController@save');

	// Bookings
    Route::get('/order/bookings', 'ApiOrderBookingsController@get');
	Route::post('/order/bookings', 'ApiOrderBookingsController@add');
	Route::put('/order/bookings', 'ApiOrderBookingsController@save');
    Route::delete('/order/bookings', 'ApiOrderBookingsController@delete');

	// Booking statuses
    Route::get('/order/bookings/statuses', 'ApiOrderBookingStatusesController@get');
	Route::post('/order/bookings/statuses', 'ApiOrderBookingStatusesController@add');
	Route::put('/order/bookings/statuses', 'ApiOrderBookingStatusesController@save');

	// Calculator categories
    Route::get('/order/calculator/categories', 'ApiOrderCalculatorCategoriesController@get');
	Route::post('/order/calculator/categories', 'ApiOrderCalculatorCategoriesController@add');
	Route::put('/order/calculator/categories', 'ApiOrderCalculatorCategoriesController@save');

	// Calculator items
    Route::get('/order/calculator/items', 'ApiOrderCalculatorItemsController@get');
	Route::post('/order/calculator/items', 'ApiOrderCalculatorItemsController@add');
	Route::put('/order/calculator/items', 'ApiOrderCalculatorItemsController@save');

	// Plan assets
    Route::get('/order/plans/assets', 'ApiOrderPlanAssetsController@get');
	Route::post('/order/plans/assets', 'ApiOrderPlanAssetsController@add');
	Route::put('/order/plans/assets', 'ApiOrderPlanAssetsController@save');

	// Plan categories
    Route::get('/order/plans/categories', 'ApiOrderPlanCategoriesController@get');
	Route::post('/order/plans/categories', 'ApiOrderPlanCategoriesController@add');
	Route::put('/order/plans/categories', 'ApiOrderPlanCategoriesController@save');

	// Plans
    Route::get('/order/plans', 'ApiOrderPlansController@get');
	Route::post('/order/plans', 'ApiOrderPlansController@add');
	Route::put('/order/plans', 'ApiOrderPlansController@save');
	Route::delete('/order/plans', 'ApiOrderPlansController@delete');

    // Plans per regions
    Route::get('/order/plans/regions', 'ApiOrderPlanRegionController@get');
    Route::post('/order/plans/regions', 'ApiOrderPlanRegionController@add');
    Route::put('/order/plans/regions', 'ApiOrderPlanRegionController@save');
    Route::delete('/order/plans/regions', 'ApiOrderPlanRegionController@delete');

	// Questions
    Route::get('/order/questions', 'ApiOrderQuestionsController@get');
	Route::post('/order/questions', 'ApiOrderQuestionsController@add');
	Route::put('/order/questions', 'ApiOrderQuestionsController@save');

    // Regions
    Route::get('/regions', 'ApiRegionsController@get');
    Route::post('/regions', 'ApiRegionsController@add');
    Route::put('/regions', 'ApiRegionsController@save');
    Route::delete('/regions', 'ApiRegionsController@delete');

	// Storing durations
    Route::get('/order/storing-durations', 'ApiOrderStoringDurationsController@get');
	Route::post('/order/storing-durations', 'ApiOrderStoringDurationsController@add');
	Route::put('/order/storing-durations', 'ApiOrderStoringDurationsController@save');


    /**
     * Warehouses
     */
    Route::get('/warehouses', 'ApiWarehousesController@get');
    Route::post('/warehouses', 'ApiWarehousesController@add');
    Route::put('/warehouses', 'ApiWarehousesController@save');

    /**
     * Notifications
     */
    Route::get('/notifications', 'ApiNotificationsController@get');
    Route::post('/notifications', 'ApiNotificationsController@add');
    Route::put('/notifications', 'ApiNotificationsController@save');

	/*
	 * Arxmin
	 */

	// Arxmin users
    Route::get('/arxmin/users', 'ApiArxminUsersController@get');
	Route::post('/arxmin/users', 'ApiArxminUsersController@add');
	Route::put('/arxmin/users', 'ApiArxminUsersController@save');
    Route::delete('/arxmin/users', 'ApiArxminUsersController@delete');
	Route::post('/arxmin/login', 'ApiArxminUsersController@login');
    Route::get('/arxmin/permissions', 'ApiArxminUsersController@permissions');
    Route::get('/arxmin/reset', 'ApiArxminUsersController@reset');
});

Route::group(['prefix' => 'api/v3', 'namespace' => 'Api\v3'], function(){
	// Api doc
	Route::get('/docs', function(){
		return View::make('docs.api.v3.index');
	});


	// Api
	Route::get('/', 'ApiController@token');



	// Users
    Route::get('/users', 'ApiUsersController@get');
	Route::get('/users/current', 'ApiUsersController@current');
	Route::get('/users/token', 'ApiUsersController@token');
	Route::get('/users/cities', 'ApiUsersController@cities');
	Route::any('/users/login', 'ApiUsersController@login');
	Route::post('/users/subscribe', 'ApiUsersController@subscribe');
	Route::put('/users', 'ApiUsersController@save');

	// Items
    Route::get('/items', 'ApiItemsController@get');
    Route::get('/items/all', 'ApiItemsController@all');
	Route::post('/items', 'ApiItemsController@add');
	Route::put('/items', 'ApiItemsController@save');
	Route::any('/items/getback', 'ApiItemsController@getBack');
	Route::post('/items/savePicture', 'ApiItemsController@savePicture');
	Route::post('/items/many', 'ApiItemsController@addMany');

	// Pickups
    Route::get('/pickups', 'ApiPickupsController@get');
	Route::put('/pickups', 'ApiPickupsController@save');
	Route::post('/pickups', 'ApiPickupsController@add');
	Route::get('/pickups/list', 'ApiPickupsController@getList');
	Route::get('/pickups/timeslots', 'ApiPickupsController@timeSlots');


    // Warehouses
    Route::get('/warehouses', 'ApiWarehousesController@get');
    Route::post('/warehouses', 'ApiWarehousesController@add');
    Route::put('/warehouses', 'ApiWarehousesController@save');


    // Questions

    /**
     * Invoices
     */
    Route::get('/invoices', 'ApiInvoicesController@get');

    /**
     * Notifications
     */
    Route::get('/notifications', 'ApiNotificationsController@get');
    Route::post('/notifications', 'ApiNotificationsController@add');
    Route::put('/notifications', 'ApiNotificationsController@save');

	/*
	 * Order
	 */

	// Answers
    Route::get('/order/answers', 'ApiOrderAnswersQuestionsController@answers');
    Route::get('/order/questions', 'ApiOrderAnswersQuestionsController@questions');
    Route::get('/order/questions/next', 'ApiOrderAnswersQuestionsController@nextQuestion');

	// Calculator categories
    Route::get('/order/calculator/categories', 'ApiOrderCalculatorCategoriesController@get');

	// Calculator items
    Route::get('/order/calculator/items', 'ApiOrderCalculatorItemsController@get');

	// Plans
    Route::get('/order/plans', 'ApiOrderPlansController@get');

    // Regions
    Route::get('/areas', 'ApiAreasController@get');
    Route::get('/regions', 'ApiRegionsController@get');
	Route::get('/order/plans/regions', 'ApiOrderPlanRegionController@get');

    // Plan assets
    Route::get('/order/plans/assets', 'ApiOrderPlanAssetsController@get');

	// Assurances
    Route::get('/order/assurances', 'ApiOrderAssurancesController@get');
    Route::put('/order/assurances/user', 'ApiOrderAssurancesController@updateUser');

	// Storing duration
    Route::get('/order/duration', 'ApiOrderStoringDurationsController@get');
    Route::put('/order/duration/user', 'ApiOrderStoringDurationsController@updateUser');

	/*
     * Arxmin
     */

    // Arxmin users
    Route::get('/arxmin/users/current', 'ApiArxminUsersController@current');
    Route::get('/arxmin/users/token', 'ApiArxminUsersController@token');
    Route::get('/arxmin/users/pickups', 'ApiArxminUsersController@pickups');
    Route::any('/arxmin/users/login', 'ApiArxminUsersController@login');


	Route::post('/external/users/login', 'ApiExternalUsersController@login');
	Route::get('/external/users/token', 'ApiExternalUsersController@refreshToken');
});
