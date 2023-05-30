<?php
namespace App\Http\Controllers\Api\v2;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Api\v2\ApiHelper;
use App\Api\v2\ApiOrderBooking;

class ApiOrderBookingsController extends Controller {
	/**
	 * Get bookings.
	 *
	 * @param string $filters (optionnal) Filter the results. Model: {attribute1}:{operator1}:{value1};{attribute2}:{operator2}:{value2}...
	 * @param string $order (optionnal) Sort the result. Model: {attribute}:{way}
	 * @param int $page (optionnal) Current page for pagination.
	 * @param int $items_by_page (optionnal) Items by page for pagination.
	 * @param boolean $first (optionnal) Force the results to only one item. Not working with pagination.
	 */
	public function get(Request $request) {
		$params = ApiHelper::getParamsFromRequest($request);
		$data = ApiOrderBooking::get($params);
		
		return ApiHelper::response($data);
	}
	
	/**
	 * Add a booking.
	 *
	 * @param double $price_per_month (required) Price per month. Plan - commitment discount + assurance.
	 * @param double $appointment (required) Appointment. Services + delivery costs.
	 * @param string $dropoff_date (required) Dropoff date. Format: YYYY-MM-DD 00:00:00.
	 * @param string $dropoff_time (required) Dropoff time.
	 * @param string $pickup_date (required) Pickup date. Format: YYYY-MM-DD 00:00:00.
	 * @param string $pickup_time (required)  Pickup time.
	 * @param string $address_full (optionnal) Full address.
	 * @param string $address_route (required) Address route.
	 * @param string $address_street_number (required) Address street number.
	 * @param string $address_city (required) Address city.
	 * @param string $address_postal_code (required) Address postal code.
	 * @param string $address_country (required) Address country.
	 * @param string $address_box (required) Address box.
	 * @param boolean $wait_fill_boxes (required) Wait fill boxed: 1 or 0.
	 * @param string $company_address_name (optionnal) Company name.
	 * @param string $company_address_vat_number (optionnal) Company vat number.
	 * @param string $company_address_full (optionnal) Company full address.
	 * @param string $company_address_route (optionnal) Company address route.
	 * @param string $company_address_street_number (optionnal) Company address street number.
	 * @param string $company_address_locality (optionnal) Company address city.
	 * @param string $company_address_postal_code (optionnal) Company address postal code.
	 * @param string $company_address_country (optionnal) Company address country.
	 * @param string $company_address_box (optionnal) Company address box.
	 * @param string $how_did_you_know_about_us (optionnal) How did you know about us.
	 * @param string $comments (optionnal) Comments.
	 * @param int $user_id (required) User, customer.
	 * @param int $order_plan_id (required) Plan.
	 * @param int $order_storing_duration_id (optionnal) Storing duration.
	 * @param int $order_assurance_id (optionnal) Assurance.
	 * @param int $order_booking_status_id (required) Status.
	 * @param string $created_at (optionnal) Created date. Format: YYYY-MM-DD HH:MM:SS.
	 * @param string $updated_at (optionnal) Updated date. Format: YYYY-MM-DD HH:MM:SS.
	 */
	public function add(Request $request) {
		$item = ApiOrderBooking::add($request->all());
		
		return ApiHelper::response($item);
	}

    /**
     * Delete an order booking
     *
     * @param int $id (required) Id.
     * @return array
     */
    public function delete(Request $request) {
        $item = ApiOrderBooking::delete($request->get('id'));

        return ApiHelper::response($item);
    }
	
	/**
	 * Save a booking.
	 *
	 * @param int $id (optionnal) Id.
	 * @param double $price_per_month (optionnal) Price per month. Plan - commitment discount + assurance.
	 * @param double $appointment (optionnal) Appointment. Services + delivery costs.
	 * @param string $dropoff_date (optionnal) Dropoff date. Format: YYYY-MM-DD 00:00:00.
	 * @param string $dropoff_time (optionnal) Dropoff time.
	 * @param string $pickup_date (optionnal) Pickup date. Format: YYYY-MM-DD 00:00:00.
	 * @param string $pickup_time (optionnal)  Pickup time.
	 * @param string $address_full (optionnal) Full address.
	 * @param string $address_route (optionnal) Address route.
	 * @param string $address_street_number (optionnal) Address street number.
	 * @param string $address_locality (optionnal) Address city.
	 * @param string $address_postal_code (optionnal) Address postal code.
	 * @param string $address_country (optionnal) Address country.
	 * @param string $address_box (optionnal) Address box.
	 * @param boolean $wait_fill_boxes (optionnal) Wait fill boxed: 1 or 0.
	 * @param string $company_address_name (optionnal) Company name.
	 * @param string $company_address_vat_number (optionnal) Company vat number.
	 * @param string $company_address_full (optionnal) Company full address.
	 * @param string $company_address_route (optionnal) Company address route.
	 * @param string $company_address_street_number (optionnal) Company address street number.
	 * @param string $company_address_locality (optionnal) Company address city.
	 * @param string $company_address_postal_code (optionnal) Company address postal code.
	 * @param string $company_address_country (optionnal) Company address country.
	 * @param string $company_address_box (optionnal) Company address box.
	 * @param string $how_did_you_know_about_us (optionnal) How did you know about us.
	 * @param string $comments (optionnal) Comments.
	 * @param int $user_id (optionnal) User, customer.
	 * @param int $order_plan_id (optionnal) Plan.
	 * @param int $order_storing_duration_id (optionnal) Storing duration.
	 * @param int $order_assurance_id (optionnal) Assurance.
	 * @param int $order_booking_status_id (optionnal) Status.
	 * @param string $created_at (optionnal) Created date. Format: YYYY-MM-DD HH:MM:SS.
	 * @param string $updated_at (optionnal) Updated date. Format: YYYY-MM-DD HH:MM:SS.
	 */
	public function save(Request $request) {
		$params = $request->all();
		$id = $params['id'];
		unset($params['id']);
		
		$item = ApiOrderBooking::save($id, $params);
		
		return ApiHelper::response($item);
	}
}