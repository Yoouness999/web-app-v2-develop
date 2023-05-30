<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class PickupAnswer extends Model {
	protected $fillable = [
		"pickup_id",
		"order_answer_id",
        "value",
        "price"
    ];

	public function pickup() {
		return $this->belongsTo(Pickup::class, 'pickup_id');
	}

	public function answer() {
		return $this->belongsTo(OrderAnswer::class, 'order_answer_id');
	}

	/**
     * Return the titile of the answer
     */
    public function getName($lang = null) {
        return shortcode(lg('order.resume.services.' . $this->answer->slug, null, [], $lang), [
			'floor' => $this->value
		]);
    }

	public function getPrice($formated = false) {
        $price = $this->price;

		if ($formated) {
			if ($price > 0) {
				$price = number_format($price, 2, ',', '.') . ' €';
			} else {
				$price = ucfirst(lg('common.free'));
			}
		}

		return $price;
    }

	public function toArray()
    {
        $data = parent::toArray();
		$data['answer'] = $this->answer;
		return $data;
	}
}