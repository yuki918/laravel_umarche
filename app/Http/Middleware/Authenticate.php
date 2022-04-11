<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Support\Facades\Route;

class Authenticate extends Middleware
{
    // app\Providers\RouteServiceProvider.phpのboot関数で設定したルーティング
    protected $admin_route = "admin.login";
    protected $owner_route = "owner.login";
    protected $user_route = "user.login";

    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        if (! $request->expectsJson()) {
            // 初期値
            // return route('login');
            // 未ログイン時にオーナー関連のページにアクセスした場合、ログイン画面に遷移する
            if(Route::is("admin.*")) {
                return route($this->admin_route);
            } elseif(Route::is("owner.*")) {
                return route($this->owner_route);
            } else {
                return route($this->user_route);
            }
        }
    }
}
