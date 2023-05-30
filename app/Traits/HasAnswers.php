<?php


namespace App\Traits;

trait HasAnswers
{
    public function answers(){
        return $this->morphMany('App\Answer', 'answerable');
    }
}
