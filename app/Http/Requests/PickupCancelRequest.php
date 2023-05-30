<?php namespace App\Http\Requests;

class PickupCancelRequest extends Request {

    public function rules()
    {

    }


    public function validate(){
        return [
            'ids' => 'array'
        ];
    }

}
