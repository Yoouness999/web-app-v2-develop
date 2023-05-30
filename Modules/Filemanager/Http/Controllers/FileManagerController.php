<?php namespace Modules\Filemanager\Http\Controllers;


use Illuminate\Foundation\Application;

use Arxmin\ModuleController;

class FileManagerController extends ModuleController {

	public function __construct(Application $app){
		parent::__construct();
		$this->app = $app;
	}
	
	public function index()
	{

		/**
		 * Package defined by Elfinder
		 */

		$dir = 'packages/barryvdh/elfinder';

		$locale = $this->app->config->get('app.locale');

		if (!file_exists($this->app['path.public'] . "/$dir/js/i18n/elfinder.$locale.js")) {
			$locale = false;
		}

		$csrf = true;

		return $this->viewMake('filemanager::index', get_defined_vars());
	}


	
}