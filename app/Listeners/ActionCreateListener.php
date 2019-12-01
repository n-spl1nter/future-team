<?php

namespace App\Listeners;

use App\Entities\Activity;
use App\Events\ActionCreate;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class ActionCreateListener
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
     * @param ActionCreate $event
     * @return void
     */
    public function handle(ActionCreate $event)
    {
        $event->action->user->activities()->create([
            'type' => Activity::ACTION_ADD,
            'info' => [
                'event_id' => $event->action->id,
                'event_name' => $event->action->name,
            ],
        ]);
    }
}
