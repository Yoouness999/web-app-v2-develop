<?php namespace App\Http\Requests;

class EmailRequest extends Request
{
    public function rules()
    {
        return true;
    }


    public function validate()
    {
        return ['email' => 'required'];
    }

}
