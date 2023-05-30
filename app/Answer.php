<?php namespace App;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'answerable_id',
        'answerable_type',
        'order_answer_id',
        'value'
    ];

    public function answerable()
    {
        return $this->morphTo();
    }

    public function answer(){
        return $this->belongsTo(OrderAnswer::class, 'order_answer_id');
    }

    /**
     * Return the price linked to the answer
     *
     * @return mixed
     */
    public function getPrice($formated = false){
        $price = $this->answer->getAppointment($this->value);

		if ($formated) {
			if ($price > 0) {
				$price = number_format($price, 2, ',', '.') . ' €';
			} else {
				$price = ucfirst(lg('common.free'));
			}
		}

		return $price;
    }

    /**
     * Return the name of the answer
     */
    public function getName(){
        return shortcode(lg('order.resume.services.' . $this->answer->slug), [
			'floor' => $this->value
		]);
    }
}
