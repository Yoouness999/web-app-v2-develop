<?php namespace App\Providers;

use App\Services\AppNotification;
use App\Services\PaymentNotification;
use Illuminate\Support\ServiceProvider;

class PaymentNotificationServiceProvider extends ServiceProvider {

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Set up the publishing of configuration
     */
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../config/payment_notification.php' => config_path('payment_notification.php')
        ]);
    }

    public function register()
    {
        $this->app->singleton(PaymentNotification::class, function($app) {
            return new AppNotification($app['config']['payment_notification']['slackUrl']);
        });
    }
}
