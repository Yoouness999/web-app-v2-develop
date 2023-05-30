<?php
namespace App\Http\Controllers\Api\v3;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Api\v3\ApiHelper;
use App\Api\v3\ApiOrderAnswer;
use App\Api\v3\ApiOrderQuestion;

class ApiOrderAnswersQuestionsController extends Controller {
	/**
	 * Get all anwsers.
	 *
	 * @param string $token (required) Access token.
	 * @param string $filters (optionnal) Filter the results. Model: {attribute1}:{operator1}:{value1};{attribute2}:{operator2}:{value2}...
	 * @param string $order (optionnal) Sort the result. Model: {attribute}:{way}
	 * @param int $page (optionnal) Current page for pagination.
	 * @param int $items_by_page (optionnal) Items by page for pagination.
	 * @param boolean $first (optionnal) Force the results to only one item. Not working with pagination.
	 */
	public function answers(Request $request) {
		$params = ApiHelper::getParamsFromRequest($request);
		$data = ApiOrderAnswer::get($params);
		
		return ApiHelper::response($data);
	}

	/**
	 * Get all questions.
	 *
	 * @param string $token (required) Access token.
	 * @param string $filters (optionnal) Filter the results. Model: {attribute1}:{operator1}:{value1};{attribute2}:{operator2}:{value2}...
	 * @param string $order (optionnal) Sort the result. Model: {attribute}:{way}
	 * @param int $page (optionnal) Current page for pagination.
	 * @param int $items_by_page (optionnal) Items by page for pagination.
	 * @param boolean $first (optionnal) Force the results to only one item. Not working with pagination.
	 * @param string $locale (required) Lang : fr, en, nl
	 */
	public function questions(Request $request) {
		$params = ApiHelper::getParamsFromRequest($request);
		$data = ApiOrderQuestion::get($params);

		return ApiHelper::response($data);
	}

	/**
	* Get next questions (under construction). return array ("text_answer"=>(string), "fees"=>(int), "answer_id"=>(int), "text_question"=>(string), "type_question"=>({boolean|number}), "question_id"=>(int), "img_question"=>(string)) OR status 400.
	*
	* @param string $token (required) Access token.
	* @param int $question_id (optionnal) id previous question. NULL for first.
	* @param int $answer (optionnal) 0 OR 1 for boolean answer, int for number, NULL for first.
	* @param int $volume (required) volume of the pick-up
	* TODO-HM: Is is in use?
	*/
	public function nextQuestion(Request $request){

		$data=array("text_answer"=>" ", "fees"=>0, "answer_id"=>0, "text_question"=>" ", "type_question"=>0, "question_id"=>0, "img_question"=>"");
		$params = $request->all();
		
		//first question
		if(empty($params["answer"])&&empty($params["question_id"]))
		{
			$data["question_id"]=1;
		}

		//other
		else
		{
			//previous question (get type of question)
			$params_prev_question=array(
				"token"=>$params['token'],
				"first"=>true,
				'filters'=>array( 
					array(
						'attribute' => 'id',
						'operator' => '=',
						'value' => $params["question_id"]
					)
				)
			);
			$prev_question= ApiOrderQuestion::get($params_prev_question);
			unset($params_prev_question);

			//answers (get text, id and appointments)
			$param_answer=array(
				"token"=>$params['token'],
				"first"=>true,
				'filters'=>array( 
					array(
						'attribute' => 'order_question_parent_id',
						'operator' => '=',
						'value' => $prev_question->id
					)
				)
			);

			switch($prev_question->type){
				case "boolean":
					$param_answer['filters'][]=array(
						'attribute' => 'value_boolean',
						'operator' => '=',
						'value' => $params["answer"]
					);
				break;
				case "number":
					$param_answer['filters'][]=array(
						'attribute' => 'value_number_from',
						'operator' => '<=',
						'value' => $params["answer"]
					);
					$param_answer["order"]=array(
						"attribute" => "value_number_from",
						"way"=> "desc"
					);
				break;
			};
			$answer = ApiOrderAnswer::get($param_answer);
			unset($param_answer);

			//calculation of fees linked to answer
			$fees=$answer->appointment;
			$data=array(
				"text_answer"=>$answer->slug, 
				"fees"=>$fees,
				"answer_id"=>$answer->id);

			//id of next question.
			switch($answer->order_question_target_id)
			{
				case NULL:
					$data["text_question"]=" "; 
					$data["type_question"]=NULL; 
					$data["question_id"]=NULL;
					return ApiHelper::response($data);
				case 2:
					if($params['volume']>6){
						$data['question_id']=3;
					}
					else
					{
						$data['question_id']=2;
					}
					break;
				default:
					$data['question_id']=$answer->order_question_target_id;
					break;
			};

		}

		//next question
		$param_next_question=array(
			"token"=>$params['token'],
			"first"=>true,
			'filters'=>array( 
				array(
					'attribute' => 'id',
					'operator' => '=',
					'value' => $data['question_id']
				)
			)
		);
		$next_question = ApiOrderQuestion::get($param_next_question);
		unset($param_next_question);
		$data["text_question"]=$next_question->slug;
		$data["type_question"]=$next_question->type;
		$data["img_question"]='https://www.boxify.be/assets/img/order/services/questions/'.$next_question->slug.".svg";

		return ApiHelper::response($data);
	}
}