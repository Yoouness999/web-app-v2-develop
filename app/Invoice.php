<?php namespace App;

use App\Contracts\PayableInterface;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Invoice extends Model implements PayableInterface
{
    use SoftDeletes;

    // Invoice is queued when we need to make a proration
    const STATUS_QUEUED = "queued";
    const STATUS_UNPAID = 'unpaid';
    const STATUS_PAID = 'paid';
    const STATUS_TO_REFUND = 'to refund';
    const STATUS_REFUNDED = 'refunded';
    const STATUS_CANCELLED = 'cancelled';

    const TYPE_CREDIT_NOTE = "credit_note";
    const TYPE_INVOICED = "invoiced";
    const TYPE_FEE = "fee";
    const TYPE_MONTHLY = "monthly";
    const TYPE_PICKUP = "pickup";
    const TYPE_DELIVERY = "delivery";
    const TYPE_SERVICES = "services";
    const TYPE_INVOICE = "";

    /**
     * @deprecated => THIS NOTION HAS BEEN REMOVED => use invoiced !!
     */
    const TYPE_PROFORMA = "invoiced";

    protected $fillable = [
        "number",
        "title",
        "content",
        "price",
        "user_id",
        "item_id",
        "pickup_id",
        "fee_id",
        "status",
        "attempt",
        "payment_date",
		"validation_payment_date",
        "payment_schedule",
        "billing_ref",
        "billing_type",
        "billing_id",
        "billing_exempted",
        "last_attempt_at",
        "type",
        "transferred_to_odoo",
        "odoo_updated_at",
        "no_vat_content",
        "no_vat_price",
        "format",
        "ref_invoice_id",
        "total"
    ];

    protected $dates = [
        'updated_at',
        'created_at',
        'last_attempt_at'
    ];

    protected $statusEnums = [
        'paid' => 'paid',
        'unpaid' => 'unpaid',
        'queued' => 'queued',
        'refunded' => 'refunded'
    ];

	/**
     * Invoice belongs to a user
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }

	/**
     * Get the invoice tax
     *
     * @return float
     */
    public function getTaxAttribute()
    {
		if ($this->user) {
			return $this->user->tax;
		}

        return 21.00;
    }

    /**
     * Little method to decode invoice (to keep it a little more safe)
     * @param $hashed
     * @return mixed
     */
    public static function decodeInvoiceId($hashed)
    {
        $ids = explode('-', $hashed);
        return array_pop($ids);
    }

    /**
     * Little methode to encode invoice to keep it safe in a public url
     *
     * @return string
     */
    public function encodeInvoiceId()
    {
        return date('Ymd-His') . '-' . $this->id;
    }

    /**
     * Generate the number of invoice
     *
     * @info Rules are AA/WX (A=année, X= numéro de facture selon suite)
     * @see http://pm2.cherrypulp.com/projects/367?modal=Task-7461-367
     * @param bool $save
     * @param bool $force
     * @return mixed|string
     */
    public function generateNumber($save = true, $force = true)
    {
        if ($this->number) {
            return $this->number;
        }

        $year = date('y');
        $year4 = date('Y');

        if ($this->type == Invoice::TYPE_CREDIT_NOTE) {

            $number = Invoice::where("created_at",">", $year4."-01-01 00:00:00")->where("created_at", "<", ($year4+1)."-01-01 00:00:00")->where("type", "=", Invoice::TYPE_CREDIT_NOTE)->count();
            $this->number = $year . '/nc/' . sprintf("%04d", $number);
        } else {
            $number = Invoice::where("created_at",">", $year4."-01-01 00:00:00")->where("created_at", "<", ($year4+1)."-01-01 00:00:00")->where("type", "!=", Invoice::TYPE_CREDIT_NOTE)->count();
            $this->number = $year."/W".str_pad($number, 4,"0", STR_PAD_LEFT);
        }

        if ($save) {
            $this->save();
        }

        return $this->number;
    }

    public function getId()
    {
        return $this->id;
    }

    /**
     * Get the next attempt days
     *
     * @return int
     */

    public function getNextAttemptDays()
    {
        $days_before_next_attempt = 7;
        if($this->attempt >= 5) {
            $days_before_next_attempt = 30;
        }
        return $days_before_next_attempt;
    }

    public function getPrice()
    {
        return $this->total;
    }

    /**
     * Used to get a ref matching with payment notification
     */
    public function getRef(): string
    {
        return "invoice-" . $this->user->id . '-' . $this->id;
    }

    public function toArrayApi()
    {
        $data = $this->toArray();
        $data['user'] = $this->user;
        return $data;
    }

    public function toArray()
    {
        $data = parent::toArray();

        $data['pdf'] = $this->getDownloadUrl();
		$data['priceHTVA'] = round($this->price / (1 + ($this->tax / 100)), 2);
		$data['priceTVA'] = round(($this->tax * $this->price) / (100 + $this->tax), 2);
		$data['priceTVAC'] = $this->price;
		$data['pricePercentageTVA'] = $this->tax;
        $data['total'] = $this->getPrice();

		$data['name'] = $this->user ? $this->user->full_name : '';
		$data['company_vat_number'] = $this->user ? $this->user->company_vat_number : '';

		$creditNote = self::find($this->credit_note_id);
		$data['credit_note_number'] = $creditNote ? $creditNote->number : '';

        return $data;
    }

    /**
     * Get download url
     */
    public function getDownloadUrl()
    {
        return url('download/pdf/' . $this->id);
    }

    public function incrementPaymentAttemptAndUpdateTotal()
    {
        $this->attempt++;
        if ($this->format == 1) {
            if ($this->attempt == 3) {
                $fee = [];
                $fee['price'] = lg('fees.3_attempt_fee.price');
                $fee['description'] = lg('fees.3_attempt_fee.description');
                $this->no_vat_price += $fee['price'];
                $this->no_vat_content .= $fee['description'] . " - " . date('d/m/Y') . " +" . $fee['price'] . " €<br />";
            } elseif ($this->attempt == 4) {
                $fee = [];
                $fee['price'] = lg('fees.4_attempt_fee.price');
                $fee['description'] = lg('fees.4_attempt_fee.description');
                $this->no_vat_price += $fee['price'];
                $this->no_vat_content .= $fee['description'] . " - " . date('d/m/Y')  . " +" . $fee['price'] . " €<br />";
            } elseif ($this->attempt == 5) {
                $fee = [];
                $fee['price'] = lg('fees.5_attempt_fee.price');
                $fee['description'] = lg('fees.5_attempt_fee.description');
                $this->no_vat_price += $fee['price'];
                $this->no_vat_content .= $fee['description'] . " - " . date('d/m/Y')  . " +" . $fee['price'] . " €<br />";
            } elseif ($this->attempt == 6) {
                $fee = [];
                $fee['price'] = lg('fees.6_attempt_fee.price');
                $fee['description'] = lg('fees.6_attempt_fee.description');
                $this->no_vat_price += $fee['price'];
                $this->no_vat_content .= $fee['description'] . " - " . date('d/m/Y')  . " +" . $fee['price'] . " €<br />";
            } elseif ($this->attempt > 6) {
                $fee = [];
                $fee['price'] = lg('fees.7_attempt_fee.price');
                $fee['description'] = lg('fees.7_attempt_fee.description');
                $this->no_vat_price += $fee['price'];
                $this->no_vat_content .= $fee['description'] . " - " . date('d/m/Y')  . " +" . $fee['price'] . " €<br />";
            }
        } else {
            if ($this->attempt == 3) {
                $fee = [];
                $fee['price'] = lg('fees.3_attempt_fee.price');
                $fee['description'] = lg('fees.3_attempt_fee.description');
                $this->price += $fee['price'];
                $this->content .= $fee['description'] . " - " . date('d/m/Y') . " - " . $fee['price'] . " €<br />";
            } elseif ($this->attempt == 4) {
                $fee = [];
                $fee['price'] = lg('fees.4_attempt_fee.price');
                $fee['description'] = lg('fees.4_attempt_fee.description');
                $this->price += $fee['price'];
                $this->content .= $fee['description'] . " - " . date('d/m/Y')  . " - " . $fee['price'] . " €<br />";
            } elseif ($this->attempt == 5) {
                $fee = [];
                $fee['price'] = lg('fees.5_attempt_fee.price');
                $fee['description'] = lg('fees.5_attempt_fee.description');
                $this->price += $fee['price'];
                $this->content .= $fee['description'] . " - " . date('d/m/Y')  . " - " . $fee['price'] . " €<br />";
            } elseif ($this->attempt == 6) {
                $fee = [];
                $fee['price'] = lg('fees.6_attempt_fee.price');
                $fee['description'] = lg('fees.6_attempt_fee.description');
                $this->price += $fee['price'];
                $this->content .= $fee['description'] . " - " . date('d/m/Y')  . " - " . $fee['price'] . " €<br />";
            } elseif ($this->attempt > 6) {
                $fee = [];
                $fee['price'] = lg('fees.7_attempt_fee.price');
                $fee['description'] = lg('fees.7_attempt_fee.description');
                $this->price += $fee['price'];
                $this->content .= $fee['description'] . " - " . date('d/m/Y')  . " - " . $fee['price'] . " €<br />";
            }
        }

        $this->total = $this->price + $this->no_vat_price;
        if ($this->total < 0) {
            $this->total = 0;
        }
        $this->save();
    }
}
