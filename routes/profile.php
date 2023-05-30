<?php
/**
 * Routes for the profile
 *
 * @note See app/Providers/RouteServiceProvider.php to find where this file is included.
 */

// Profile routes
Route::middleware('auth')->prefix('profile')->group(function () {

    Route::any('/user/billing', \App\Http\Controllers\UserController::class."@anyBilling");
    Route::any('/user', \App\Http\Controllers\UserController::class."@anyIndex");
    Route::any('/user/information', \App\Http\Controllers\UserController::class."@anyInformation");
    Route::any('/user/invoices', \App\Http\Controllers\UserController::class."@anyInvoices");
    Route::any('/user/manager', \App\Http\Controllers\UserController::class."@anyManager");
    Route::any('/user/password', \App\Http\Controllers\UserController::class."@anyPassword");
    Route::any('/user/pickup', \App\Http\Controllers\UserController::class."@anyPickup");

    /**
     * /account
     * | /account/informations
     * | /account/billing
     * | /account/invoice
     * | /account/password
     */
    Route::get('account/{tab?}', 'Profile\ProfileController@getAccount');
    Route::post('account/{tab?}', 'Profile\ProfileController@postAccount');

    Route::group(['middleware' => []], function (){
        /**
         * /manage
         * | /manage/stocked
         * | /manage/in_transit
         * | /manage/at_home
         */
        Route::any('manage/{tab?}', 'Profile\ProfileController@anyManage');
    });

    /**
     * /sponsorship
     * - new sponsors
     * - my sponsorship
     */
    Route::get('sponsorship', 'Profile\ProfileController@getSponsorship');
    Route::post('sponsorship', 'Profile\ProfileController@postSponsorship');

    /**
     * @deprecated ??? why
     */
    Route::any('api/v1/answers', 'Profile\ApiProfileController@anyAnswers');
    Route::any('api/v1/cancel-schedule', 'Profile\ApiProfileController@anyCancelSchedule');
    Route::any('api/v1/check-schedules', 'Profile\ApiProfileController@anyCheckSchedules');
    Route::any('api/v1/cities', 'Profile\ApiProfileController@anyCities');
    Route::any('api/v1/items', 'Profile\ApiProfileController@anyItems');
    Route::any('api/v1/plan', 'Profile\ApiProfileController@anyPlan');
    Route::any('api/v1/types', 'Profile\ApiProfileController@anyTypes');
    Route::get('api/v1/insurance', 'Profile\ApiProfileController@getInsurance');
    Route::get('api/v1/user', 'Profile\ApiProfileController@getUser');
    Route::post('api/v1/get-back', 'Profile\ApiProfileController@postGetBack');
    Route::post('api/v1/insurance', 'Profile\ApiProfileController@postInsurance');
    Route::post('api/v1/reschedule', 'Profile\ApiProfileController@postReschedule');
    Route::post('api/v1/services', 'Profile\ApiProfileController@postServices');
    Route::post('api/v1/sponsoring', 'Profile\ApiProfileController@postSponsoring');
    Route::post('api/v1/storing-duration', 'Profile\ApiProfileController@postStoringDuration');
    Route::get('api/v1/storing-duration', 'Profile\ApiProfileController@getStoringDurations');
    Route::get('api/v1/unavailable-dates', 'Profile\ApiProfileController@getUnavailableDates');
    Route::get('api/v1/pickups', 'Profile\ApiProfileController@getPickups');

    /**
     * /validation
     */
    Route::post('validation', 'Profile\ProfileController@postValidation');

    /**
     * Default route for /profile
     */
    Route::any('/', function () {
        return redirect('profile/manage');
    });
});
