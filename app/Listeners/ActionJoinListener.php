<?php

namespace App\Listeners;

use App\Entities\Activity;
use App\Events\ActionJoin;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class ActionJoinListener
{
    public function handle(ActionJoin $event)
    {
        $event->user->activities()->create([
            'type' => Activity::ACTION_JOIN,
            'info' => [
                'action_id' => $event->action->id,
                'action_name' => $event->action->name,
            ],
        ]);
    }
}
