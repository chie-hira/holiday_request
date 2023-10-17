<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Validation\Rules\Password;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Password::defaults(
            fn() => Password::min(5) # 5文字以上
                // ->mixedCase() # 大文字小文字
                ->numbers()
        ); # 数字

        // 以下に新しいカスタムバリデーションルールを追加
        Validator::extend('current_password_original', function (
            $attribute,
            $value,
            $parameters,
            $validator
        ) {
            // dd($parameters);
            $user = User::find($parameters[0]); // ユーザーIDからユーザーを取得
            // dd($user);
            if (!$user) {
                return false; // ユーザーが存在しない場合はバリデーションエラー
            }

            if (!Hash::check($value, $user->password)) {
                return false; // パスワードが一致しない場合はバリデーションエラー
            }

            return true; // パスワードが一致した場合はバリデーション成功
        });
    }
}
