<?php namespace Modules\Labelmanager\Providers;

use Blok\Utils\Traits\ServiceProviderTrait;
use Illuminate\Support\ServiceProvider;
use Modules\Labelmanager\Console\SyncFromResourcesLangFolder;
use Modules\Labelmanager\Entities\Label;

class LabelmanagerServiceProvider extends ServiceProvider {

	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = false;

	protected $facades = [
		'Label' => 'Modules\Labelmanager\Facades\Label'
	];

    protected $commands = [
        'labelmanager:sync' => SyncFromResourcesLangFolder::class
    ];

	use ServiceProviderTrait;

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
		$this->registerCommands();
	}

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		/**
		 * Register Arxmin
		 */
		$this->app->bind('label', function ($app) {
			$label = new Label();
			$label->getAll();
			return $label;
		});

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
		    __DIR__.'/../Config/config.php' => config_path('labelmanager.php'),
		]);
		$this->mergeConfigFrom(
		    __DIR__.'/../Config/config.php', 'labelmanager'
		);
	}

	/**
	 * Register views.
	 *
	 * @return void
	 */
	public function registerViews()
	{
		$viewPath = base_path('views/modules/labelmanager');

		$sourcePath = __DIR__.'/../Resources/views';

		$this->publishes([
			$sourcePath => $viewPath
		]);

		$this->loadViewsFrom([$viewPath, $sourcePath], 'labelmanager');
	}

	/**
	 * Register translations.
	 *
	 * @return void
	 */
	public function registerTranslations()
	{
		$langPath = base_path('resources/lang/modules/labelmanager');

		if (is_dir($langPath)) {
			$this->loadTranslationsFrom($langPath, 'labelmanager');
		} else {
			$this->loadTranslationsFrom(__DIR__ .'/../Resources/lang', 'labelmanager');
		}
	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return array('label');
	}

}
