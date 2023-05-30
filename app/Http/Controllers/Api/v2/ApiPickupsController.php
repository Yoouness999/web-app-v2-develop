<?php

namespace App\Http\Controllers\Api\v2;

use App\Pickup;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Api\v2\ApiHelper;
use App\Api\v2\ApiPickup;
use Illuminate\Http\Response;

class ApiPickupsController extends Controller
{
    /**
     * Get pickups.
     *
     * @param string $filters (optionnal) Filter the results. Model: {attribute1}:{operator1}:{value1};{attribute2}:{operator2}:{value2}...
     * @param string $order (optionnal) Sort the result. Model: {attribute}:{way}
     * @param int $page (optionnal) Current page for pagination.
     * @param int $items_by_page (optionnal) Items by page for pagination.
     * @param boolean $first (optionnal) Force the results to only one item. Not working with pagination.
     */
    public function get(Request $request)
    {
        $params = ApiHelper::getParamsFromRequest($request);
        $data = ApiPickup::get($params);

        return ApiHelper::response($data);
    }

    /**
     * Add an pickup.
     *
     * @param int $user_id (required) Customer.
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
     * @param int $assigned_delivery_arxmin_user_id (optionnal) Assigned transporter.
     * @param string $created_at (optionnal) Created date. Format: YYYY-MM-DD HH:MM:SS.
     * @param string $updated_at (optionnal) Updated date. Format: YYYY-MM-DD HH:MM:SS.
     */
    public function add(Request $request)
    {
        $item = ApiPickup::add($request->all());

        return ApiHelper::response($item->toArrayApi());
    }

    /**
     * Save an pickup.
     *
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
     * @param int $assigned_delivery_arxmin_user_id (optionnal) Assigned transporter.
     * @param string $created_at (optionnal) Created date. Format: YYYY-MM-DD HH:MM:SS.
     * @param string $updated_at (optionnal) Updated date. Format: YYYY-MM-DD HH:MM:SS.
     */
    public function save(Request $request)
    {

        $params = $request->all();
        $id = $params['id'];
        unset($params['id']);

        $params = array_merge($params, ApiHelper::uploadFiles('pickups', $id));

        $item = ApiPickup::save($id, $params);

        return ApiHelper::response($item->toArrayApi());
    }

    public function autocompleteDeliveryMan()
    {
        $deliveryMan = Pickup::join('arxmin_users', 'assigned_deliveryman_arxmin_user_id', '=', 'arxmin_users.id')
            ->groupBy('assigned_deliveryman_arxmin_user_id')
            ->select('arxmin_users.name', 'arxmin_users.id')
            ->get();

        $toReturn = [];
        $toReturn[] = ['text' => 'all', 'id' => 0];
        foreach ($deliveryMan as $item) {
            $toReturn[] = ['text' => $item['name'], 'id' => $item['id']];
        }

        return new Response([
            'data' => $toReturn,
            'status' => 200,
        ], 200);
    }

    public function autocompleteCustomer()
    {
        $deliveryMan = Pickup::join('users', 'user_id', '=', 'users.id')
            ->groupBy('user_id')
            ->select('users.first_name', 'users.last_name', 'users.id')
            ->get();

        $toReturn = [];
        $toReturn[] = ['text' => 'all', 'id' => 0];
        foreach ($deliveryMan as $item) {
            $toReturn[] = ['text' => $item['first_name'] . ' ' . $item['last_name'] , 'id' => $item['id']];
        }

        return new Response([
            'data' => $toReturn,
            'status' => 200,
        ], 200);
    }
}
