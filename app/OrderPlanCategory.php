<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderPlanCategory extends Model {
	////////////////////
	// Relationships
	////////////////////

	public function plans() {
		return $this->hasMany(OrderPlan::class, 'order_plan_category_id');
	}
}