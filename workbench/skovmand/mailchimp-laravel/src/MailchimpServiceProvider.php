<?php namespace Skovmand\Mailchimp;

use Illuminate\Support\ServiceProvider;
use Mailchimp;
use Config;

class MailchimpServiceProvider extends ServiceProvider {

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
            __DIR__ . '/../config/mailchimp.php' => config_path('mailchimp.php')
        ]);
    }

    /**
     * Register the Mailchimp Instance to be set up with the API-key.
     * Then, the IoC-container can be used to get a Mailchimp instance ready for use.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('Mailchimp', function($app) {
            return new Mailchimp('5e8a985e6cf01b301fa7370af027e327-us11');
        });
    }
}