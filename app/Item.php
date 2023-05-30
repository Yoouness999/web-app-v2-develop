<?php namespace App;

use App\Traits\ModelFilesHandlingTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Lang;
use Config;
use DateTime;

class Item extends Model
{
    use SoftDeletes;
    use modelFilesHandlingTrait;

    const BILLING_STATUS_PAID = 'paid';
    const BILLING_STATUS_UNPAID = 'unpaid';
    const BILLING_STATUS_PENDING = 'pending';

    static $currentPath = 'files';

    const STATUS_IN_TRANSIT = 'in_transit'; //old
    const STATUS_WITH_ME = 'with_me'; //old
    const STATUS_IN_STORAGE = 'in_storage'; //old
    const STATUS_OUTDATED = 'outdated'; //old

    const STATUS_CREATE = "CREATE"; //new
    const STATUS_PICKED_UP = "PICKED-UP"; //new
    const STATUS_STORED = "STORED"; //new
    const STATUS_LOADED = 'LOADED'; //new
    const STATUS_TO_INDEX = "TO INDEX"; //new
    const STATUS_INDEXED = "INDEXED"; //new
    const STATUS_TRANSIT = "TRANSIT"; //new
    const STATUS_DELIVERED = "DELIVERED"; //new
    const STATUS_IN_ERROR = "IN_ERROR"; //new
    const STATUS_ORDERED = "ORDERED"; //new
    const STATUS_DROPPED = "DROPPED";
    const STATUS_READY_TO_DESTROY = "READY-TO-DESTROY";

    const PICKUP_OPTION_DELAYED = 'delayed';
    const PICKUP_OPTION_DIRECT = 'direct';

    public $photos = null;
    public static $filepath = null;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'items';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'ref',
        'type',
        'status',
        'status_admin',
        'name',
        'description',
        'photo',
        'weight',
        'price',
        'bulk_item',
        'picture_option',
        'street',
        'number',
        'box',
        'postalcode',
        'city',
        'longitude',
        'latitude',
        'add_infos',
        'pickup_date',
        'pickup_option',
        'storage_date',
        'ending_date',
        'billing_date',
        'billing_status',
        'billing_ref',
        'box_id',
        'storage_country',
        'storage_warehouse',
        'storage_floor',
        'storage_row',
        'storage_rack',
        'storage_rack_floor',
        'storage_pallet',
        'intern_note',
        'price_estimation',
        'volume_m3',
        'order_assurance_id',
        'fragile',
        'pallet_id',
        'warehouse_id',
        'zone_id',
        'transporter_number'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['billing_ref'];


    /**
     * Return fees as a list
     */
    public static function feesList()
    {
        $list = Lang::get('fees');

        $list = array_map(function ($item) {
            return @$item['name'] . '' . @$item['description'];
        }, $list);

        return $list;
    }

    /**
     * Get the localisation
     *
     * @see https://docs.google.com/spreadsheets/d/1_NwPeAh8PTr9aYMgb40qEU9wgRMU4Hc7fZmyF6gya28/edit#gid=742417254&range=E57
     */
    public function getLocalisationAttribute()
    {
        if ($this->storage) {
            return $this->storage->qrcode;
        } elseif ($this->pallet && $this->pallet->zone) {
            $zone = $this->pallet->zone;
            if($zone->warehouse) {
                return $zone->warehouse->ref.'_'.$zone->line.'.'.$zone->rack.'.'.$zone->space.'.'.$zone->level;
            }
            return $zone->line.'.'.$zone->rack.'.'.$zone->space.'.'.$zone->level;
        } elseif ($this->zone) {
            $zone = $this->zone;
            if($zone->warehouse) {
                return $zone->warehouse->ref.'_'.$zone->line.'.'.$zone->rack.'.'.$zone->space.'.'.$zone->level;
            }
            return $zone->line.'.'.$zone->rack.'.'.$zone->space.'.'.$zone->level;
        } else {
            return '';
        }
    }

    /**
     * Get photo path
     *
     * @return string
     */
    public function getPhotoPathAttribute()
    {
        if (is_file($this->path($this->photo))) {
            return $this->relPath($this->photo);
        }

        return null;
    }

    /**
     * Get photos lists
     *
     * @return array|null
     */
    public function getPhotosAttribute()
    {
        $files = \File::allFiles($this->path());

        $data = [];

        $files = (array)$files;

        /**
         * Order photos by date
         */
        usort($files, function($a, $b) {
            return filemtime($a) > filemtime($b);
        });

        foreach ($files as $item) {
            $data[] = $this->relPath($item->getFilename());
        }

        $this->photos = $data;

        return $this->photos;
    }

    /**
     * Get the user name of the user
     */
    public function getUsernameAttribute($data)
    {
        $user = $this->user;

        if ($user) {
            return $user->first_name.' '.$user->last_name;
        } else {
            return null;
        }
    }

    /**
     * Items has many logs
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function logs()
    {
        return $this->hasMany(Log::class);
    }

    public function fees()
    {
        return $this->hasMany(Fee::class);
    }


    /**
     * Item belongs to user
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function pickup()
    {
        return $this->belongsToMany(Pickup::class, 'booking_item', 'item_id', 'booking_id');
    }

    /**
     * Zone belongs to warehouse
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class);
    }

    /**
     * Zone belongs to warehouse
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function zone()
    {
        return $this->belongsTo(Zone::class);
    }

    /**
     * Item belongs to storage
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function storage()
    {
        return $this->belongsTo(Storage::class);
    }

    /**
     * Zone belongs to warehouse
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function pallet()
    {
        return $this->belongsTo(Pallet::class);
    }

    /**
     * Return the full address format
     */
    public function getFullAddress($format = "html")
    {
        $break = " ";

        $sep = " ";

        if ($format == "html") {
            $break = "<br />";
        }

        if ($format == "html") {
            $data = $this->number . (!empty($this->box) ? " /(" . $this->box . ") " : '') . $sep . $this->street . $break .
                $this->postalcode . $sep . $this->city . $break;
            if (!empty($this->add_infos)) {
                $data .= "(" . $this->add_infos . ")";
            }
        } else {
            $data = $this->number . " " . $sep . $this->street . $break .
                $this->postalcode . $sep . $this->city . $break;
        }

        return $data;
    }

    public static function addFiligrane($objet_id, $box_id, $image_string)
    {
        $image_string = base64_decode($image_string);

        $img=imagecreatefromstring($image_string);

        $marge_right = 10;
        $marge_bottom = 10;
        $sx = 150;
        $sy = 65;


        $url_fili=url('/tampon-photo.png');
        $fili=imagecreatefrompng($url_fili);

        imagecopy($img, $fili, imagesx($img) - $sx - $marge_right, imagesy($img) - $sy - $marge_bottom, 0, 0, 150, 65);

        $dir_name = public_path()."/files/items/".$objet_id;
        if(!file_exists($dir_name)){mkdir($dir_name);}
        imagejpeg($img,$dir_name.'/'.$box_id.'.jpg');
        imagedestroy($img);
        imagedestroy($fili);
    }

    /**
     * Override default toArray method
     *
     * @return array
     */
    public function toArray()
    {
        $data = parent::toArray();

        if ($this->photo) {
            $data['photos'] = $this->getPhotosAttribute($this->photo);
            $data['photo'] = $this->photo_path;

            if (!$data['photo'] && $data['photos']) {
                $data['photo'] = url($data['photos'][0]);
            }

            foreach ($data['photos'] as $i => $photo) {
                $data['photos'][$i] = url($photo);
            }
        } else {
            $data['photo'] = null;
            $data['photos'] = null;
        }

        $data['username'] = $this->getUsernameAttribute($data);
        $data['full_address'] = $this->getFullAddress();

        $data['localisation'] = $this->getLocalisationAttribute();

        return $data;
    }

    /**
     * Extends toArray method for the Api
     *
     * @return array
     */
    public function toArrayApi($deep = 1)
    {
        $data = $this->toArray();

        if ($deep <= Config::get('app.boxify_api.max_deep')) {
            $data['user'] = $this->user ? $this->user->toArrayApi($deep + 1) : null;
            $data['pickup'] = [];
            foreach ($this->pickup as $pickup) {
                $data['pickup'][] = $pickup->toArrayApi($deep + 1);
            }

            unset($data['user_id']);
            unset($data['pickup_id']);
        }

        $data['warehouse'] = $this->warehouse ? $this->warehouse->toArrayApi(): null;
        $data['zone'] = $this->storage ? $this->storage->toArrayApi() : null;
        $data['pallet'] = $this->pallet ? $this->pallet->toArrayApi() : null;
        $data['storage'] = $data['zone'];

        unset($data['warehouse_id']);
        unset($data['zone_id']);
        unset($data['pallet_id']);
        unset($data['storage_id']);

        if ($this->photo) {
            $data['photo'] = url($this->photo);
        } elseif ($data['photos'] && isset($data['photos'])) {
            $data['photo'] = url($data['photos'][0]);
            foreach ($data['photos'] as $i => $photo) {
                $data['photos'][$i] = url($photo);
            }
        }

        return $data;
    }

    public function updateStatus($newStatus, $pickupId) {
        if ($this->status != $newStatus) {
            $bookingItemStatusHistory = new BookingItemStatusHistory();
            $bookingItemStatusHistory->create([
                'status' => $this->status,
                'booking_id' => $pickupId,
                'item_id'   => $this->id
            ]);
            $this->status = $newStatus;
            $this->save();
            return true;
        } else {
            return false;
        }
    }

    public function updateStatusToPreviousOne($pickupId, $defaultStatus = Item::STATUS_STORED) {
        //IF Item belongs to another open order then do not chnage the ORDERED status.
        if ($this->status == Item::STATUS_ORDERED) {
            $countOrder = $this->pickup()
                            ->where('pickups.id', '!=', $pickupId)
                            ->where('pickups.status', '=', Pickup::STATUS_ORDERED)
                            ->where('pickup_date', '>=', new DateTime("now"))
                            ->count();
            if ($countOrder > 0) {
                return false;
            }
        }

        $bookingItemStatusHistory = BookingItemStatusHistory::query()
            ->where('item_id', '=', $this->id)
            ->where('booking_id', '=', $pickupId)
            ->orderBy('id', 'desc')->first();

        $previousStatus = $defaultStatus;
        if ($bookingItemStatusHistory != null) {
            $previousStatus = $bookingItemStatusHistory->status;
        }
        return $this->updateStatus($previousStatus, $pickupId);
    }
}
