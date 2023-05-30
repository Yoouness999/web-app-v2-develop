<?php

namespace App\Http\Controllers\Api\v3;

use App\Item;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Api\v3\ApiHelper;
use App\Api\v3\ApiPickup;
use Arxmin\models\Arxmin;
use App\ArxminUser;
use App\Api\ApiToken;
use Auth;
use Session;
use Carbon\Carbon;
use App\Pickup;
use Illuminate\Support\Facades\Log;

class ApiPickupsController extends Controller
{
    /**
     * Get pickups.
     *
     * @param string $token (required) Access token.
     * @param string $filters (optionnal) Filter the results. Model: {attribute1}:{operator1}:{value1};{attribute2}:{operator2}:{value2}...
     * @param string $order (optionnal) Sort the result. Model: {attribute}:{way}
     * @param int $page (optionnal) Current page for pagination.
     * @param int $items_by_page (optionnal) Items by page for pagination.
     * @param boolean $first (optionnal) Force the results to only one item. Not working with pagination.
     */
    public function get(Request $request) {
		$auth = Arxmin::getAuth();
		$params = ApiHelper::getParamsFromRequest($request);

		if (Auth::check()) {
			$user = Auth::user();

			$params['filters'][] = [
				'attribute' => 'user_id',
				'operator' => '=',
				'value' => $user->id
			];

			$data = ApiPickup::get($params);
			return ApiHelper::response($data);
		} elseif ($user = $auth->getUser()) {
			$arxminUser = ArxminUser::find($user->id);

			$data = ApiPickup::getTransporterPickups($arxminUser, $params);
			return ApiHelper::response($data);
		}
    }

    /**
     * Save an pickup.
     *
     * @param string $token (required) Access token.
     * @param int $id (required) Id.
     * @param int $user_id (optionnal) Customer.
     * @param string $total (optionnal) Total.
     * @param string $street (optionnal) Street.
     * @param string $number (optionnal) Number.
     * @param string $box (optionnal) Box.
     * @param string $postalcode (optionnal) Postal code.
     * @param string $city (optionnal) City.
     * @param string $status (optionnal) Status: ordered, getback.
     * @param string $add_infos (optionnal) Infos added.
     * @param string $history (optionnal) History.
     * @param string $pickup_date (optionnal) Pickup date from. Format: YYYY-MM-DD HH:MM:SS.
     * @param file $sign_photo (optionnal) Sign photo.
     * @param string $intern_note (optionnal) Intern note.
     * @param string $dropoff_date_from (optionnal) Dropoff date from. Format: YYYY-MM-DD HH:MM:SS.
     * @param string $dropoff_intern_note (optionnal) Dropoff intern note.
     * @param string $dropoff_date_to (optionnal) Dropoff date to. Format: YYYY-MM-DD HH:MM:SS.
     * @param string $pickup_date_to (optionnal)  Pickup date to. Format: YYYY-MM-DD HH:MM:SS.
     * @param string $pickup_option (optionnal)  Pickup option.
     * @param string $order_booking_id (optionnal) Booking.
     * @param string $created_at (optionnal) Created date. Format: YYYY-MM-DD HH:MM:SS.
     * @param string $updated_at (optionnal) Updated date. Format: YYYY-MM-DD HH:MM:SS.
     */
    public function save(Request $request, )
    {
        $params = $request->request->all();

        $id = $params['id'];
        unset($params['id']);

        if (array_key_exists('sign_photo', $params)) {
            ApiHelper::uploadBase64Files('pickups', $id, [$params['sign_photo']]);
            unset($params['sign_photo']);
        }

        if (array_key_exists('items_on_error', $params)) {
            Log::channel('push-booking')->critical(
                sprintf('Error when creating items for booking %s', $id),
                [
                    'items' => $params['items_on_error']
                ]
            );
        }

        $item = ApiPickup::save($id, $params);

        return ApiHelper::response($item->toArrayApi());
    }

    /**
     * Add a pickup.
     *
     * @param string $token (required) Access token.
     * @param int $user_id (optionnal) Customer.
     * @param string $total (optionnal) Total.
     * @param string $street (optionnal) Street.
     * @param string $number (optionnal) Number.
     * @param string $box (optionnal) Box.
     * @param string $postalcode (optionnal) Postal code.
     * @param string $city (optionnal) City.
     * @param string $status (optionnal) Status: ordered, getback.
     * @param string $add_infos (optionnal) Infos added.
     * @param string $history (optionnal) History.
     * @param string $pickup_date (optionnal) Pickup date from. Format: YYYY-MM-DD HH:MM:SS.
     * @param string $intern_note (optionnal) Intern note.
     * @param string $dropoff_date_from (optionnal) Dropoff date from. Format: YYYY-MM-DD HH:MM:SS.
     * @param string $dropoff_intern_note (optionnal) Dropoff intern note.
     * @param string $dropoff_date_to (optionnal) Dropoff date to. Format: YYYY-MM-DD HH:MM:SS.
     * @param string $pickup_date_to (optionnal)  Pickup date to. Format: YYYY-MM-DD HH:MM:SS.
     * @param string $pickup_option (optionnal)  Pickup option.
     * @param string $order_booking_id (optionnal) Booking.
     * @param string $created_at (optionnal) Created date. Format: YYYY-MM-DD HH:MM:SS.
     * @param string $updated_at (optionnal) Updated date. Format: YYYY-MM-DD HH:MM:SS.
     */
    public function add(Request $request)
    {
        $params = $request->request->all();

        $item = ApiPickup::store($params);

        // Store Items pictures
        $item = ApiPickup::save($item->id, $params);

        return ApiHelper::response($item->toArrayApi());
    }

    /**
     * Get time slots.
     *
     * @param string $token (required) Access token.
     * @param string $from (required) From. Format: YYYY-MM-DD HH:MM:SS.
     * @param string $to (required) To. Format: YYYY-MM-DD HH:MM:SS.
     */
    public function timeSlots(Request $request)
    {
        return ApiHelper::response(ApiPickup::timeSlots($request->only('from', 'to')));
    }

    /**
     * Get all pickup information according the kind of user/n
     *
     * User : Access, when & status/n
     *
     * Transporter : Access, when & status/n
     *
     * Admin : Permet de récupérer le planning soit général (cat = all, status = all, when = all), soit les plannings plus spécifiques (par exemple le planning d'un livreur en particuler : cat=transporter, email_user) ou les pick-up n'ayant pas encore de livreurs attribués
     *
     * @param string $token (required) Access Token
     * @param string $when (optionnal) Period concerned. Value : history, future, today, all. Default value : all.
     * @param string $status (optionnal) Status of the pickup. Values : ordered, getback, all. Default value : all.
     * @param int $canceled (optionnal) including canceled pickup : 1 = true; 0 = false. Default value : 0
     * @param string $cat (optionnal) Category of pickup showed. Values : transporter, user, not-attributed, all. Default value : all. (only used by admin)
     * @param string $email_user (optionnal) user / transporter email (only used by admin with "transporter" or "user" value on $cat)
     */
    public function getList(Request $request)
    {
        $params = $request->all();
        $query=Pickup::query();

          /***********************************/
         /****gestion du type d'user*********/
        /***********************************/
            //token client

        if (Session::get('token')->isClientAccess()) {

             /**
             * @var User user
             */
            $user = Auth::getUser();

            $query=$query->user("user",$user->id);
        }
            //token transporter
        elseif (Session::get('token')->isTransporterAccess()) {

            $auth = Arxmin::getAuth();
            $user = $auth->getUser();

            $query=$query->user("deliverman",$user->id);
        }


            //TODO token "admin"
            //Permet de récupérer le planning soit général (cat = all, status = all, when = all), soit les plannings plus spécifiques (par exemple le planning d'un livreur en particuler : cat=transporter, email_user) ou les pick-up n'ayant pas encore de livreurs attribués
            //
            //si cat = "transporter"; email arxminUser => id. Where similaire à transporter
            //si cat = "not-attributed"; where transporter = NULL
            //si cat = "user"; email user => is. Where similaire à user

          /***************************/
         /****gestion du status *****/
        /***************************/
        if($params['status']=="ordered"||$params['status']=="getback")
        {
            $query=$query->status($params['status']);
        }
        elseif(!array_key_exists("canceled", $params)||$params['canceled']==0)
        {
            $query=$query->where("status","!=","canceled");
        }

          /***********************************/
         /****gestion des choix de dates*****/
        /***********************************/

        $query1=clone $query;
        $query2=clone $query;
        $query1=$query1->period($params['when'],"pickup");
        $query2=$query2->period($params['when'],"dropoff");

          /***********************************/
         /****gestion des datas de retour****/
        /***********************************/

            //token client
        if (Session::get('token')->isClientAccess()) {
            $column=["status", "id", "street", "number", "box", "postalcode", "city"];
        }
            //token transporter
        elseif (Session::get('token')->isTransporterAccess()) {
            $column=["status", "user_id","intern_note","dropoff_intern_note","latitude","longitude","fragile","floor","transporter_number","parking","volume_m3","id", "street", "number", "box", "postalcode", "city"];
        }


            //TODO token "admin"
            // tous les champs


        $rawData=$query1->get()->toArray();
        $clearData=[];
        $date=[];
        $i=0;
        foreach($rawData as $data)
        {
            //si y a un dropoff, on duplique le rendez-vous.
            if($data['dropoff_date_from']!=NULL)
            {
               $clearData[$i]=array("date"=>$data["dropoff_date_from"], "type"=>"dropoff");
                foreach($column as $c)
                {
                    $clearData[$i][$c]=$data[$c];
                }
                $date[$i]=$clearData[$i]['date'];
                $i++;
            }

            $clearData[$i]=array("date"=>$data["pickup_date"], "type"=>($data['status']=="ordered"?"pickup":"delivery"));
            foreach($column as $c)
            {
                $clearData[$i][$c]=$data[$c];
            }
            $date[$i]=$clearData[$i]['date'];
            $i++;
        }
        array_multisort($date, SORT_ASC, $clearData);
        return ApiHelper::response($clearData);
    }
}
