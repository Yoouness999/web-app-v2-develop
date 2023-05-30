<?php namespace App\Http\Controllers;

use App;
use App\Api;
use App\Events\MonthlyUserInvoiceEvent;
use App\Events\PaymentAttemptEvent;
use App\Handlers\Events\MonthlyUserInvoiceHandler;
use App\Handlers\Events\PaymentAttemptHandler;
use App\OrderPlan;
use \Log;
use App\User;
use Exception;
use App\Item;

/**
 * Class CronController V1
 *
 *
 * @package App\Http\Controllers
 */
class CronController extends Controller {

    /**
     * Cron run hourly
     */
    public function anyHourly()
    {
        $users = User::query()->whereNotNull("order_plan_id")
                    ->whereNull('order_plan_region_id')
                    ->where("fixed_price", "=", 0)
                    ->get();

        foreach ($users as $user) {
            $postcode = $user->postalcode;

            if ($postcode) {
                // Get last booking
                $area = App\Area::query()->where("zip_code", $postcode)->first();

                if ($area) {
                    $orderPlanRegion = App\OrderPlanRegion::query()->where("order_plan_id", $user->order_plan_id)->where("region_id", $area->region_id)->first();

                    if ($orderPlanRegion) {
                        $user->order_plan_region_id = $orderPlanRegion->id;

                        if (!$user->order_plan_price_per_month) {
                            $user->order_plan_price_per_month = $user->price_per_month;
                        }

                        $user->save();

                        echo "User ".$user->id." postcode ".$postcode." plan id ".$user->order_plan_id.' fixed<br />'."\n";
                    } else {
                        echo "Cannot find orderPlanRegion for ".$user->id." postcode ".$postcode." plan id ".$user->order_plan_id.'<br />'."\n";
                    }
                } else {
                    echo "Cannot find area for ".$user->id." postcode ".$postcode." plan id ".$user->order_plan_id.'<br />'."\n";
                }
            } else {
                echo "Error user #".$user->id. ' have no postcode <br />'."\n";
            }
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return void
     */
    public function anyMonthly(){
	    ini_set('memory_limit', '-1');
	    set_time_limit(0);

        /**
         * @see MonthlyUserInvoiceHandler
         */
        $result = event(new MonthlyUserInvoiceEvent(request()->has('confirm'), request()->get('date', null), request()->has("testmode"), request()->has('fakePayment')));

        if(request()->has('preview')){
        	die(cp_html_table(array_pop($result)));
        }

        echo (cp_html_table(array_pop($result)));
        die('done');
    }

    /**
     * Daily task to check
     */
    public function anyDaily()
    {
        try {
            //Move users to new pricing if commitment is ended.
            $users = User::query()->where("old_pricing", "=", 1)
                    ->where("fixed_price", "=", 0)
                    ->where('end_commitment_period', "<", date("Y-m-d H:i:s"))
                    ->get();
                    
            foreach ($users as $user) {
                $volume = $user->items()
                    ->whereIn(
                    'status', [
                        Item::STATUS_STORED,
                        Item::STATUS_LOADED,
                        Item::STATUS_TO_INDEX,
                        Item::STATUS_ORDERED,
                        Item::STATUS_PICKED_UP,
                        Item::STATUS_INDEXED,
                        Item::STATUS_DROPPED
                    ])
                    ->whereNull('deleted_at')
                    ->sum('volume_m3');
                if ($volume && $volume > 0) {
                    $orderPlan = OrderPlan::where('volume_m3', '>=', $volume)
                                    ->where('price_per_month', '>', 0)
                                    ->orderBy('volume_m3', 'asc')
                                    ->first();
                    $user->recalculateOrderPlanPrice($orderPlan);
                } else {
                    $user->recalculateOrderPlanPrice($user->plan);
                }
                $user->old_pricing = 0;
                $user->save();
                echo "User #".$user->id." moved to new pricing";
            }

            App\UnavailableDate::where('date', "<", date("Y-m-d H:i:s", strtotime("-1 day")))->forceDelete();

            /**
             * @see PaymentAttemptHandler
             */
            $result = event(new PaymentAttemptEvent(null, request()->has("testmode", false), request()->has('confirm'), request()->get('date'), null, request()->has('all')));

            if (isset($result[0], $result[0]['invoices'])) {
                $data = $result[0]['invoices']->toArray();
                echo "<h1>Details :</h1>";
                echo cp_html_table($data);
                die('done');
            }

            echo "<h2>Nothing to invoice</h2>";

            die();
        } catch (Exception $e) {
            Log::error($e);
            Api::sendAdminNotification([
                'title' => "Error Cron Daily",
                'content' => $e->getMessage()
            ], 'product@boxify.be');
        }
    }
}
