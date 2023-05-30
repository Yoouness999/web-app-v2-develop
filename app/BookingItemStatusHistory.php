<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Pickup;
use App\Item;

class BookingItemStatusHistory extends Model
{
    protected $table = "booking_item_status_history";

    protected $fillable = [
        'booking_id',
        'item_id',
        'status',
        'arxmin_user_id'
    ];

    public function pickup()
    {
        return $this->belongsTo(Pickup::class, 'booking_id');
    }

    public function item()
    {
        return $this->belongsTo(Item::class, 'item_id');
    }

    public function arxminUser()
    {
        return $this->belongsTo(ArxminUser::class, 'arxmin_user_id');
    }
}