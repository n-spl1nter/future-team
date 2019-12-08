<?php

namespace App\Console\Commands\Notifications;

use App\Entities\Action;
use App\Notifications\ActionEndNotification;
use Illuminate\Console\Command;

class ActionEndNotify extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'action-end:notify';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Оповещение о завершении акции';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $actions = Action::active()
            ->where('end_at', '<', now())
            ->whereNull('notified_about_ending_at')
            ->get();

        /** @var Action $action */
        foreach ($actions as $action) {
            $action->user->notify(new ActionEndNotification($action));
            $action->notified_about_ending_at = now();
            $action->save();
        }
    }
}
