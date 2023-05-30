<?php namespace Modules\Datamanager\Providers;

use Blok\Utils\Traits\ServiceProviderTrait;
use Illuminate\Support\ServiceProvider;
use Modules\Datamanager\Datamanager;

class DatamanagerServiceProvider extends ServiceProvider {

	protected $providers = [
		'Baum\Providers\BaumServiceProvider',
	];

	/**
	 * Registered facades can be overrided in your app config
	 *
	 * @var array
	 */
	protected $facades = [
		'DM' => 'Modules\Datamanager\Facades\DM'
	];

	use ServiceProviderTrait;

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
		$this->registerFacades();

		/**
		 * Register Arxmin with current app setting
		 *
		 */
		$this->app->bind('DM', function ($app) {
			return new Datamanager($app);
		});

		include_once __DIR__ . '/../helpers.php';
	}

	/**
	 * Register config.
	 *
	 * @return void
	 */
	protected function registerConfig()
	{
		$this->publishes([
		    __DIR__.'/../Config/config.php' => config_path('datamanager.php'),
		]);
		$this->mergeConfigFrom(
		    __DIR__.'/../Config/config.php', 'datamanager'
		);
	}

	/**
	 * Register views.
	 *
	 * @return void
	 */
	public function registerViews()
	{
		$viewPath = base_path('views/modules/datamanager');

		$sourcePath = __DIR__.'/../Resources/views';

		$this->publishes([
			$sourcePath => $viewPath
		]);

		$this->loadViewsFrom([$viewPath, $sourcePath], 'datamanager');
	}

	/**
	 * Register translations.
	 *
	 * @return void
	 */
	public function registerTranslations()
	{
		$langPath = base_path('resources/lang/modules/datamanager');

		if (is_dir($langPath)) {
			$this->loadTranslationsFrom($langPath, 'datamanager');
		} else {
			$this->loadTranslationsFrom(__DIR__ .'/../Resources/lang', 'datamanager');
		}
	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return array(
			'DM'
		);
	}

}
