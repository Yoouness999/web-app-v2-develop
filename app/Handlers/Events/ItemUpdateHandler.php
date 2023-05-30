<?php namespace App\Handlers\Events;

use App\Api;
use App\Events\ItemUpdate;

use App\Invoice;
use App\Item;
use DateTime;
use Lang;
use Log;

class ItemUpdateHandler
{

    /**
     * Create the event handler.
     *
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param ItemUpdate $event
     */
    public function handle(ItemUpdate $event)
    {

    }
}
