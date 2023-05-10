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
            return !empty(
                $user->approvals->where('approval_id', 5)->first()
            );
        });

        // 会社承諾だけ
        Gate::define('general_only', function ($user) {
            return !empty(
                $user->approvals->where('approval_id', 1)->first()
            );
        });

        // 閲覧
        Gate::define('reader', function ($user) {
            return !empty(
                $user->approvals->where('approval_id', 4)->first()
            );
        });

        // 会社承諾と工場承諾に適用
        Gate::define('general_and_factory', function ($user) {
            return !empty(
                $user->approvals->where('approval_id', '=', 1)->first()
            ) ||
                !empty($user->approvals->where('approval_id', '=', 2)->first());
        });

        // 会社承諾と工場承諾とGL承諾に適用
        Gate::define('general_and_factory_gl', function ($user) {
            return !empty(
                $user->approvals->where('approval_id', '=', 1)->first()
            ) ||
                !empty(
                    $user->approvals->where('approval_id', '=', 2)->first()
                ) ||
                !empty($user->approvals->where('approval_id', '=', 3)->first());
        });

        // 会社承諾,工場承諾,GL承諾,閲覧に適用
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
