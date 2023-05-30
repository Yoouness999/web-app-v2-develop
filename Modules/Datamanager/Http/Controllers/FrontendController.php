<?php namespace Modules\Datamanager\Http\Controllers;

use App\Http\Controllers\Controller;
use Modules\Datamanager\DataControllerTrait;

class FrontendController extends Controller
{
    public $data = array();

    use DataControllerTrait;
}