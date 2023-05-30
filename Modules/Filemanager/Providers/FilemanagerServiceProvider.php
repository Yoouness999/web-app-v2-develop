<?php namespace Modules\Filemanager\Providers;

use Arx\ServiceProviderTrait;
use Illuminate\Support\ServiceProvider;

class FilemanagerServiceProvider extends ServiceProvider {

	use ServiceProviderTrait;

	/**
	 * The providers autoloaded by this module
	 *
	 * @var array
	 */
	protected $providers = [
		'Barryvdh\Elfinder\ElfinderServiceProvider'
	];

	/**
	 * The facades that will be autoloaded
	 *
	 * @var array
	 */
	protected $facades = [

	];

	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = false;

	/**
	 * Boot the application events.
	 * 
	 * @return void
	 */
	public function boot()
	{
		$this->registerConfig();
		$this->registerTranslations();
		$this->registerViews();
	}

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->registerProviders();
		$this->registerFacades();
	}

	/**
	 * Register config.
	 * 
	 * @return void
	 */
	protected function registerConfig()
	{
		$this->publishes([
		    __DIR__.'/../Config/config.php' => config_path('filemanager.php'),
		]);
		$this->mergeConfigFrom(
		    __DIR__.'/../Config/config.php', 'filemanager'
		);
	}

	/**
	 * Register views.
	 * 
	 * @return void
	 */
	public function registerViews()
	{
		$viewPath = base_path('views/modules/filemanager');

		$sourcePath = __DIR__.'/../Resources/views';

		$this->publishes([
			$sourcePath => $viewPath
		]);

		$this->loadViewsFrom([$viewPath, $sourcePath], 'filemanager');
	}

	/**
	 * Register translations.
	 * 
	 * @return void
	 */
	public function registerTranslations()
	{
		$langPath = base_path('resources/lang/modules/filemanager');

		if (is_dir($langPath)) {
			$this->loadTranslationsFrom($langPath, 'filemanager');
		} else {
			$this->loadTranslationsFrom(__DIR__ .'/../Resources/lang', 'filemanager');
		}
	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return array();
	}

}
