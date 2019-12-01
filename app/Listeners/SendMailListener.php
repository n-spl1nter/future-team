<?php

namespace App\Listeners;

use App\Entities\Activity;
use App\Events\SendMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendMailListener
{

    /**
     * Handle the event.
     *
     * @param SendMail $event
     * @return void
     */
    public function handle(SendMail $event)
    {
        $event->message->userFrom->activities()->create([
            'type' => Activity::SEND_MESSAGE,
            'info' => [
                'userTo' => [
                    'id' => $event->message->userTo->id,
                    'name' => $event->message->userTo->getFullName(),
                ],
                'message' => $event->message->message,
            ],
        ]);
    }
}
