<?php

namespace App\Providers;

use Laravel\Passport\Passport;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

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
        Passport::routes();
        Gate::define('validate-like', function($user, $likes) {

            $isUserLiked = false;
            foreach($likes as $like) {

                if ($like->user->id == $user->id) {
                    $isUserLiked = true;
                    break;
                }
            }
            return $isUserLiked;
        });

        //
    }
}
