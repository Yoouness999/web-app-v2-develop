<?php namespace Modules\Datamanager\Http\Controllers;

use Arxmin\Module;
use Arxmin\ModuleController;

class BaseController extends ModuleController
{
    public function __construct(){
        parent::__construct();
        Module::setUsed('datamanager');
    }
}