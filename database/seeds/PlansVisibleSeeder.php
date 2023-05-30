<?php

use App\OrderPlan;
use Illuminate\Database\Seeder;

class PlansVisibleSeeder extends Seeder
{
    public function run()
    {
        $plans = OrderPlan::all();

        foreach ($plans as $plan) {
            $plan->visible = true;
            $plan->save();
        }
    }
}