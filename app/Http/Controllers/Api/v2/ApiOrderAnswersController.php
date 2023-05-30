<?php
namespace App\Http\Controllers\Api\v2;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Api\v2\ApiHelper;
use App\Api\v2\ApiOrderAnswer;

class ApiOrderAnswersController extends Controller {
	/**
	 * Get anwsers.
	 *
	 * @param string $filters (optionnal) Filter the results. Model: {attribute1}:{operator1}:{value1};{attribute2}:{operator2}:{value2}...
	 * @param string $order (optionnal) Sort the result. Model: {attribute}:{way}
	 * @param int $page (optionnal) Current page for pagination.
	 * @param int $items_by_page (optionnal) Items by page for pagination.
	 * @param boolean $first (optionnal) Force the results to only one item. Not working with pagination.
	 */
	public function get(Request $request) {
		$params = ApiHelper::getParamsFromRequest($request);
		$data = ApiOrderAnswer::get($params);
		
		return ApiHelper::response($data);
	}
	
	/**
	 * Add a anwser.
	 *
	 * @param int $order_question_parent_id (required) Question parent.
	 * @param int $order_question_target_id (optionnal) Question target.
	 * @param string $slug (required) Slug, unique.
	 * @param boolean $value_boolean (required) Yes or no for boolean question.
	 * @param int $value_number_from (required) Range for number question.
	 * @param int $value_number_to (required) Range for number question.
	 * @param double $appointment (required) Appointment.
	 * @param double $appointment_alt (required) Appointment depending of the anwser for number question.
	 * @param string $created_at (optionnal) Created date. Format: YYYY-MM-DD HH:MM:SS.
	 * @param string $updated_at (optionnal) Updated date. Format: YYYY-MM-DD HH:MM:SS.
	 */
	public function add(Request $request) {
		$item = ApiOrderAnswer::add($request->all());
		
		return ApiHelper::response($item);
	}
	
	/**
	 * Save a anwser.
	 *
	 * @param int $id (required) Id.
	 * @param int $order_question_parent_id (optionnal) Question parent.
	 * @param int $order_question_target_id (optionnal) Question target.
	 * @param string $slug (optionnal) Slug, unique.
	 * @param boolean $value_boolean (optionnal) Yes or no for boolean question.
	 * @param int $value_number_from (optionnal) Range for number question.
	 * @param int $value_number_to (optionnal) Range for number question.
	 * @param double $appointment (optionnal) Appointment.
	 * @param double $appointment_alt (optionnal) Appointment depending of the anwser for number question.
	 * @param string $created_at (optionnal) Created date. Format: YYYY-MM-DD HH:MM:SS.
	 * @param string $updated_at (optionnal) Updated date. Format: YYYY-MM-DD HH:MM:SS.
	 */
	public function save(Request $request) {
		$params = $request->all();
		$id = $params['id'];
		unset($params['id']);
		
		$item = ApiOrderAnswer::save($id, $params);
		
		return ApiHelper::response($item);
	}
}