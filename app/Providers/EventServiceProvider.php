<?php namespace App\Providers;

use App\Events\ItemUpdate;
use App\Events\ItemUpdatedEvent;
use App\Handlers\Events\ItemUpdatedHandler;
use App\Handlers\Events\ItemUpdateHandler;
use App\Handlers\Events\LogHandler;
use App\Item;
use App\User;
use Illuminate\Contracts\Events\Dispatcher as DispatcherContract;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider {

	/**
	 * The event handler mappings for the application.
	 *
	 * @var array
	 */
	protected $listen = [
		ItemUpdate::class => [
			ItemUpdateHandler::class
		],
        'App\Events\ItemUpdatedEvent' => [
            'App\Handlers\Events\ItemUpdatedHandler',
        ],
		'App\Events\ItemDeleted' => [
			'App\Handlers\Events\ItemDeletedHandler',
		],
		'App\Events\ItemDepositEvent' => [
			'App\Handlers\Events\ItemDepositdHandler',
		],
		'App\Events\ItemPickupAskEvent' => [
			'App\Handlers\Events\ItemPickupAskHandler',
		],
		'App\Events\PaymentSuccessEvent' => [
			'App\Handlers\Events\PaymentSuccessHandler',
		],
		'App\Events\PaymentErrorEvent' => [
			'App\Handlers\Events\PaymentErrorHandler',
		],
		'App\Events\DisputeBeginEvent' => [
			'App\Handlers\Events\DisputeBeginHandler',
		],
		'App\Events\DisputeEndEvent' => [
			'App\Handlers\Events\DisputeEndHandler',
		],
		'App\Events\ContactHelpdeskEvent' => [
			'App\Handlers\Events\ContactHelpdeskHandler',
		],
		'App\Events\CustomerDepositByTransporterEvent' => [
			'App\Handlers\Events\CustomerDepositByTransporterHandler',
		],
		'App\Events\CustomerPickupByTransporterEvent' => [
			'App\Handlers\Events\CustomerPickupByTransporterHandler',
		],
		'App\Events\WarehouseDepositByTransporterEvent' => [
			'App\Handlers\Events\WarehouseDepositByTransporterHandler',
		],
		'App\Events\WarehousePickupByTransporterEvent' => [
			'App\Handlers\Events\WarehousePickupByTransporterHandler',
		],
		'App\Events\PickupConfirmationEvent' => [
			'App\Handlers\Events\PickupConfirmationHandler',
		],
		'App\Events\PickupUpdateEvent' => [
			'App\Handlers\Events\PickupUpdateHandler',
		],
        'App\Events\MonthlyUserInvoiceEvent' => [
            'App\Handlers\Events\MonthlyUserInvoiceHandler',
        ],
        'App\Events\PaymentAttemptEvent' => [
            'App\Handlers\Events\PaymentAttemptHandler',
        ],
        'App\Events\AdyenNotificationEvent' => [
            'App\Handlers\Events\AdyenNotificationHandler',
        ],
        'App\Events\PaymentErrorNotificationEvent' => [
            'App\Handlers\Events\PaymentErrorNotificationHandler',
        ],
        'App\Events\PaymentSuccessNotificationEvent' => [
            'App\Handlers\Events\PaymentSuccessNotificationHandler',
        ],
        'App\Events\PickupCancelEvent' => [
            'App\Handlers\Events\PickupCancelHandler',
        ],
        'App\Events\UserInviteFriendEvent' => [
            'App\Handlers\Events\UserInviteFriendHandler',
        ],
	];

	/**
	 * Register any other events for your application.
	 *
	 * @param \Illuminate\Contracts\Events\Dispatcher $events
	 * @return void
	 */
	public function boot()
	{
		parent::boot();

        User::created(function ($user) {
            /**
             * @var $user User
             */
            if (empty($user->invitation_code)) {
                $user->generateInviteCode();
            }

        });

        Item::saved(function ($item) {
            /**
             * @see ItemUpdatedHandler
             */
            event(new ItemUpdatedEvent($item));
        });
	}
}
