<?php namespace Modules\Datamanager\Http\Controllers;

use Blok\Utils\Arr;
use Arxmin\Api;
use Arxmin\ModuleController;
use Modules\Datamanager\Entities\Form;
use Modules\Datamanager\Entities\Post;
use Input;
use Request;
use Response;

class ApiController extends BaseController {

    /**
     * Constructor method
     */
    public function __construct()
    {
        parent::__construct();

        $this->post = new Post();
        $this->form = new Form();
    }

    /**
     * Return all available labels
     */
    public function getForms()
    {

        $param = Input::all();

        $data = Form::all()->toArray();

        if ($param['format'] = 'datatable') {

            $i = 0;

            $data = array_map(function($item) use(&$i) {
                $i++;
                $item['DT_RowId'] = $item['id'];

                return $item;

            }, $data);
        }

        return Api::responseJson($data, 200);
    }

    /**
     * Label
     *
     * @param null $id
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws Exception
     */
    public function anyForm($id = null){

        $action = request()->get('action');

        if (!$action) {
            switch (\Request::method()) {
                case 'POST':
                    $action = 'create';
                    break;
                case 'PUT':
                    $action = 'edit';
                    break;
                case 'DELETE':
                    $action = 'remove';
                    break;
            }
        }

        if ($action == 'create') {

            $label = new Form();

            $data = request()->get('data');

            $label->save();

            return Response::json([
                'row' => $label->toArray()
            ], 200);
        } else {

            $label = Form::findOrFail($id);

            if ($action == 'edit') {

                $data = request()->get('data');

                if(isset($data['meta'])){
                    $label->meta = json_encode($data['meta']);
                }

                $label->save();
            } elseif ($action == 'remove') {
                Response::json(['delete' => $label->delete(), Input::all()], 200);
            }

            return Response::json([
                'row' => $label->toArray()
            ], 200);

        }

    }


    /**
     * Handle model
     *
     * @param $class
     * @param null $id
     * @param null $method
     * @return \Illuminate\Http\JsonResponse
     */
    public function handleModel($class, $id = null, $method = null){

        if (!$method) {
            $method = strtolower(Request::method());
        }

        if (!is_integer($id) && !$method) {
            $oClass = new $class();
            $method = $id;
        } elseif (is_integer($id)) {
            $oClass = $class::findOrFail($id);
        } elseif(isset($this->{$class})){
            $oClass = $this->{$class};
        }   else {
            $oClass = new Post();
        }

        $method = studly_case($method);

        $param = Request::segments();

        unset($param[0],$param[1],$param[2],$param[3], $param[4], $param[5], $param[6]);

        if (Input::all()) {
            $param[] = Input::all();
        }

        if (method_exists($oClass, $method)) {
            $response = call_user_func_array([$oClass, $method], $param);
        } else {
            $response = $oClass->toArray();
        }

        return Api::responseJson($response);
    }

    /**
     * Data Injection Api
     */
    public function anyData($id = null, $method = null)
    {

        $action = request()->get('action');

        if ($action == 'create') {
            $post = Post::create(request()->get('data'));
        } elseif ($action == 'remove') {
            Post::find($id)->delete();
        }

        if (!$id && !$method) {

            $data = $this->post->search(Input::all())->toArray();

            if ($param['format'] = 'datatable') {

                $i = 0;

                $data = array_map(function($item) use(&$i) {
                    $i++;
                    $item['DT_RowId'] = $item['id'];

                    return $item;

                }, $data);
            }

            return Api::responseJson($data, 200);

        } else {
            $this->post = $this->post->find($id);
        }

        if ($method == 'update') {

            $data = Arr::dot_array(Input::all());

            $this->post->update($data);

            return $this->post->toArray();
        }

        return $this->handleModel('Post', $id, $method);
    }

}
