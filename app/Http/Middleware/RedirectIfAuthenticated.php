<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    // config\auth.phpのguard配列で定義されている
    private const GUARD_ADMIN = "admins";
    private const GUARD_OWNER = "owners";
    private const GUARD_USER  = "users";

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @param  string|null  ...$guards
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, ...$guards)
    {
        // 初期値
        // $guards = empty($guards) ? [null] : $guards;
        // foreach ($guards as $guard) {
        //   // 変数guard（例えばユーザーやオーナーなど）でログイン（check関数で判定）している場合
        //     if (Auth::guard($guard)->check()) {
        //         return redirect(RouteServiceProvider::HOME);
        //     }
        // }

        // 変数GUARD_USERでログイン（check関数で判定）しており、尚且つ、
        // user関連のページ（ログイン画面）にアクセス（routeIsメソッドを使用して、受信リクエストが名前付きルートに一致するかを判定）している場合
        if(Auth::guard(self::GUARD_USER)->check() && $request->routeIs("user.*")) {
            // app\Providers\RouteServiceProvider.phpの変数HOMEにリダイレクトする
            return redirect(RouteServiceProvider::HOME);
        }

        if(Auth::guard(self::GUARD_OWNER)->check() && $request->routeIs("onwer.*")) {
            return redirect(RouteServiceProvider::OWNER_HOME);
        }

        if(Auth::guard(self::GUARD_ADMIN)->check() && $request->routeIs("admin.*")) {
            return redirect(RouteServiceProvider::ADMIN_HOME);
        }

        return $next($request);
    }
}
