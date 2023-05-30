<?php namespace Modules\Datamanager\Http\Requests;

class PostRequest extends \App\Http\Requests\Request
{
    public function authorize(){
        global $arxminAuth;
        return $arxminAuth;
    }

    public function rules(){
        return [
          'title' => 'required',
          'body' => 'required',
        ];
    }
}