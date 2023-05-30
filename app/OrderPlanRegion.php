<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Translatable;

class OrderPlanRegion extends Model
{
    public function region(){
        return $this->belongsTo(Region::class, 'region_id');
    }

    public function plan(){
        return $this->belongsTo(OrderPlan::class, 'order_plan_id');
    }

    public function toArray(){
        $data = parent::toArray();
        $data['region'] = $this->region;
        $data['plan'] = $this->plan;
        return $data;
    }
}
