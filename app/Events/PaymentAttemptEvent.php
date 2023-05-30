<?php namespace App\Events;

use App\Events\Event;

use App\Handlers\Events\PaymentAttemptHandler;
use Illuminate\Queue\SerializesModels;

/**
 * @see PaymentAttemptHandler
 */
class PaymentAttemptEvent extends Event {

	use SerializesModels;
    public $mockPayment;
    public $confirm;
    public $date;
    public $testmode;
    public  $user;

    /**
     * @var null
     */
    public $all;

    /**
     * Create a new event instance.
     *
     * @param $user
     * @param bool $testMode
     * @param bool $confirm
     * @param null $date
     * @param null $mockPayment
     * @param null $all
     */
	public function __construct($user, $testMode = true, $confirm = false, $date = null, $mockPayment = null, $all = null)
	{
	    $this->testmode = $testMode;
	    $this->user = $user;
		$this->date = $date;
		$this->confirm = $confirm;
		$this->mockPayment = $mockPayment;
        $this->all = $all;
    }

    /**
     * @return bool
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param bool $user
     */
    public function setUser($user)
    {
        $this->user = $user;
    }
}
