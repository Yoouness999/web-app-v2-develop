<?php
namespace App\Http\Controllers\Api\v2;

use App\Http\Middleware\Api;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Api\v2\ApiHelper;
use App\Api\v2\ApiItem;

class ApiItemsController extends Controller {
	/**
	 * Get items.
	 *
	 * @param string $filters (optionnal) Filter the results. Model: {attribute1}:{operator1}:{value1};{attribute2}:{operator2}:{value2}...
	 * @param string $order (optionnal) Sort the result. Model: {attribute}:{way}
	 * @param int $page (optionnal) Current page for pagination.
	 * @param int $items_by_page (optionnal) Items by page for pagination.
	 * @param boolean $first (optionnal) Force the results to only one item. Not working with pagination.
	 */
	public function get(Request $request) {
		$params = ApiHelper::getParamsFromRequest($request);
        $params['deep'] = 10;
		$data = ApiItem::get($params);

		return ApiHelper::response($data);
	}

	/**
	 * Add an item.
	 *
	 * @param int $user_id (optionnal) Customer.
	 * @param int $pickup_id (optionnal) Pickup.
	 * @param string $ref (optionnal) Reference.
	 * @param string $type (optionnal) Type: bike, box, suitcase, fridge, other...
	 * @param string $status (optionnal) Status: with_me, in_storage, in_transit.
	 * @param string $name (optionnal) Name.
	 * @param string $description (optionnal) Description.
	 * @param file $photo (optionnal) Photo.
	 * @param string $weight (optionnal) Weight.
	 * @param string $price (deprecated) Price.
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
	 */
	public function add(Request $request) {
		$item = ApiItem::add($request->all(), $request->file('photo'));

		$params = ApiHelper::uploadFiles('items', $item->id);
		$item = ApiItem::save($item->id, $params);

		return ApiHelper::response($item->toArrayApi());
	}

    /**
     * Delete an item (soft delete)
     *
     * @param int $id (required) Id.
     * @return array
     */
    public function delete(Request $request) {
        $item = ApiItem::delete($request->get('id'));
        return ApiHelper::response($item);
    }

	/**
	 * Add an item.
	 *
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
	public function save(Request $request) {
		$params = $request->all();
		$id = $params['id'];
		unset($params['id']);

		$params = array_merge($params, ApiHelper::uploadFiles('items', $id));

		$item = ApiItem::save($id, $params, $request->file('photo'));

		return ApiHelper::response($item->toArrayApi());
	}

    /**
     * Remove a file associated to an item
     *
     * @param int $id (required) Id of the Item
     * @param int $url (required) Url to delete
     */
    public function removeFile(Request $request){

        $this->validate($request, [
            'url' => 'required',
            'id' => 'required'
        ]);

        $url = $request->get('url');
        $id = $request->get('id');

        $result = ApiHelper::deleteFile($url, 'items', $id);

        if ($result) {
            return ApiHelper::response($result, 200);
        }

        return ApiHelper::response($result, 400);
	}

	/**
	 * Get item types.
	 *
	 * @param string $locale (optionnal) Locale: en, fr, nl. Default: en.
	 */
	public function types(Request $request) {
		$locale = null;

		if ($request->has('locale')) {
			$locale = $request->get('locale');
		}

		return ApiHelper::response(ApiItem::types($locale));
	}

	/**
	 * Get item statuses.
	 */
	public function statuses(Request $request) {
		return ApiHelper::response(ApiItem::statuses());
	}

	/**
	 * Get item pickup options.
	 */
	public function pickupOptions(Request $request) {
		return ApiHelper::response(ApiItem::pickupOptions());
	}
}
