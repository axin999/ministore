<?php

namespace App\Providers;

use Laravel\Passport\Passport;
use Illuminate\Support\Facades\Gate;
//use Illuminate\Contracts\Auth\Access\Gate as GateContract;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

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

        Gate::define('isAdmin', function($user){
            return $user->type === 'admin';
        });
        Gate::define('isUser', function($user){
            return $user->type == 'user';
        });

        Gate::define('isOwner', function($user){
            return $user->type == 'owner';
        });

        Gate::define('isMyAccount', function($user, $profileUser){
            return $user->id === $profileUser->id;
        });

        Passport::routes();

        //
    }
}
