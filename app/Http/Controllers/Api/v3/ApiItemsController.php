<?php

namespace App\Http\Controllers\Api\v3;

use App\Item;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Api\v3\ApiHelper;
use App\Api\v3\ApiItem;
use Arxmin\models\Arxmin;
use App\ArxminUser;
use Session;
use Auth;
use App\Http\Controllers\Profile\ApiProfileController;
use App\OrderQuestion;

class ApiItemsController extends Controller
{
    /**
     * Add an item.
     *
     * @param string $token (required) Access token.
     * @param int $user_id (required) Customer.
     * @param int $pickup_id (optionnal) Pickup.
     * @param string $ref (optionnal) Reference.
     * @param string $type (optionnal) Type: bike, box, suitcase, fridge, other...
     * @param string $status (optionnal) Status: with_me, in_storage, in_transit.
     * @param string $status_admin (optionnal) Status used for app and admin
     * @param string $name (optionnal) Name.
     * @param string $description (optionnal) Description.
     * @param file $photo (optionnal) Photo.
     * @param string $weight (optionnal) Weight.
     * @param string $price (optionnal) Price.
     * @param string $bulk_item (optionnal) Bulk item: 1 or 0.
     * @param string $picture_option (optionnal) Picture option: 1 or 0.
     * @param string $street (optionnal) Street.
     * @param string $number (optionnal) Number.
     * @param string $box (optionnal) Box.
     * @param string $postalcode (optionnal) Postal code.
     * @param string $city (optionnal) City.
     * @param string $longitude (optionnal) Longitude.
     * @param string $latitude (optionnal) Latitude.
     * @param string $add_infos (optionnal) Infos added.
     * @param string $pickup_date (optionnal) Pickup date. Format: YYYY-MM-DD HH:MM:SS.
     * @param string $pickup_option (optionnal) Pickup option: delayed, direct...
     * @param string $storage_date (optionnal) Storage date. Format: YYYY-MM-DD HH:MM:SS.
     * @param string $ending_date (optionnal) Ending date. Format: YYYY-MM-DD HH:MM:SS.
     * @param string $billing_date (optionnal) Billing date. Format: YYYY-MM-DD HH:MM:SS.
     * @param string $billing_status (optionnal) Billing status: pending, unpaid...
     * @param string $billing_ref (optionnal) Billing_ref.
     * @param int $box_id (optionnal) Box id.
     * @param string $storage_country (optionnal) Storing country.
     * @param string $storage_warehouse (optionnal) Storing warehouse.
     * @param string $storage_floor (optionnal) Storing floor.
     * @param string $storage_row (optionnal) Storing row.
     * @param string $storage_rack (optionnal) Storing rack.
     * @param string $storage_rack_floor (optionnal) Storing rack flood.
     * @param string $storage_pallet (optionnal) Storing pallet.
     * @param string $created_at (optionnal) Created date. Format: YYYY-MM-DD HH:MM:SS.
     * @param string $updated_at (optionnal) Updated date. Format: YYYY-MM-DD HH:MM:SS.
     * @param string $intern_note (optionnal) Intern note.
     * @param double $price_estimation (optionnal) Price estimation.
     * @param string $volume_m3 (optionnal) Volume in cubic meters.
     * @param integer $order_assurance_id (optionnal) Id of the order_assurance
     * @param datetime $end_commitement_date (optionnal) Id end of the end commitement
     * @param boolean $fragile (optionnal) if item is fragile or not
     */
    public function add(Request $request)
    {
        $item = ApiItem::add($request->request->all());

        $params = ApiHelper::uploadFiles('items', $item->id);

        $item = ApiItem::save($item->id, $params);

        return ApiHelper::response($item->toArrayApi());
    }

    /**
     * Get all items : Return dépend on Access token owner. If owner is a transporter, return all items. If owner is a user, return empty array.
     *
     * @param string $token (required) Access token.
     * @param string $filters (optionnal) Filter the results. Model: {attribute1}:{operator1}:{value1};{attribute2}:{operator2}:{value2}...
     * @param string $order (optionnal) Sort the result. Model: {attribute}:{way}
     * @param int $page (optionnal) Current page for pagination.
     * @param int $items_by_page (optionnal) Items by page for pagination.
     * @param boolean $first (optionnal) Force the results to only one item. Not working with pagination.
     */
    public function all(Request $request)
    {
        $data = [];


        if (Session::get('token')->isTransporterAccess()) {
            $params = ApiHelper::getParamsFromRequest($request);
            $item = new Item();
            $data = ApiHelper::get($item, $params);
            return ApiHelper::response($data);
        }

        return $data;
    }

    /**
     * Get items : selected items depend on Access token. If access token belong of a client, return items of the client. If access Token belong of a transporter, return all items managed by transporter. (All items returns a array, get items a JSON object)
     *
     * @param string $token (required) Access token.
     * @param string $filters (optionnal) Filter the results. Model: {attribute1}:{operator1}:{value1};{attribute2}:{operator2}:{value2}...
     * @param string $order (optionnal) Sort the result. Model: {attribute}:{way}
     * @param int $page (optionnal) Current page for pagination.
     * @param int $items_by_page (optionnal) Items by page for pagination.
     * @param boolean $first (optionnal) Force the results to only one item. Not working with pagination.
     */
    public function get(Request $request)
    {
        $params = ApiHelper::getParamsFromRequest($request);

        $data = [];

        if (Session::get('token')->isClientAccess()) {
            $data = ApiItem::getClientItems(Auth::user(), $params);
        }

        if (Session::get('token')->isTransporterAccess()) {
            $auth = Arxmin::getAuth();
            $user = $auth->getUser();
            $arxminUser = ArxminUser::find($user->id);

            $data = ApiItem::getTransporterItems($arxminUser, $params);
        }

        return ApiHelper::response($data);
    }

    /**
     *
     * Allows the user to repatriate items, change of status of the item, the creation of the pickup, ... <br />Sub_error 0 : token not found. 1 : token expired. 2 : required data missing, 3 : bad formatting date, 4 : bad date
     *
     * @param string $token (required) Access token.
     * @param string $items_id (required) id of items to pickoff. Format {"0":id1,"1":id2,...}
     * @param string $pickup_date (required)  Pickoff date to. Format: YYYY-MM-DD HH:MM:SS.
     * @param string $postalcode (optionnal) Postal code (if null client ZipCode)
     * @param string $add_infos (optionnal) Infos added (if null client's add_infos)
     * @param string $city (optionnal) City (if null client's City)
     * @param string $box (optionnal) Box (if null client's Box)
     * @param string $number (optionnal) Number (if null client's Number)
     * @param string $street (optionnal) Street (if null client's Street)
     * @param string $phone (optionnal) Phone (if null client's Phone)
     * @param string $country (optionnal) Country (if null client's Country)
     * @param string $answers_services (required) Answers to Order Questions Format : {"id_question1":"answer1","id_question2":"answer2",...}
     *
     */

    public function getBack(Request $request)
    {
        $params = $request->all();
        //check if $token is empty
        if (empty($params['token'])) {
            $data = array("message" => "Token not found", "sub_error" => 0, "status" => 400);
            return ApiHelper::response($data, 400);
        }
        //check token
        if (!Session::get('token')->isValid()) {
            $data = array("message" => "Token Expired", "sub_error" => 1, "status" => 400);
            return ApiHelper::response($data, 400);
        }

        //check other required param
        if (empty($params['items_id']) || empty($params['pickup_date'])) {
            $data = array("message" => "Required data not found", "sub_error" => 2, "status" => 400);
            return ApiHelper::response($data, 400);
        }

        //need match format date (dates allant de 2018-01-01 00:00:00 à 2029-12-31 23:59:59)
        $regex_date="#^20(1[8-9]|2\d)-(0[1-9]|1[0-2])-(0[1-9]|[12]\d|3[01]) ([01]\d|2[0-3]):([0-5]\d):([0-5]\d)$#";
        if(!preg_match($regex_date,$params["pickup_date"]))
        {
            $data = array("message" => "Bad formatting date", "sub_error" => 3, "status" => 400);
            return ApiHelper::response($data, 400);
        }
        $date= strtotime($params["pickup_date"]);
        if($date===false)
        {
            $data = array("message" => "Error date (bad date)", "sub_error" => 4, "status" => 400);
            return ApiHelper::response($data, 400);
        }

        /**
         * @var User user
         */
        $user = Auth::getUser();


        /*process on JSON data*/
        $request->request->add(['itemsIds' => json_decode($params['items_id'], true)]);
        unset($params['items_id']);

        $answers = json_decode($params["answers_services"], true);
        unset($params['answers_services']);

        /*completion of array*/
        $request->request->add(['latitude' => null]);
        $request->request->add(['longitude' => null]);
        $request->request->add(['total' => 0]);
        $request->request->add(['wait_fill_boxes' => true]);

        /*if info null, info is those of user*/
        if (empty($params['postalcode'])) {
            $request->request->add(['postalcode' => $user->postalcode]);
        }
        if (empty($params['add_infos'])) {
            $request->request->add(['add_infos' => $user->add_infos]);
        }
        if (empty($params['city'])) {
            $request->request->add(['city' => $user->city]);
        }
        if (empty($params['box'])) {
            $request->request->add(['box' => $user->box]);
        }
        if (empty($params['number'])) {
            $request->request->add(['number' => $user->number]);
        }
        if (empty($params['street'])) {
            $request->request->add(['street' => $user->street]);
        }
        if (empty($params['phone'])) {
            $request->request->add(['phone' => $user->phone]);
        }
        if (empty($params['country'])) {
            $request->request->add(['country' => $user->country]);
        }

        /*formatting answers of questions*/
        $questions = OrderQuestion::where('visible', true)->orderBy('sequence')->get();
        foreach ($questions as $q) {
            $type_questions[$q->id] = $q->type;
        }
        unset ($questions, $q);

        $services = [];

        foreach ((array) $answers as $id_q => $answer) {
            $services[$type_questions[$id_q]][$id_q] = $answer;
        }
        unset($answers);

        $request->request->add(['services' => $services]);

        $APC = new ApiProfileController();

        /**
         * @var $response \Response
         */
        $response = $APC->postGetBack($request, new Item());

        return $response;

    }

    /**
     * Save an item.
     *
     * @param string $token (required) Access token.
     * @param int $id (required) Id.
     * @param int $user_id (optionnal) Customer.
     * @param int $pickup_id (optionnal) Pickup.
     * @param string $ref (optionnal) Reference.
     * @param string $type (optionnal) Type: bike, box, suitcase, fridge, other...
     * @param string $status (optionnal) Status: with_me, in_storage, in_transit.
     * @param string $status_admin (optionnal) Status used for app and admin
     * @param string $name (optionnal) Name.
     * @param string $description (optionnal) Description.
     * @param file $photo (optionnal) Photo.
     * @param string $weight (optionnal) Weight.
     * @param string $price (optionnal) Price.
     * @param string $bulk_item (optionnal) Bulk item: 1 or 0.
     * @param string $picture_option (optionnal) Picture option: 1 or 0.
     * @param string $street (optionnal) Street.
     * @param string $number (optionnal) Number.
     * @param string $box (optionnal) Box.
     * @param string $postalcode (optionnal) Postal code.
     * @param string $city (optionnal) City.
     * @param string $longitude (optionnal) Longitude.
     * @param string $latitude (optionnal) Latitude.
     * @param string $add_infos (optionnal) Infos added.
     * @param string $pickup_date (optionnal) Pickup date. Format: YYYY-MM-DD HH:MM:SS.
     * @param string $pickup_option (optionnal) Pickup option: delayed, direct...
     * @param string $storage_date (optionnal) Storage date.
     * @param string $ending_date (optionnal) Ending date. Format: YYYY-MM-DD HH:MM:SS.
     * @param string $billing_date (optionnal) Billing date.
     * @param string $billing_status (optionnal) Billing status: pending, unpaid...
     * @param string $billing_ref (optionnal) Billing_ref.
     * @param int $box_id (optionnal) Box id.
     * @param string $storage_country (optionnal) Storing country.
     * @param string $storage_warehouse (optionnal) Storing warehouse.
     * @param string $storage_floor (optionnal) Storing floor.
     * @param string $storage_row (optionnal) Storing row.
     * @param string $storage_rack (optionnal) Storing rack.
     * @param string $storage_rack_floor (optionnal) Storing rack flood.
     * @param string $storage_pallet (optionnal) Storing pallet.
     * @param string $created_at (optionnal) Created date. Format: YYYY-MM-DD HH:MM:SS.
     * @param string $updated_at (optionnal) Updated date. Format: YYYY-MM-DD HH:MM:SS.
     * @param string $intern_note (optionnal) Intern note.
     * @param double $price_estimation (optionnal) Price estimation.
     * @param string $volume_m3 (optionnal) Volume in cubic meters.
     * @param integer $order_assurance_id (optionnal) Id of the order_assurance
     * @param datetime $end_commitement_date (optionnal) Id end of the end commitement
     * @param boolean $fragile (optionnal) if item is fragile or not
    */
    public function save(Request $request)
    {
        $params = $request->request->all();
        $id = $params['id'];
        unset($params['id']);

        if (array_key_exists('photo', $params)) {
            ApiHelper::uploadBase64Files('items', $id, [$params['photo']]);
            unset($params['photo']);
        }

        $item = ApiItem::save($id, $params);

        return ApiHelper::response($item->toArrayApi());
    }

		/**
		 *
		 * Add a picture to an item.
		 *
		 * @param string $token (required) Access token.
		 * @param string $objet_id (required) Id de l'objet
		 * @param string $box_id (required) reference de l'objet
		 * @param string $image (required) Image envoyé en base64.
		 *
		*/

	public function savePicture(Request $request)
	{
		/**
		*	@var User user */
		$user = Auth::getUser();
		$params=$request->all();

		Item::addFiligrane($params['objet_id'], $params['box_id'], $params['image']);

		$data=[
			'photo' => $params['box_id'].".jpg"
		];

		$item = ApiItem::save($params['objet_id'], $data);

		return ApiHelper::response($item->toArrayApi());
	}

		/**
		 *
		 * Add many items
		 *
		 * @param string $token (required) Access token
		 * @param integer $first_ref (required) First Id of client
		 * @param integer $last_ref (required) First Id of next client
		 * @param integer $user_id (required) id of user
		 * @param integer $pickup_id (required) id of pickup
		 * @param string $storage_date (optionnal) Storage date. Format: YYYY-MM-DD HH:MM:SS.
		*/
	public function addMany(Request $request)
	{
		$params = $request->all();
		for($i=$params['first_ref'];$i<$params['last_ref'];$i++)
		{
			$data['ref']=$i;
			$data['box_id']=$i;
			$data['user_id']=$params['user_id'];
			$data['status_admin']="being_picked_up";
			$data['pickup_id']=$params['pickup_id'];
			$data['storage_date']=$params['storage_date'];


			$item = ApiItem::add($data);
		}
	}
}
