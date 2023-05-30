<?php namespace App\Handlers\Events;

use App\Events\PickupConfirmationEvent;

use App\Log;
use App\Pickup;
use Mail;

class PickupConfirmationHandler
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
     * @param  PickupConfirmationEvent $event
     * @return void
     */
    public function handle(PickupConfirmationEvent $event)
    {
        /**
         * @var $pickup Pickup
         */
        $pickup = $event->pickup;
        $user = $event->user->toArray();

        $data = \DM()->getBySlug('mail/congratulation');

        $pickup_items_to_drop = array_filter(array_map(function ($item) {
            if($item['number'] != 0){
                return $item['number'] . ' x ' . $item['name'];
            } else {
                return false;
            }
        }, $pickup->items_to_drop));

        $pickup_items_to_pickup = array_filter(array_map(function ($item) {
            if($item['number'] != 0){
                return $item['number'] . ' x ' . $item['name'];
            } else {
                return false;
            }
        }, $pickup->items_to_pickup));

        $pickup_items_to_drop_html = '';
		$pickup_items_to_drop_html_admin = '';
        if (count($pickup_items_to_drop)) {
            $pickup_items_to_drop_html = '<p>' . lg("Here's what you asked us to drop off", 'common') . ':</p>';
			$pickup_items_to_drop_html_admin .= \HTML::ul($pickup_items_to_drop);
            $pickup_items_to_drop_html .= \HTML::ul($pickup_items_to_drop);
        }

        $pickup_items_to_pickup_html = '';
		$pickup_items_to_pickup_html_admin = '';

        if (count($pickup_items_to_pickup)) {
            $pickup_items_to_pickup_html = '<p>' . lg("Here's what you asked us to pick up", 'common') . ':</p>';
			$pickup_items_to_pickup_html_admin .= \HTML::ul($pickup_items_to_pickup);
            $pickup_items_to_pickup_html .= \HTML::ul($pickup_items_to_pickup);
        }

        $dataToBind = [
            'user' => $user,
			//'pickup' => array_only(collect($pickup->toArray())->toArray(), $pickup->getFillable()),
            'pickup_date' => date('d/m/Y H:i', strtotime($pickup->pickup_date)) . ' - ' . (date('H', strtotime($pickup->pickup_date)) + 2) . ':00',
            'pickup_address' => $pickup->address,
            'url' => ROOT_URL,
            'pickup_items_to_drop_off' => $pickup_items_to_drop_html,
            'pickup_items_to_pickup' => $pickup_items_to_pickup_html,
			'pickup_items_to_drop_admin' => $pickup_items_to_drop_html_admin,
            'pickup_items_to_pickup_admin' => $pickup_items_to_pickup_html_admin
        ];

        $data['title'] = strip_tags(shortcode($data['title'], $dataToBind, ['nl2br' => false]));
        $data['content'] = shortcode($data['content'], $dataToBind, ['nl2br' => false]);

		// For test env
		if (LEVEL_ENV <= 2) {
			$data['title'] .= ' [to=' . $user['email'] . ', bcc=order@boxify.be]';
			$to = REDIRECT_EMAIL;
			$bcc = REDIRECT_EMAIL;
		} else {
			$to = $user['email'];
			$bcc = 'order@boxify.be';
		}

        try {
            // Send
            Mail::send('emails.view', $data, function ($message) use ($user, $data, $to, $bcc) {
                $message->to($to, $user['first_name'])->bcc($bcc)->subject($data['title']);
            });

            /*
             * Email for admin
             */
            $data = \DM()->getBySlug('mail/congratulation');

            $data['title'] = strip_tags(shortcode($data['title'], $dataToBind, ['nl2br' => false]));
            $data['content'] = shortcode($data['content'], $dataToBind, ['nl2br' => false]);

            // For test env
            if (LEVEL_ENV <= 2) {
                $data['title'] .= ' [to=backup@boxify.be]';
                $to = REDIRECT_EMAIL;
            } else {
                $to = 'backup@boxify.be';
            }

            // Send
            Mail::send('emails.view', $data, function ($message) use ($data, $to) {
                $message->to($to)->subject($data['title']);
            });
        } catch (\Exception $e) {
            \Log::info($e->getMessage());
        } catch (\Throwable $e) {
            \Log::info("error mail");
        }
    }
}
