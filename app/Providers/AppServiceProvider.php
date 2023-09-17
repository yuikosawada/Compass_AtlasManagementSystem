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

        // ルール追加：2000年以降の有効な日付
        Validator::extend('valid_date_range', function ($attribute, $value, $parameters, $validator) {
            return preg_match('/^(\d{4})/', $value, $matches) && $matches[1] >= 2000;
            //     // 2000年1月1日以降の日付かどうかを検証します
        //     if ($value < 2000) {
        //         return false;
        //     }
        //     // 日付が有効かどうかを確認します
        //     if (!$value->isValid()) {
        //         return false;
        //     }
        //     // return true;
        //         return preg_match('< 2000', $value);
        // return $value <= 2000;
   
    
    });
        
       
        
    }


}