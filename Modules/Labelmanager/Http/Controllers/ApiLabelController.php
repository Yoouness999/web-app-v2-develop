<?php namespace Modules\Labelmanager\Http\Controllers;

use Arxmin;
use Arxmin\Api;
use Illuminate\Http\Request;
use Input;
use Modules\Labelmanager\Entities\Label;
use Response;

class ApiLabelController extends BaseController {

	/**
	 * Inject repository
	 */
	public function __construct()
	{

		parent::__construct();

		$repository = config('labelmanager.model');
		$this->repository = new $repository;
	}

	/**
	 * Return all available labels
	 */
	public function index()
	{
		$data = $this->repository->all()->toArray();

		return Api::responseJson($data, 200);
	}

	/**
	 * Destroy label
	 *
	 * @param $id
	 * @return \Symfony\Component\HttpFoundation\Response
	 */
	public function destroy($id)
	{
		$label = $this->repository->findOrFail($id);

		return Response::json(['delete' => $label->delete(), Input::all()], 200);
	}

	/**
	 * Store a new label
	 */
	public function store(Request $request, Label $label)
	{
		$data = $request->all();

		foreach ($data as $key => $value) {
			$label->{$key} = $value;
		}

		$label->meta = json_encode(['translated' => true]);

		$label->save();

		return Response::json([$label->toArray()], 200);
	}

	public function update(Label $label, Request $request){

		$label = $label->find($request->get('id'));

		$data = $request->all();

		unset($data['id']);

		foreach ($data as $key => $value) {
			$label->{$key} = $value;
		}

        $label->meta = json_encode(['translated' => true]);

		$label->save();

		return Response::json([$label->toArray()], 200);
	}

}
