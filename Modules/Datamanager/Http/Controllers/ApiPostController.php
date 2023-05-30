<?php namespace Modules\Datamanager\Http\Controllers;

use Arxmin\ApiController as ParentClass;
use Modules\Datamanager\Entities\Post;
use Request;

class ApiPostController extends ParentClass {

	public function __construct(Post $post){
		parent::__construct();
		$this->post = $post;
	}

	public function index()
	{
		return view('datamanager::index');
	}

	public function show($id){

		$this->post = $this->post->find($id);

		return $this->post->toArray();

	}

	public function update($id, Request $request){
		$this->post = $this->post->find($id);

		return $this->post->update($request->only($this->post->getFillable()))->toArray();
	}

	public function destroy($id){
		$this->post = $this->post->find($id);
	}
	
}