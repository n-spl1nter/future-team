<?php

namespace App\Providers;

use App\Entities\User;
use App\Policies\PermissionPolicy;
use App\Policies\UserPolicy;
use App\RBAC\Permission;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Laravel\Passport\Passport;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        Permission::class => PermissionPolicy::class,
        User::class => UserPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Passport::personalAccessTokensExpireIn(now()->addDays(30));
        Passport::tokensExpireIn(now()->addDays(30));
        Passport::refreshTokensExpireIn(now()->addDays(30));
    }
}
