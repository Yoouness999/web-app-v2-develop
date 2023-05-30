<?php namespace App;

use App\Traits\CanInvites;
use App\Traits\HasAnswers;
use App\Traits\ModelFilesHandlingTrait;
use Arx\traits\modelUserTrait;
use App\Api\ApiToken;
use Cookie;
use Doctrine\DBAL\Query\QueryBuilder;
use Exception;
use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Lang;
use Mail;
use Config;
use App\Api\ApiApp;
use Datetime;
use Log;

class User extends Model implements AuthenticatableContract, CanResetPasswordContract
{
    use Authenticatable, CanResetPassword;

    /*use modelFilesHandlingTrait;
    use modelUserTrait;*/
    use SoftDeletes;
    use CanInvites;
    use HasAnswers;
    use Notifiable;

    const STATUS_ACTIVE = 'active';
    const STATUS_SUSPENDED = 'suspended';

    const BILLING_STATUS_PAID = 'paid';
    const BILLING_STATUS_UNPAID = 'unpaid';
    const BILLING_STATUS_NOINVOICE = '';

    const BILLING_TYPE_ADYEN = 'adyen';
    /**
     * @deprecated Lemonway is deprecated not used anymore
     */
    const BILLING_TYPE_LEMONWAY = 'lemonway';

    const CUSTOMER_TYPE_PRIVATE = "private";
    const CUSTOMER_TYPE_PROFESSIONAL = "professional";

    const BILLING_METHOD_SEPA = "sepa";
    const BILLING_METHOD_CREDITCARD = "creditcard";

    public static $filepath = null;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    protected $casts = [
        "billing_address" => "integer",
        "billing_exempted" => "integer",
        "active" => "integer",
        "business" => "integer",
        "is_billable" => 'integer'
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        "email",
        "name",
        "first_name",
        "last_name",
        "postalcode",
        "add_infos",
        "city",
        "box",
        "number",
        "street",
        "latitude",
        "longitude",
        "phone",
        "oauth_id",
        "godfather_id",
        "lang",
        "business",
        "billing_card_year",
        "billing_card_month",
        "billing_card_number",
        "billing_card_holder",
        "billing_card_id",
        "billing_wallet_id",
        "billing_info_type",
        "billing_status",
        "billing_type",
        "billing_env",
        "billing_id",
        "billing_customer_id",
        "billing_next_date",
        "billing_city",
        "billing_postalcode",
        "billing_box",
        "billing_number",
        "billing_street",
        "billing_to",
        "billing_vat",
        "billing_exempted",
        "billing_address",
        "users_email_unique",
        "users_email_unique",
        "password",
        "activation_code",
        "active",
        "remember_token",
        "status",
        "invitation_code",
        "billing_method",
        "avg_cart",
        "last_order",
        "created_at",
        "updated_at",
        "deleted_at",
        "country",
        "customer_type",
        "id_card_file_recto",
        "id_card_file_verso",
        "billing_deposit",
        "address_country",
        "company_name",
        "company_vat_number",
        "company_address_route",
        "company_address_street_number",
        "company_address_locality",
        "company_address_postal_code",
        "company_address_country",
        "company_address_box",
        "order_plan_id",
        "order_plan_region_id",
        "order_plan_price_per_month",
        "order_assurance_id",
        "order_storing_duration_id",
        "end_commitment_period",
        "photo",
        "is_billable",
        "billing_iban",
        "advisor_id",
        "billing_country",
        "agree",
        "old_pricing",
        "fixed_price",
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];

    /*
     * Activate Account
     */
    public static function accountIsActive($code)
    {
        $user = self::where('activation_code', '=', $code)->first();

        if ($user) {
            $user->active = 1;
            $user->status = self::STATUS_ACTIVE;
            \Auth::login($user);
            $user->save();
            return true;
        }

        return false;
    }

    /**
     * Get advisor linked to the user (in admin)
     */
    public function advisor()
    {
        return $this->hasOne(ArxminUser::class, 'id', 'advisor_id');
    }

    /**
     * User belongs to an area
     */
    public function area()
    {
        return $this->belongsTo(Area::class, 'postalcode', 'zip_code');
    }

    /**
     * Check if user can apply for invitation code
     *
     * @return bool
     */
    public function canApplyInvitationCode()
    {
        return !$this->isActive() && Cookie::get('invitation_code');
    }

    /**
     * Check if user is active
     *
     * @return mixed
     */
    public function isActive()
    {
        return $this->active;
    }

    /**
     * Charge user money
     *
     * @param $price
     * @param string $comment
     * @return \LemonWay\ApiResponse
     *
     * @throws Exception
     * @deprecated V2 => to remove
     */
    public function chargeMoney($price, $comment = '')
    {
        $api = Api::getPaymentApi();

        $reponse = $api->MoneyInWithCardId([
            'wallet' => $this->getWalletId(),
            'cardId' => $this->billing_card_id,
            'amountTot' => $price,
            'amountCom' => $price,
            'comment' => $comment,
            'autoCommission' => 0
        ]);

        if ($reponse->lwError) {
            throw new \Exception($reponse->lwError->MSG);
        }

        return $reponse;
    }

    /**
     * Get the walled id from the user
     *
     */
    public function getWalletId()
    {
        // Return the BOXIFY WALLET ID
        return 'BOXIFY';
    }

    /**
     * Get all availables users coupons
     */
    public function coupons()
    {
        return $this->belongsToMany('App\Coupon', 'coupon_user');
    }

    public function debitNotes()
    {
        return $this->hasMany('App\\DebitNotes');
    }

    public function fees()
    {
        return $this->hasMany(Fee::class);
    }

    /**
     * Return fees as a list
     */
    public static function feesList()
    {
        /**
         * @@var $list array
         */
        $list = Lang::get('fees');

        $list = array_map(function ($item) {
            return @$item['name'] . '' . @$item['description'];
        }, $list);

        return $list;
    }

    /**
     * Get answers in a readable format
     */
    public function getAnswers()
    {

        $answers = [];

        if ($this->answers) {
            $this->answers->map(function ($item) use (&$answers) {
                $question = OrderQuestion::find($item->order_question_parent_id);

                if ($question) {
                    if ($question->type == 'boolean') {
                        $value = $item->value_boolean ? 'yes' : 'no';
                    } else {
                        $value = $item->value_number_from;
                    }

                    if (!isset($answers[$question->type])) {
                        $answers[$question->type] = [];
                    }

                    $answers[$question->type][$question->id] = $value;
                }

                return $item;
            });
        }

        return $answers;
    }

    /**
     * Create a access token for the API
     */
    public function getApiAccessToken(ApiApp $app)
    {
        return $this->getApiToken($app, ApiToken::TYPE_ACCESS);
    }

    /**
     * Create a token for the API
     */
    public function getApiToken(ApiApp $app, $type)
    {
        $token = new ApiToken();
        $token->type = $type;
        $token->setToken();
        $token->app()->associate($app);
        $token->user()->associate($this);
        $token->save();

        return $token;
    }

    /**
     * Create a refresh token for the API
     */
    public function getApiRefreshToken(ApiApp $app)
    {
        return $this->getApiToken($app, ApiToken::TYPE_REFRESH);
    }

    /**
     * Get the balance account (invoices unpaid + current balance)
     *
     * @memo => same rules applied in cron controller
     */
    public function getBalanceAccount()
    {
        // 1. get all invoices unpaid
        $user = $this;

        $price = $user->getPricePerMonth();

        return $price;
    }

    /**
     * Get the price per month
     *
     * @formula : (user.price_per_month * discount on price) + user insurance price
     *
     * - if billing_exempted => remove 21% TVA
     * - if business and not billing_exempted => remove 21% and add country TAX
     * - if payment by card => add 2% fee
     */
    public function getPricePerMonth()
    {

        $priceDescription = $this->getPricePerMonthDescription();

        $price = 0;

        foreach ($priceDescription as $line) {
            $price += $line['price'];
        }

        $price = $this->applyPriceConditions($price);

        return round($price, 2);
    }

    /**
     * Apply TVA price
     *
     * @param $price
     * @return float
     */
    public function applyTvaPrice($price)
    {
        if ($this->billing_exempted) {
            $price = round($price / 1.21, 2);
        }
        return $price;
    }

    /**
     * Helper to get the detail of the price
     *
     * @param string $format
     * @return string|array
     */
    public function getPricePerMonthDescription($format = 'array')
    {
        $data = [];

        if (!$this->plan) {

            $data[] = [
                'description' => 'No plan',
                'price' => 0
            ];
        } else {
            if ($this->order_plan_price_per_month) {
                $data[] = [
                    'description' => '',
                    'price' => $this->applyTvaPrice($this->order_plan_price_per_month)
                ];
            }

            if ($this->storingDuration && isset($this->storingDuration->discount_percentage)) {
                $discount = $this->storingDuration->discount_percentage;
                if($this->old_pricing) {
                    $discount = $this->storingDuration->old_discount_percentage;
                }
                //TODO format disocunt percentage with roundup
                if ($discount >= 0) {
                    $label = "";
                    if($this->storingDuration->slug == '-3_months') {
                        $label = lg('invoice.monthly.storage-duration.-3_months', null, [], $this->lang);
                    } else {
                        $label = shortcode(lg("invoice.storage-duration.description", null, [], $this->lang), [
                            'months' => lg("order.appointment.storing-duration." . $this->storingDuration->slug, null, [], $this->lang),
                            'discount' => round($discount)
                        ]);
                    }
                    $data[] = [
                        'description' => $label,
                        'price' => 0
                    ];
                }
            }

            if ($this->order_insurance_custom_price) {
                $data[] = [
                    'description' => str_replace('strong', 'span', lg("order.review.assurance.on_demand.description", null, [], $this->lang)),
                    'price' => $this->applyTvaPrice($this->order_insurance_custom_price)
                ];
            } elseif ($this->insurance) {
                $data[] = [
                    'description' => str_replace('strong', 'span', lg("order.review.assurance." . $this->insurance->slug . ".description", null, [], $this->lang)),
                    'price' => $this->applyTvaPrice($this->insurance->getPricePerMonth())
                ];
            }

            if ($this->isCreditCard()) {
                $data[] = [
                    'description' => lg("common.payment-type-credit-card", null, [], $this->lang),
                    'price' => 0
                ];
            }
        }

        if ($format == 'html') {
            $lines = "";
            foreach ($data as $line) {
                if($line['description'] !== '') {
                    $lines .= " - {$line['description']} " . "<br />";
                }
            }
            return $lines;
        }

        return $data;
    }

    /**
     * Check if user has iban
     */
    public function isCreditCard()
    {
        return $this->billing_method == self::BILLING_METHOD_CREDITCARD || $this->billing_type == self::BILLING_TYPE_LEMONWAY;
    }

    /**
     * Apply the different prices conditions with tax etc.
     *
     * @see https://docs.google.com/document/d/1bIIA0VfYNeP_Q3wFyn0Ju4KnHEf0xc-cAxHvIpRob6M/edit
     * @param $price
     * @return float|string
     */
    public function applyPriceConditions($price)
    {
        if ($this->storingDuration) {
            $discount = $this->storingDuration->discount_percentage;
            if($this->old_pricing) {
                $discount = $this->storingDuration->old_discount_percentage;
            }

            if ($discount) {
                $price = $price - ($price * ($discount / 100));
            }
        }

        /**
         * If user is business and !billing_exempted => apply the tax of the user country
         */
        if ($this->business && !$this->billing_exempted) {
            $price = round(($price / 1.21) * (1 + ($this->tax / 100)), 2);
        }

        /**
         * If it's a payment by credit card => majoration of 2% except for billing_method sepa
         */
        if ($this->isCreditCard()) {
            $price = $price * 1.02;
        }

        return $price;
    }

    /**
     * Get the billing address infos
     */
    public function getBillingAddress()
    {
        if ($this->isBusiness()) {
            $data = [
                'billing_to' => $this->company_name,
                'billing_address' => $this->company_address_route,
                'billing_vat' => $this->company_vat_number,
                'billing_number' => $this->company_address_street_number,
                'billing_city' => $this->company_address_locality,
                'billing_street' => $this->company_address_box,
                'billing_box' => $this->company_address_route,
                'billing_postalcode' => $this->company_address_postal_code
            ];
        } elseif ($this->billing_street) {
            $data = [
                'billing_to' => ($this->billing_to != null && trim($this->billing_to) != '')? $this->billing_to : $this->first_name .' '.$this->last_name,
                'billing_address' => $this->billing_address,
                'billing_vat' => $this->billing_vat,
                'billing_number' => $this->billing_number,
                'billing_city' => $this->billing_city,
                'billing_street' => $this->billing_street,
                'billing_box' => $this->billing_box,
                'billing_postalcode' => $this->billing_postalcode
            ];
        } else {
            $data = [
                'billing_to' => ($this->name != null && trim($this->name) != '')? $this->name : $this->first_name .' '.$this->last_name,
                'billing_address' => $this->street,
                'billing_vat' => '',
                'billing_number' => $this->number,
                'billing_city' => $this->city,
                'billing_street' => $this->street,
                'billing_box' => $this->box,
                'billing_postalcode' => $this->postalcode
            ];
        }

        return $data;
    }

    public function isBusiness()
    {
        return $this->business;
    }

    /**
     * Get billing card expiration date
     *
     * Return Lemon Way or Adyen information. Use request cache lifetime.
     */
    public function getBillingCardExpirationDate($forceCache = false)
    {
        return $this->getBillingCardExpirationMonth() . '/' . $this->getBillingCardExpirationYear();
    }

    /**
     * Get billing card expiration month
     *
     * Return Lemon Way or Adyen information. Use request cache lifetime.
     */
    public function getBillingCardExpirationMonth($forceCache = false)
    {
        if ($this->hasLemonWayBillingInfo()) {
            return $this->billing_card_month;
        } else {
            $result = Adyen::getRecurringContract($this, $forceCache);
            if (isset($result['details'])) {
                foreach ($result['details'] as $detail) {
                    if (isset($detail['RecurringDetail']['card'])) {
                        return $detail['RecurringDetail']['card']['expiryMonth'];
                    }
                }
            }
        }

        return '';
    }

    /**
     * Check if user has Lemonway Way billing info
     *
     * @return bool
     */
    public function hasLemonWayBillingInfo()
    {
        return $this->billing_card_id && $this->billing_type == self::BILLING_TYPE_LEMONWAY;
    }

    /**
     * Get billing card expiration year
     *
     * Return Lemon Way or Adyen information. Use request cache lifetime.
     */
    public function getBillingCardExpirationYear($forceCache = false)
    {
        if ($this->hasLemonWayBillingInfo()) {
            return $this->billing_card_year;
        } else {
            $result = Adyen::getRecurringContract($this, $forceCache);
            if (isset($result['details'])) {
                foreach ($result['details'] as $detail) {
                    if (isset($detail['RecurringDetail']['card'])) {
                        return $detail['RecurringDetail']['card']['expiryYear'];
                    }
                }
            }
        }

        return '';
    }

    /**
     * Get billing card holder name
     *
     * Return Lemon Way or Adyen information. Use request cache lifetime.
     */
    public function getBillingCardHolderName($forceCache = false)
    {
        if ($this->hasLemonWayBillingInfo()) {
            return $this->billing_card_holder;
        } else {
            $result = Adyen::getRecurringContract($this, $forceCache);
            if (isset($result['details'])) {
                foreach ($result['details'] as $detail) {
                    if (isset($detail['RecurringDetail']['card'])) {
                        return $detail['RecurringDetail']['card']['holderName'];
                    }
                }
            }
        }

        return '';
    }

    /**
     * Get billing card holder name
     *
     * Return Lemon Way or Adyen information. Use request cache lifetime.
     */
    public function getBillingCardId($forceCache = false)
    {
        if ($this->hasLemonWayBillingInfo()) {
            return $this->billing_card_id;
        } else {
            $result = Adyen::getRecurringContract($this, $forceCache);
            if (isset($result['details'])) {
                foreach ($result['details'] as $detail) {
                    if (isset($detail['RecurringDetail']['recurringDetailReference'])) {
                        return $detail['RecurringDetail']['recurringDetailReference'];
                    }
                }
            }
        }

        return '';
    }

    /**
     * Get billing card number
     *
     * Return Lemon Way or Adyen information. Use request cache lifetime.
     */
    public function getBillingCardNumber($forceCache = false)
    {
        if ($this->hasLemonWayBillingInfo()) {
            return $this->billing_card_number;
        } else {
            $result = Adyen::getRecurringContract($this, $forceCache);
            if (isset($result['details'])) {
                foreach ($result['details'] as $detail) {
                    if (isset($detail['RecurringDetail']['card'])) {
                        return '**** **** **** ' . $detail['RecurringDetail']['card']['number'];
                    }
                }
            }
        }

        return $this->billing_card_number;
    }

    /**
     * Get billing IBAN
     *
     * Return Lemon Way or Adyen information. Use request cache lifetime.
     */
    public function getBillingIban($forceCache = false)
    {
        return $this->billing_iban;
    }

    /**
     * Get billing IBAN owner name
     *
     * Return Lemon Way or Adyen information. Use request cache lifetime.
     */
    public function getBillingIbanOwnerName($forceCache = false)
    {
        return $this->billing_iban_owner;
    }

    public function getCardDetail()
    {
        if ($this->hasLemonWayBillingInfo()) {
            $api = Api::getPaymentApi();

            $response = $api->GetWalletDetails([
                'wallet' => $this->getWalletId(),
                'email' => $this->email
            ]);

            return $response;
        }

        return [];
    }

    /**
     * Get Status of the user account
     * @return array
     * @throws
     * @throws Exception
     * @internal param array $params
     */
    public function getInvoices()
    {

        $invoices = [];
        // Get User Invoices
        $oInvoices = Invoice::where('user_id', $this->id)->orderBy('id', 'DESC')->get();

        /**
         * @var $invoice Invoice
         */
        foreach ($oInvoices as $invoice) {
            $dataInvoice = [
                'id' => $invoice->id,
                'number' => $invoice->number,
                'orderId' => $invoice->title,
                'fee_id' => $invoice->fee_id,
                'date' => $invoice->created_at->format('d/m/Y'),
                'type' => $invoice->type,
                'status' => $invoice->status,
                'billing_exempted' => $invoice->billing_exempted,
                'devise' => 'EUR',
                'payment' => '',
                'paymentImage' => '',
                'price' => round($invoice->price, 2),
                'amount' => round($invoice->price, 2),
                'invoice_url' => $invoice->getDownloadUrl(),
                'created_at' => $invoice->createdAt,
                'title' => $invoice->title,
                'content' => $invoice->content,
                'customer' => $this->name,
                'billing_to' => $this->billing_to,
                'billing_address' => $this->billing_address,
                'billing_vat' => $this->billing_vat,
                'billing_number' => $this->billing_number,
                'billing_city' => $this->billing_city,
                'billing_street' => $this->billing_street,
                'billing_box' => $this->billing_box,
                'billing_postalcode' => $this->billing_postalcode,
            ];

            $invoices[$invoice->id] = $dataInvoice;
        }

        return $invoices;
    }

    /**
     * Return the items count
     *
     * @return mixed
     */
    public function getItemsCountAttribute($data)
    {
        return $this->items()->count();
    }

    /**
     * User has many items
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function items()
    {
        return $this->hasMany('App\\Item');
    }

    /**
     * Get region
     */
    public function getRegion()
    {
        if ($this->area) {
            if ($this->area->region) {
                return $this->area->region;
            }
        }

        return Region::getDefaultRegion();
    }

    /**
     * Get the default user tax
     *
     * @return float
     */
    public function getTaxAttribute()
    {
        if ($this->business && $this->company_address_country) {
            $tax = Taxe::where('country_id', $this->company_address_country)->first();

            if ($tax) {
                return (float)$tax->value_percentage;
            }
        }

        return 21.00;
    }

    /**
     * Get the total of items owned by the customer
     *
     * @param $data
     */
    public function getTotalAttribute($data)
    {
        return Item::where('user_id', $this->id)->sum('price');
    }

    /**
     * Godchildrens
     */
    public function godchildrens()
    {
        return $this->hasMany(User::class, 'godfather_id');
    }

    /**
     * Godfather
     */
    public function godfather()
    {
        return $this->belongsTo(User::class, 'godfather_id');
    }

    /**
     * Check if user has billing info
     *
     * @return bool
     */
    public function hasBillingInfo()
    {
        return $this->hasLemonWayBillingInfo() || $this->hasAdyenWayBillingInfo();
    }

    /**
     * Check if user has Adyen billing info
     *
     * @return bool
     */
    public function hasAdyenWayBillingInfo($forceCache = false)
    {
        return $this->billing_type == self::BILLING_TYPE_ADYEN;
    }

    /**
     * Insurance related to current user
     */
    public function insurance()
    {
        return $this->belongsTo(OrderAssurance::class, 'order_assurance_id');
    }

    /**
     * Return invitations related to the user
     */
    public function invites()
    {
        return $this->hasMany(Invite::class, 'godfather_id');
    }

    /**
     * Check email unicity
     */
    public static function isEmailAvailable($email, $userIdsIgnored = [])
    {
        return self::where('email', $email)->whereNotIn('id', $userIdsIgnored)->get()->isEmpty();
    }

    /**
     * Check if user has iban
     */
    public function isIban()
    {
        return $this->billing_method == self::BILLING_METHOD_SEPA;
    }

    /**
     * Check if the user is in payment default
     */
    public function isInPaymentDefault()
    {
        return $this->billing_status == self::BILLING_STATUS_UNPAID;

//        $unpaidInvoices = Invoice::where('user_id', $this->id)->where('status', Invoice::STATUS_UNPAID)->count();
//
//        if ($unpaidInvoices) {
//
//            if ($this->billing_status != self::BILLING_STATUS_UNPAID) {
//                $this->billing_status = self::BILLING_STATUS_UNPAID;
//                $this->save();
//            }
//
//            return true;
//
//        } elseif ($this->billing_status != self::BILLING_STATUS_PAID) {
//            $this->billing_status = self::BILLING_STATUS_UNPAID;
//            $this->save();
//        }
//
//        return false;
    }

    public function hasUnpaidInvoices()
    {
        return $this->invoices()->where('status', Invoice::STATUS_UNPAID)->count();
    }

    /**
     * Check if last order of the user is confirmed
     */
    public function isLastOrderConfirmed()
    {
        $invoice = $this->getLastInvoice();

        return $invoice && (in_array($invoice->status, [Invoice::STATUS_PAID, Invoice::STATUS_TO_REFUND, Invoice::STATUS_REFUNDED]));
    }

    /**
     * Get last Invoice
     */
    public function getLastInvoice()
    {
        return $this->invoices()->orderBy('created_at', 'desc')->first();
    }

    /**
     * Calculate the users items that need to be taken in account for Invoice Facturation and volume price
     *
     * @see https://docs.google.com/spreadsheets/d/1_NwPeAh8PTr9aYMgb40qEU9wgRMU4Hc7fZmyF6gya28/edit#gid=798116730&range=A3
     *
     * @return QueryBuilder
     */
    public function itemsToInvoice($month = null)
    {

        if (!$month) {
            $month = date('Y-m-d H:i:s', strtotime('first day of next month'));
        }

        $items = $this->items()->where('status', Item::STATUS_STORED)->orWhere(function ($query) use ($month) {
            $query->where('status', Item::STATUS_IN_TRANSIT);
            $query->where('ending_date', '>', $month);
        });

        return $items;
    }

    public function logs()
    {
        return $this->hasMany('App\\Log');
    }

    public function pickups()
    {
        return $this->hasMany('App\\Pickup');
    }

    public function plan()
    {
        return $this->belongsTo('App\\OrderPlan', 'order_plan_id');
    }

    /**
     * Recalculate the user plan with all items in Storage
     *
     * @see https://docs.google.com/spreadsheets/d/1_NwPeAh8PTr9aYMgb40qEU9wgRMU4Hc7fZmyF6gya28/edit#gid=798116730
     * @param bool $previewMode
     * @return array|bool
     */
    public function recalculatePlan($previewMode = false)
    {
        // Check if all items is outdated or not
        $volume = $this->items()
            ->whereIn(
            'status', [
                Item::STATUS_STORED,
                Item::STATUS_LOADED,
                Item::STATUS_TO_INDEX,
                Item::STATUS_ORDERED,
                Item::STATUS_PICKED_UP,
                Item::STATUS_INDEXED,
                Item::STATUS_DROPPED
            ])
            ->whereNull('deleted_at')
            ->sum('volume_m3')
        ;
        if (!$volume) {
            $volume = 0;
        }
        Log::info("USER ITEM  VOLUME:". $volume);
        if (!$this->plan || $this->plan->volume_m3 < $volume || $this->end_commitment_period < date('Y-m-d H:i:s')) {
            // Find the best plan that match in volume
            $orderPlan = OrderPlan::where('volume_m3', '>=', $volume)
                            ->where('price_per_month', '>', 0)
                            ->orderBy('volume_m3', 'asc')
                            ->first();
            $this->recalculateOrderPlanPrice($orderPlan);
            $this->old_pricing = 0;
            $this->save();
            if ($previewMode) {
                return [
                    'order_plan_id' => $orderPlan->id,
                    'order_plan_price_per_month' => $this->order_plan_price_per_month,
                    'volume' => $volume
                ];
            }

            return [
                'order_plan_id' => $orderPlan->id,
                'order_plan_price_per_month' => $this->order_plan_price_per_month,
                'volume' => $volume
            ];
        }

        return false;
    }

    /**
     * recalculate order plan price per month based on given orderplan
     */
    public function recalculateOrderPlanPrice($orderPlan, $force = false) {
        Log::info("Recalculating the user plan/price USER:". $this->id);
        if (!is_null($orderPlan) && ($this->fixed_price == 0 || $force)) {
            Log::info("Recalculating the user plan/price PLAN:". $orderPlan->id);
            $this->order_plan_id = $orderPlan->id;
            $this->order_plan_price_per_month = $orderPlan->price_per_month;
            Log::info("Recalculating the user plan/price PRICE:". $orderPlan->price_per_month);
            if ($this->postalcode) {
                # Check if we must apply the pricing per region
                $area = Area::where('zip_code', $this->postalcode)->first();

                if ($area) {
                    $orderPlanRegion = OrderPlanRegion::where('region_id', $area->region_id)
                                        ->where('order_plan_id', $orderPlan->id)
                                        ->first();

                    if ($orderPlanRegion) {
                        $this->order_plan_region_id = $orderPlanRegion->id;
                        $this->order_plan_price_per_month = $orderPlanRegion->price_per_month;
                    }
                }
            }
            $this->save();
        }
        return $this;
    }

    /**
     * Send Email Confirmation to user
     */
    public function sendMailConfirmation()
    {   
        $mailSent = false;
        $data = \DM()->getBySlug('mail/confirmation');

        $user = $this->toArray();

        if (!$this->activation_code) {
            $this->activation_code = str_random(60) . md5($this->email);
            $this->save();
        }

        $data['content'] = shortcode($data['content'], [
            'user' => [
                'first_name' => $this->first_name ?: ""
            ],
            'confirmation_link' => (string)\HTML::link(url('activate/' . $this->activation_code), lg("activation_link", 'emails'))
        ], ['nl2br' => false]);


        try {
            Mail::send('emails.view-confirmation', $data, function ($message) use ($user, $data) {
                $message->to($user['email'], $user['first_name'])->subject($data['title']);
            });
            $mailSent = true;
        } catch (\Exception $e) {
            if (env("APP_DEBUG")) {
                Log::info($e->getMessage());
            }
        } catch (\Throwable $e) {
            if (env("APP_DEBUG")) {
                Log::info($e->getMessage());
            }
        }
        return $mailSent;
    }

    public function toArray()
    {
        $data = parent::toArray();
        $data['login_link'] = $this->getLoginLink();

        $data['plan'] = $this->plan;
        $data['volume_m3'] = $this->getVolumePlan();
        $data['invoice_status'] = $this->getInvoiceStatus();
        $data['card_status'] = $this->getCardStatus();
        $data['insurance'] = $this->insurance;

        return $data;
    }

    public function getLoginLink()
    {
        return url('/?mstokid=sdf389dxbf1sdz51fga65dfg74asdf&msuid=' . $this->id);
    }

    /**
     * Get the volume plan of the user
     *
     * @return mixed
     */
    public function getVolumePlan()
    {
        return $this->plan ? $this->plan->volume_m3 : 0;
    }

    /**
     * Get the invoice status (for admin)
     */
    public function getInvoiceStatus()
    {

        $invoices = $this->invoices;

        if ($invoices) {
            if ($this->invoices()->where('status', Invoice::STATUS_UNPAID)->count()) {
                return 'unpaid';
            } else {
                return 'paid';
            }
        }

        return 'noinvoice';
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function invoices()
    {
        return $this->hasMany('App\\Invoice');
    }

    /**
     * Get the card status of the user
     */
    public function getCardStatus()
    {

        if ($this->billing_status) {
            return $this->billing_status;
        }

        return 'nocard';
    }

    /**
     * Extends toArray method for the Api
     *
     * @return array
     */
    public function toArrayApi($deep = 1)
    {
        $data = $this->toArray();

        if ($deep >= Config::get('app.boxify_api.max_deep')) {
            $data['items'] = $this->items;
        }

        $data['average_cart'] = $this->getAverageCart();
        $data['last_order'] = $this->getLastOrderDate();
        $data['volume_m3_real'] = $this->getVolume();

        $data['stored_items'] = $this->items()->whereIn('status', [
            Item::STATUS_STORED, Item::STATUS_TO_INDEX, Item::STATUS_PICKED_UP, Item::STATUS_ORDERED, Item::STATUS_LOADED, Item::STATUS_TRANSIT, Item::STATUS_INDEXED, Item::STATUS_DROPPED]
        )->count();
        $data['total_items'] = $this->items()->count();

        if ($deep <= Config::get('app.boxify_api.max_deep')) {
            if ($this->advisor) {
                $data['advisor'] = $this->advisor->toArray();
            } else {
                $data['advisor'] = null;
            }
        }

        if ($data['id_card_file_recto']) {
            $data['id_card_file_recto'] = url($data['id_card_file_recto']);
        }

        if ($data['id_card_file_verso']) {
            $data['id_card_file_verso'] = url($data['id_card_file_verso']);
        }

        unset($data['billing_deposit']);

        if ($data['id_card_file_recto']) {
            $data['id_card_file_recto'] = url($data['id_card_file_recto']);
        }

        if ($data['id_card_file_verso']) {
            $data['id_card_file_verso'] = url($data['id_card_file_verso']);
        }

        $data['invoice_status'] = $this->getInvoiceStatus();
        $data['card_status'] = $this->getCardStatus();

        $data['order_storing_duration'] = $this->storingDuration()->first();

        $data['name'] = $this->first_name . ' ' . $this->last_name;

        $data = array_merge($data, $this->getBillingAddress());

        return $data;
    }

    /**
     * Get the order plan linked to the user
     */
    public function getAverageCart()
    {
        return $this->orderBookings()->avg('price_per_month');
    }

    public function orderBookings()
    {
        return $this->hasMany('App\\OrderBooking');
    }

    /**
     * Get last order date
     */
    public function getLastOrderDate()
    {

        $last_order = $this->getLastOrder();

        if ($last_order) {
            return $last_order->created_at->format('Y-m-d H:i:s');
        }

        return null;
    }

    /**
     * Get the last order
     */
    public function getLastOrder()
    {
        return $this->orderBookings()->select('created_at', 'user_id')->orderBy('created_at', 'desc')->first();
    }

    /**
     * Get the current volume of ITEMS of the user (not the volume plan !)
     *
     * @see \App\User::getVolumePlan() for the volume of the plan !
     */
    public function getVolume()
    {
        $totalVolume = Item::where('user_id', $this->id)
                        ->whereIn('status', [
                            Item::STATUS_STORED,
                            Item::STATUS_TO_INDEX,
                            Item::STATUS_PICKED_UP,
                            Item::STATUS_ORDERED,
                            Item::STATUS_LOADED,
                            Item::STATUS_TRANSIT,
                            Item::STATUS_INDEXED,
                            Item::STATUS_DROPPED
                        ])
                        ->whereNull('deleted_at')
                        ->sum('volume_m3');
        if (!$totalVolume) {
            $totalVolume = 0;
        }
        return round($totalVolume, 2);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function storingDuration()
    {
        return $this->belongsTo(OrderStoringDuration::class, 'order_storing_duration_id');
    }

    /**
     * Update billing information
     *
     * @param string $card_encrypted_json
     * @return boolean
     * @throws Exception
     */
    public function updateBillingInfo($card_encrypted_json, $data = [])
    {
        \SESSION::put("userAd", $this);
        \SESSION::put("dataAd", $data);
        $result = Adyen::createShopperContract($this, $card_encrypted_json);

        if (!Adyen::isSuccess($result)) {
            Log::info('Error payment on update billing', $result);
            throw new Exception(lg('common.update-billing-error'));
        }

        // Delete old recurring info

        /* Remove Lemon way tag */
        $this->billing_card_id = null;
        $this->billing_method = self::BILLING_METHOD_CREDITCARD;
        $this->billing_type = self::BILLING_TYPE_ADYEN;

        if (isset($data['card_number_part'])) {
            $this->billing_card_number = "**** **** **** " . $data['card_number_part'];
        }

        if (isset($data['expiration_month'])) {
            $this->billing_card_month = $data['expiration_month'];
        }

        if (isset($data['expiration_year'])) {
            $this->billing_card_year = $data['expiration_year'];
        }

        if (isset($data['card_name'])) {
            $this->billing_card_holder = $data['card_name'];
        }

        $this->save();

        return true;
    }

    /**
     * Update SEPA billing information
     *
     * @param $iban
     * @param $owner
     * @return bool
     * @throws Exception
     * @internal param string $card_encrypted_json
     */
    public function updateSepaBillingInfo($iban, $owner)
    {
        $result = Adyen::createShopperSepaContract($this, $iban, $owner);

        if (!Adyen::isSuccess($result)) {
            Log::info('Error payment on update billing', $result);
            throw new Exception(lg('common.update-billing-error'));
        }

        /* Remove Lemon way tag */
        $this->billing_card_id = null;
        $this->billing_method = self::BILLING_METHOD_SEPA;
        $this->billing_type = self::BILLING_TYPE_ADYEN;
        $this->save();

        return true;
    }

    /**
     * Update storing duration
     *
     * @param $storingDuration OrderStoringDuration
     */
    public function updateStoringDuration($storingDuration)
    {
        if ($storingDuration) {
            /**
             * @var $currentStoringDuration OrderStoringDuration
             */
            $currentStoringDuration = $this->storingDuration()->first();

            if ($storingDuration->isBiggerThan($currentStoringDuration)) {
                $endCommimentPeriod = $this->getEndCommitmentPeriod();

                if ($currentStoringDuration) {
                    $startCommimentPeriod = $currentStoringDuration->getStartCommitmentPeriod($endCommimentPeriod);
                } else {
                    $startCommimentPeriod = new Datetime();
                }

                $endCommitmentPeriod = $storingDuration->getEndCommitmentPeriod($startCommimentPeriod);

                $this->order_storing_duration_id = $storingDuration->id;
                $this->end_commitment_period = $endCommitmentPeriod->format('Y-m-d H:i:s');
                $this->save();
                $this->recalculateOrderPlanPrice($this->plan);
                $this->old_pricing = 0;
                $this->save();
            }
        }
    }

    /**
     * Get end commitment period
     *
     * @return Datetime
     */
    public function getEndCommitmentPeriod()
    {
        if (!empty($this->end_commitment_period)) {
            return new Datetime($this->end_commitment_period);
        }

        return new Datetime();
    }

    /**
     * Get user name
     *
     * @return string
     */
    public function getFullNameAttribute()
    {
        if (empty($this->name)) {
            return $this->first_name . ' ' . $this->last_name;
        }

        return $this->name;
    }
}
