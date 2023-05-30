<?php

/**
 * Test the whole Invoice Process
 *
 * @comment php vendor/phpunit/phpunit/phpunit tests/ApiUserTest
 */

use App\Handlers\Events\MonthlyUserInvoiceHandler;
use App\Invoice;
use App\User;

class ItemUpdatedTest extends TestCase
{
    /**
     * Test changing the volume should change the user plan
     *
     */
    public function testItemUpdated()
    {
        $user = $this->getTestUser();
        $this->resetUser($user);

        /**
         * Creating one item of 3m3 => should return plan 2
         */
        \App\Item::create([
            'user_id' => $user->id,
            'status' => \App\Item::STATUS_STORED,
            'volume_m3' => 3
        ]);

        $user = $this->getTestUser();

        $this->assertEquals(2, $user->order_plan_id);
    }

    /**
     * @param $user User
     */
    public function resetUser($user)
    {
        # Delete all items related to user
        $user->items()->forceDelete();

        # Delete all pickups related to user
        $user->pickups()->forceDelete();

        $user->order_plan_id = null;
        $user->order_plan_region_id = null;
        $user->order_plan_price_per_month = null;
        $user->save();
    }
}
