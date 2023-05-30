<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\User;
use Illuminate\Http\Request;
use Modules\Datamanager\DataControllerTrait;

class MailController extends Controller {

	use DataControllerTrait;

	/**
	 * Construct
	 */
	public function __construct()
	{
		parent::__construct();

		$this->user = User::first()->toArray();
		$this->assign('user', User::first()->toArray());
	}


	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function anyIndex()
	{
		$data['content'] = "Lorem ipsum";

		return $this->viewMake('emails.layout', $data);
	}
}
