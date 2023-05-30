<?php

namespace App\Http\Controllers\Api\v2;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Api\v2\ApiHelper;
use App\Api\v2\ApiCoupon;

class ApiCouponsController extends Controller
{
    /**
     * Get coupons.
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
        $data = ApiCoupon::get($params);

        return ApiHelper::response($data);
    }

    /**
     * Add a coupon.
     *
     * @param Request $request
     * @return array
     * @internal param string $code (optionnal) Code.
     * @internal param string $promo_applied (optionnal) Promo applied.
     * @internal param string $promo_type (optionnal) Promo type: redeem, invitation, promo... The default value is redeem.
     * @internal param string $expiry_date (optionnal) Expiry_date. Format: YYYY-MM-DD HH:MM:SS.
     * @internal param int $quantity (optionnal) Quantity. Default -1 for no limit.
     * @internal param string $created_at (optionnal) Created date. Format: YYYY-MM-DD HH:MM:SS.
     * @internal param string $updated_at (optionnal) Updated date. Format: YYYY-MM-DD HH:MM:SS.
     * @internal param array $users an array of linked users (leave empty = coupon available for all users) ex: users=[144,12,42]
     */
    public function add(Request $request)
    {
        $item = ApiCoupon::add($request->all());

        /**
         * If params users is set on creation
         */
        if ($request->has('users')) {
            $item->users()->sync($request->get('users'), ['touse' => $request->get('touse'), 'used' => 0]);
        }

        return ApiHelper::response($item);
    }

    /**
     * Save a coupon.
     *
     * @param Request $request
     * @return array
     * @internal param int $id (required) Id.
     * @internal param string $code (optionnal) Code.
     * @internal param string $promo_applied (optionnal) Promo applied.
     * @internal param string $promo_type (optionnal) Promo type: redeem, invitation, promo... The default value is redeem.
     * @internal param string $expiry_date (optionnal) Expiry_date. Format: YYYY-MM-DD HH:MM:SS.
     * @internal param int $quantity (optionnal) Quantity. Default -1 for no limit.
     * @internal param array $users an array of linked users (leave empty = coupon available for all users) ex: users=[144,12,42]
     * @internal param string $created_at (optionnal) Created date. Format: YYYY-MM-DD HH:MM:SS.
     * @internal param string $updated_at (optionnal) Updated date. Format: YYYY-MM-DD HH:MM:SS.
     */
    public function save(Request $request)
    {
        $params = $request->all();
        $id = $params['id'];
        unset($params['id']);

        $item = ApiCoupon::save($id, $params);

        if ($request->has('users')) {
            $uids = [];
            $datas = [];

            foreach ($request->get('users') as $uid => $data) {
                $uids[] = $uid;
                $datas[] = $data;
            }

            $item->users()->sync($uids, $datas);
        }

        return ApiHelper::response($item);
    }
}