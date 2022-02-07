<?php

namespace App\Providers;

use App\Models\Centro;
use App\Policies\CentroPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Centro::class => CentroPolicy::class,
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

        Gate::define('check-language', function($user, $locale){

            if (! in_array($locale, ['en', 'es'])) {
                abort(404);
            }

            App::setLocale($locale);

            return true;
        });
    }
}
