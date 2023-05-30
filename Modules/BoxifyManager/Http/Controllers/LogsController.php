<?php namespace Modules\Boxifymanager\Http\Controllers;

use App\Log;
use Input;
use Request;
use Pingpong\Modules\Routing\Controller;

class LogsController extends Controller {
	
	public function index()
	{
		return view('boxifymanager::index');
	}

	/**
	 * Create a new Log
	 */
	public function anyCreate()
	{
		\Eloquent::unguard();
		$data = Input::all();
		$log = Log::create($data);

		if (Request::isJson()) {
			return $log->toArray();
		}

		return redirect()->back()->with('notify', 'Log added');
	}
	
}