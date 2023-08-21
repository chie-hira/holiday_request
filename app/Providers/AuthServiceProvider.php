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

        // 管理者だけ
        Gate::define('general_admin', function ($user) {
            return !empty(
                $user->approvals
                    ->where('approval_id', 1)
                    ->where('affiliation_id', 1)
                    ->first()
            );
        });

        // 管理者だけ
        Gate::define('admin', function ($user) {
            return !empty($user->approvals->where('approval_id', 1)->first());
        });

        // 工場長承認だけ
        Gate::define('approver', function ($user) {
            return !empty(
                $user->approvals->where('approval_id', 2)->first() ||
                    $user->approvals->where('approval_id', 3)->first()
            );
        });

        // 閲覧
        Gate::define('reader', function ($user) {
            return !empty($user->approvals->where('approval_id', 4)->first());
        });

        // 「承認」「閲覧」
        Gate::define('approver_reader', function ($user) {
            return !empty(
                $user->approvals->where('approval_id', '>=', 2)->first()
            );
        });
    }
}
