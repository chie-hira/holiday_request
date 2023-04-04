<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
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

        // 「総務部長」だけに適用
        Gate::define('general_only', function ($user) {
            return ($user->approval_id == 1);
        });

        // 「総務部長」と「工場長」に適用
        Gate::define('general_and_factory', function ($user) {
            return ($user->approval_id <= 2 && $user->approval_id != null);
        });

        // 「総務部長」と「工場長」と「GL」全てに適用
        Gate::define('general_and_factory_gl', function ($user) {
            return ($user->approval_id <= 3 && $user->approval_id != null);
        });
    }
}
