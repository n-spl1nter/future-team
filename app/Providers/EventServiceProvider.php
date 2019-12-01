<?php

namespace App\Providers;

use App\Events\ActionCreate;
use App\Events\ActionJoin;
use App\Events\EventCreate;
use App\Listeners\ActionCreateListener;
use App\Listeners\ActionJoinListener;
use App\Listeners\EventCreateListener;
use App\Listeners\RegistrationListener;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            RegistrationListener::class,
        ],
        \SocialiteProviders\Manager\SocialiteWasCalled::class => [
            'SocialiteProviders\VKontakte\VKontakteExtendSocialite@handle',
        ],
        ActionCreate::class => [
            ActionCreateListener::class,
        ],
        ActionJoin::class => [
            ActionJoinListener::class,
        ],
        EventCreate::class => [
            EventCreateListener::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();
    }
}
