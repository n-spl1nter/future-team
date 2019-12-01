<?php

namespace App\Listeners;

use App\Entities\Activity;
use App\Events\EventCreate;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class EventCreateListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param EventCreate $event
     * @return void
     */
    public function handle(EventCreate $event)
    {
        $event->eventEntity->user->activities()->create([
            'type' => Activity::EVENT_ADD,
            'info' => [
                'event_id' => $event->eventEntity->id,
                'event_name' => $event->eventEntity->name,
            ],
        ]);
    }
}
