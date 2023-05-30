<?php
namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Adyen\Client as AdyenClient;
use Adyen\Config as AdyenConfig;
use Adyen\Environment as AdyenEnvironment;

class AdyenServiceProvider extends ServiceProvider
{
	
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;
	
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../config/adyen.php' => config_path('adyen.php'),
        ], 'config');
        $this->app->bind(AdyenClient::class, function () {
            $config = $this->app['config']['adyen'];
            $config = new AdyenConfig($config);
            $client = new AdyenClient($config);
			if ($this->app['config']['adyen']['liveEnvironment']) {
				$client->setEnvironment(AdyenEnvironment::LIVE);
			} else {
				$client->setEnvironment(AdyenEnvironment::TEST);
			}
            return $client;
        });
    }
	
    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}