<?php

/**
 * Load helpers and shortcodes
 */
require_once __DIR__ . '/../resources/helpers.php';
require_once __DIR__ . '/../resources/shortcodes.php';

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('employee/reset', 'EmployeePasswordController@getReset');
Route::post('employee/reset', 'EmployeePasswordController@postReset');

Route::get('/download/pdf/{id}', 'DownloadController@pdf');
Route::get('/download/v2/pdf/{id}', 'DownloadController@pdfV2');

/**
 * User linked urls protected by auth middleware
 */
Route::group(['middleware' => 'auth'], function () {
    //Route::controller('/user', 'UserController');
    Route::any('/user/billing', [\App\Http\Controllers\UserController::class, 'anyBilling']);
    Route::any('/user', [\App\Http\Controllers\UserController::class, 'anyIndex']);
    Route::any('/user/information', [\App\Http\Controllers\UserController::class, 'anyInformation']);
    Route::any('/user/invoices', [\App\Http\Controllers\UserController::class, 'anyInvoices']);
    Route::any('/user/manager', [\App\Http\Controllers\UserController::class, 'anyManager']);
    Route::any('/user/password', [\App\Http\Controllers\UserController::class, 'anyPassword']);
    Route::any('/user/pickup', [\App\Http\Controllers\UserController::class, 'anyPickup']);
    Route::any('manager', function () {
        return redirect('profile');
    });
});

Route::any('scan/:id', 'UserController@anyManager');

/**
 * Api V1 urls
 *
 * @todo dan
 */
//Route::controller('api/v1', 'ApiController');

Route::any('api/v1/beta-subscribe', [\App\Http\Controllers\ApiController::class, 'anyBetaSubscribe']);
Route::any('api/v1/check-coupon', [\App\Http\Controllers\ApiController::class, 'anyCheckCoupon']);
Route::any('api/v1/check-schedules', [\App\Http\Controllers\ApiController::class, 'anyCheckSchedules']);
Route::any('api/v1/cities', [\App\Http\Controllers\ApiController::class, 'anyCities']);
Route::any('api/v1/items/{status?}', [\App\Http\Controllers\ApiController::class, 'anyItems']);
Route::any('api/v1/plans', [\App\Http\Controllers\ApiController::class, 'anyPlans']);
Route::any('api/v1/schedule', [\App\Http\Controllers\ApiController::class, 'anySchedule']);
Route::any('api/v1/sync', [\App\Http\Controllers\ApiController::class, 'anySync']);
Route::any('api/v1/tva', [\App\Http\Controllers\ApiController::class, 'anyTva']);
Route::any('api/v1/types', [\App\Http\Controllers\ApiController::class, 'anyTypes']);
Route::any('api/v1/user', [\App\Http\Controllers\ApiController::class, 'anyUser']);
Route::post('api/v1/order', [\App\Http\Controllers\ApiController::class, 'postOrder']);
Route::post('api/v1/pickup', [\App\Http\Controllers\ApiController::class, 'postPickup']);

/**
 * Webhooks controller
 */
Route::any('webhook/adyen', 'WebhookController@adyenNotification');

/**
 * Auth controllers
 */
/*Route::controllers([
    'auth' => 'Auth\AuthController',
    'password' => 'Auth\PasswordController',
]);*/

Route::any('/login', 'PageController@anyLogin');
Route::any('/signup', 'PageController@anySignup');

Route::get('/auth/login/{one?}/{two?}/{three?}/{four?}/{five?}', 'Auth\\AuthController@getLogin')->name('login');
Route::post('/auth/login/{one?}/{two?}/{three?}/{four?}/{five?}', 'Auth\\AuthController@postLogin');
Route::get('/auth/register/{one?}/{two?}/{three?}/{four?}/{five?}', 'Auth\\AuthController@getRegister');
Route::post('/auth/register/{one?}/{two?}/{three?}/{four?}/{five?}', 'Auth\\AuthController@postRegister');
Route::get('/auth/logout', 'Auth\\AuthController@getLogout');

//Route::get("password/email/{one?}/{two?}/{three?}/{four?}/{five?}", [\App\Http\Controllers\Auth\PasswordController::class, "getEmail"]);
//Route::post("password/email/{one?}/{two?}/{three?}/{four?}/{five?}", [\App\Http\Controllers\Auth\PasswordController::class, "postEmail"]);

Route::get('/reset-password/{token}', function ($token) {
    return view('auth.reset', ['token' => $token]);
})->middleware('guest')->name('password.reset');


Route::get("password/email/{one?}/{two?}/{three?}/{four?}/{five?}", function () { return view('auth.password'); })->middleware('guest')->name('password.request');
Route::post("password/email", function (Request $request) {
    $request->validate(['email' => 'required|email']);

    $status = Password::sendResetLink(
        $request->only('email')
    );

    return $status === Password::RESET_LINK_SENT
        ? back()->withInput(['status' => __($status)])
        : back()->withErrors(['email' => __($status)]);
})->middleware('guest')->name('password.email');



Route::post('/reset-password', function (Request $request) {
    $request->validate([
        'token' => 'required',
        'email' => 'required|email',
        'password' => 'required|min:8|confirmed',
    ]);

    $status = Password::reset(
        $request->only('email', 'password', 'password_confirmation', 'token'),
        function ($user, $password) {
            $user->forceFill([
                'password' => Hash::make($password)
            ])->setRememberToken(Str::random(60));

            $user->save();

            event(new PasswordReset($user));
        }
    );

    return $status === Password::PASSWORD_RESET
        ? redirect()->route('login')->with('status', __($status))
        : back()->withErrors(['email' => [__($status)]]);
})->middleware('guest')->name('password.update');

/**
 * Oauth controllers
 */
Route::get("/oauth/connect/{provider}", [\App\Http\Controllers\OauthController::class, "getConnect"]);
Route::get("/oauth/register/{provider}", [\App\Http\Controllers\OauthController::class, "getRegister"]);
Route::any("/oauth/redirect/{provider}", [\App\Http\Controllers\OauthController::class, "anyRedirect"]);

Route::any("/cron/hourly", [\App\Http\Controllers\CronController::class, "anyHourly"]);
Route::any("/cron/monthly", [\App\Http\Controllers\CronController::class, "anyMonthly"]);
Route::any("/cron/daily", [\App\Http\Controllers\CronController::class, "anyDaily"]);

// Activate an account link
Route::get('activate/{code}', ['uses' => 'RedirectController@activateAccount', 'as' => 'activation']);

// Invitation link
Route::get('invite/{code?}', ['uses' => 'RedirectController@anyInvitation', 'as' => 'invitation']);

// Mail controller
//Route::controller('/mail', 'MailController');

/**
 * Pages of the websites
 */
//Route::controller('/p', 'PageController');

Route::any('/p/about', [\App\Http\Controllers\PageController::class, 'anyAbout']);
Route::any('/p/business', [\App\Http\Controllers\PageController::class, 'anyBusiness']);
Route::any('/p/merchandise', [\App\Http\Controllers\PageController::class, 'anyMerchandise']);
Route::any('/p/move', [\App\Http\Controllers\PageController::class, 'anyMove']);
Route::any('/p/contact', [\App\Http\Controllers\PageController::class, 'anyContact']);
Route::any('/p/faq', [\App\Http\Controllers\PageController::class, 'anyFaq']);
Route::any('/p/jobs', [\App\Http\Controllers\PageController::class, 'anyJobs']);
Route::any('/p/landing', [\App\Http\Controllers\PageController::class, 'anyLanding']);
Route::any('/p/partners', [\App\Http\Controllers\PageController::class, 'anyPartners']);
Route::any('/p/press', [\App\Http\Controllers\PageController::class, 'anyPress']);
Route::any('/p/pricing', [\App\Http\Controllers\PageController::class, 'anyPricing']);
Route::any('/p/service', [\App\Http\Controllers\PageController::class, 'anyService']);
Route::any('/p/storage-rules', [\App\Http\Controllers\PageController::class, 'anyStorageRules']);
Route::any('/p/terms', [\App\Http\Controllers\PageController::class, 'anyTerms']);

Route::any('/page/about', [\App\Http\Controllers\PageController::class, 'anyAbout']);
Route::any('/page/business', [\App\Http\Controllers\PageController::class, 'anyBusiness']);
Route::any('/page/merchandise', [\App\Http\Controllers\PageController::class, 'anyMerchandise']);
Route::any('/page/move', [\App\Http\Controllers\PageController::class, 'anyMove']);
Route::any('/page/contact', [\App\Http\Controllers\PageController::class, 'anyContact']);
Route::any('/page/faq', [\App\Http\Controllers\PageController::class, 'anyFaq']);
Route::any('/page/jobs', [\App\Http\Controllers\PageController::class, 'anyJobs']);
Route::any('/page/landing', [\App\Http\Controllers\PageController::class, 'anyLanding']);
Route::any('/page/partners', [\App\Http\Controllers\PageController::class, 'anyPartners']);
Route::any('/page/press', [\App\Http\Controllers\PageController::class, 'anyPress']);
Route::any('/page/pricing', [\App\Http\Controllers\PageController::class, 'anyPricing']);
Route::any('/page/service', [\App\Http\Controllers\PageController::class, 'anyService']);
Route::any('/page/storage-rules', [\App\Http\Controllers\PageController::class, 'anyStorageRules']);
Route::any('/page/terms', [\App\Http\Controllers\PageController::class, 'anyTerms']);

Route::any('/p/{area?}', [\App\Http\Controllers\PageController::class, 'anyIndex']);
Route::any('/page/{area?}', [\App\Http\Controllers\PageController::class, 'anyIndex']);

//Route::controller('/blog', 'BlogController');
Route::get('/blog/{slug}', ['uses' => 'BlogController@anyView', 'as' => 'view-post']);
Route::get('/blog', 'BlogController@anyIndex');
Route::get('/search', 'BlogController@anySearch');
Route::get('/blog/search', 'BlogController@anySearch');
//Route::controller('/page', 'PageController');
Route::any('/area/{area}', 'PageController@anyIndex');
Route::any('/terms', 'PageController@anyTerms');

Route::any("redirect/scan/{id}", [\App\Http\Controllers\RedirectController::class, "anyScan"]);
Route::any("redirect/invitation/{code}", [\App\Http\Controllers\RedirectController::class, "anyInvitation"]);


Route::any('/', 'PageController@anyIndex');


//Adyen redirect
Route::get('/challenge', 'PageController@challenge');
Route::any('/redirecting', 'PageController@adyenRedirect');

/**
 * Order v2
 */
Route::group(['prefix' => 'order'], function () {
    Route::any('/', function () {
        return redirect('/order/storage');
    });
    Route::get('/storage', 'OrderController@getStorage');
    Route::post('/storage/find-price', 'OrderController@postStorageFindPrice');
    Route::post('/storage/remove-plan-from-session', 'OrderController@postStorageRemovePlanFromSession');
    Route::post('/storage', 'OrderController@postStorage');

    Route::get('/calculator', 'OrderController@getCalculator');
    Route::post('/calculator', 'OrderController@postCalculator');

    Route::get('/services', 'OrderController@getServices');
    Route::post('/services', 'OrderController@postServices');

    Route::get('/appointment', 'OrderController@getAppointment');
    Route::post('/appointment', 'OrderController@postAppointment');
    Route::get('/time-slots', 'OrderController@getTimeSlots');

    Route::get('/billing', 'OrderController@getBilling');
    Route::post('/billing', 'OrderController@postBilling');

    Route::get('/review', 'OrderController@getReview');
    Route::post('/review', 'OrderController@postReview');

    Route::get('/confirmation/{orderBooking}', 'OrderController@getConfirmation');
});

require_once __DIR__ . "/profile.php";
