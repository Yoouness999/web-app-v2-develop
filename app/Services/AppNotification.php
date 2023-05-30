<?php

namespace App\Services;

use App\Notifications\SlackNotification;
use Illuminate\Notifications\Messages\SlackMessage;
use Illuminate\Support\Facades\Notification;

class AppNotification
{

    private string $slackUrl;

    public function __construct(string $slackUrl)
    {
        $this->slackUrl = $slackUrl;
    }


    public function sendToSlack($content, $attachments = [], $level = 'info')
    {
        $slackMessage = new SlackMessage();
        $slackMessage->level = $level;
        $slackMessage->content = $content;

        if ($attachments && sizeof($attachments) > 0) {
            foreach ($attachments as $attachment) {
                $slackMessage->attachment(function ($slackAttachment) use ($attachment) {
                    $slackAttachment->title($attachment['title'])
                                    ->fields($attachment['data']);

                    if (array_key_exists('color', $attachment)) {
                        $slackAttachment->color($attachment['color']);
                    }
                });
            }
        }

        Notification::route('slack', $this->slackUrl)->notify(new SlackNotification($slackMessage));
    }
}
