<?php
namespace App\Http\Controllers\Api\v2;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Api\v2\ApiHelper;
use App\Api\v2\ApiTodo;

class ApiTodosController extends Controller {
	/**
	 * Get todos.
	 *
	 * @param string $filters (optionnal) Filter the results. Model: {attribute1}:{operator1}:{value1};{attribute2}:{operator2}:{value2}...
	 * @param string $order (optionnal) Sort the result. Model: {attribute}:{way}
	 * @param int $page (optionnal) Current page for pagination.
	 * @param int $items_by_page (optionnal) Items by page for pagination.
	 * @param boolean $first (optionnal) Force the results to only one item. Not working with pagination.
	 */
	public function get(Request $request) {
		$params = ApiHelper::getParamsFromRequest($request);
		$data = ApiTodo::get($params);
		
		return ApiHelper::response($data);
	}
	
	/**
	 * Add a todo.
	 *
	 * @param string $title (optionnal) Title.
	 * @param int $assigned_id (required) Assigned.
	 * @param string $type (optionnal) Type.
	 * @param boolean $completed (optionnal) Completed:  1 or 0. Default : 0.
	 * @param string $created_at (optionnal) Created date. Format: YYYY-MM-DD HH:MM:SS.
	 * @param string $updated_at (optionnal) Updated date. Format: YYYY-MM-DD HH:MM:SS.
	 */
	public function add(Request $request) {
		$item = ApiTodo::add($request->all());
		
		return ApiHelper::response($item);
	}
	
	/**
	 * Save a todo.
	 *
	 * @param int $id (required) Id.
	 * @param string $title (optionnal) Title.
	 * @param int $assigned_id (optionnal) Assigned.
	 * @param string $type (optionnal) Type.
	 * @param boolean $completed (optionnal) Completed:  1 or 0. Default : 0.
	 * @param string $created_at (optionnal) Created date. Format: YYYY-MM-DD HH:MM:SS.
	 * @param string $updated_at (optionnal) Updated date. Format: YYYY-MM-DD HH:MM:SS.
	 */
	public function save(Request $request) {
		$params = $request->all();
		$id = $params['id'];
		unset($params['id']);
		
		$item = ApiTodo::save($id, $params);
		
		return ApiHelper::response($item);
	}
}