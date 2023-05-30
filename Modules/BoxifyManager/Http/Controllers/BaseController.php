<?php namespace Modules\Boxifymanager\Http\Controllers;

use Arxmin\ModuleController;

class BaseController extends ModuleController
{
    public function __construct(){
        parent::__construct();
        \Module::setUsed('boxifymanager');
    }
}