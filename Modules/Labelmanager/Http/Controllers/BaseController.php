<?php namespace Modules\Labelmanager\Http\Controllers;

use Arxmin\Module;
use Arxmin\ModuleController;

class BaseController extends ModuleController
{
    public function __construct(){
        parent::__construct();
        Module::setCurrent('labelmanager');
    }
}