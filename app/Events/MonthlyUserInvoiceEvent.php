<?php namespace App\Events;

use App\Events\Event;

use App\Handlers\Events\MonthlyUserInvoiceHandler;
use App\Invoice;
use App\Item;
use App\User;
use Illuminate\Queue\SerializesModels;
use Request;

/**
 *
 * @see MonthlyUserInvoiceHandler
 * @property bool confirm
 * @property null date
 * @property bool testmode
 * @property null fakePayment
 */
class MonthlyUserInvoiceEvent extends Event {

	use SerializesModels;

    /**
     * Montly user invoice event
     *
     * @param bool $confirm
     * @param null $date
     * @param bool $testmode
     * @param null $fakePayment
     * @internal param null $paymentContract
     */
	public function __construct($confirm = false, $date = null, $testmode = false, $fakePayment = null)
	{
	    $this->confirm = $confirm;
	    $this->date = $date;
	    $this->testmode = $testmode;
	    $this->fakePayment = $fakePayment;
	}
}
