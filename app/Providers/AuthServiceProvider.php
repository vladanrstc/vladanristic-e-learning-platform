<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Laravel\Passport\Passport;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {

        $this->registerPolicies();

        Passport::tokensExpireIn(now()->addCentury(1));

        Passport::refreshTokensExpireIn(now()->addYear());

        Passport::ignoreCsrfToken(true);

        Passport::tokensCan([
            'admin'       => 'Can do anything',
            'user'        => 'Can\'t do everything',
            'super-admin' => 'Can\'t do anything+ ',
        ]);
    }
}
