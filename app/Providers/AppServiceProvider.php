<?php namespace App\Providers;

use App\Events\ItemUpdated;
use App\Events\ItemUpdatedEvent;
use App\Http\Controllers\BaseController;
use App\Item;
use App\User;
use Illuminate\Support\ServiceProvider;
use View;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AppServiceProvider extends ServiceProvider
{

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        require_once base_path('resources/macros.php');

        View::composer(['pages/*', 'profile/*', 'user/*', 'order/*', 'profile/*'], function (\Illuminate\View\View $view) {

            $body = array(
                'attributes' => array('class' => BaseController::$tplPrefixClass . str_replace(['::', '.'], '-', $view->getName()))
            );

            $view->with('body', $body);
        });
        /*DB::listen(function ($query) {
            Log::info($query->sql);     // the query being executed
            Log::info($query->time);    // query time in milliseconds
        });*/
    }

    /**
     * Register any application services.
     *
     * This service provider is a great spot to register your various container
     * bindings with the application. As you can see, we are registering our
     * "Registrar" implementation here. You can add your own bindings too!
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            'Illuminate\Contracts\Auth\Registrar',
            'App\Services\Registrar'
        );
    }

}
