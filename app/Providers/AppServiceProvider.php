<?php

namespace App\Providers;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

use Illuminate\Support\Facades\Validator; // 追加


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
        $this->registerPolicies();
        Gate::define('admin', function($user){
            return ($user->role == "1" || $user->role == "2" || $user->role == "3");
        });

        //ルール追加；カタカナバリデーション
        Validator::extend('katakana', function ($attribute, $value, $parameters, $validator) {
            return preg_match('/^[ァ-ヾー]+$/u', $value); // 正規表現でカタカナのみマッチさせている
        });
    }


}