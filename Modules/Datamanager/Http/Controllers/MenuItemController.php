<?php namespace Modules\Datamanager\Http\Controllers;

use Pingpong\Modules\Routing\Controller;

class MenuItemController extends Controller {
	
	public function index()
	{
		return view('datamanager::index');
	}
	
}