<?php namespace App\Http\Requests;

class DateRequest extends Request
{
    public function rules()
    {
        return ['date' => 'required'];
    }
}
