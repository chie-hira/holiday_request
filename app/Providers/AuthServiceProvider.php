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
        Gate::define('admin_only', function ($user) {
            return !empty($user->approvals->where('approval_id', 5)->first());
        });

        // 会社承認だけ
        Gate::define('general_only', function ($user) {
            return !empty($user->approvals->where('approval_id', 1)->first());
        });

        // 閲覧
        Gate::define('reader', function ($user) {
            return !empty($user->approvals->where('approval_id', 4)->first());
        });

        // 会社承認と工場承認に適用
        Gate::define('general_and_factory', function ($user) {
            return !empty(
                $user->approvals->where('approval_id', '=', 1)->first()
            ) ||
                !empty($user->approvals->where('approval_id', '=', 2)->first());
        });

        // 会社承認と工場承認とGL承認に適用
        Gate::define('general_and_factory_gl', function ($user) {
            return !empty(
                $user->approvals->where('approval_id', '=', 1)->first()
            ) ||
                !empty(
                    $user->approvals->where('approval_id', '=', 2)->first()
                ) ||
                !empty($user->approvals->where('approval_id', '=', 3)->first());
        });

        // 会社承認,工場承認,GL承認,閲覧に適用
        Gate::define('general_factory_gl_reader', function ($user) {
            return !empty(
                $user->approvals->where('approval_id', '<=', 4)->first()
            );
        });

        // 権限なしに適用
        Gate::define('no_approvals', function ($user) {
            return empty($user->approvals->first());
        });
    }
}
