<?php

namespace App\Providers;

use Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use App\User;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('is-agent', function (User $user) {

            if ($user->role > 1) return TRUE;
            return FALSE;
        });

        Gate::define('is-admin', function (User $user) {

            if ($user->role == 10) return TRUE;
            return FALSE;
        });

        //
    }
}
