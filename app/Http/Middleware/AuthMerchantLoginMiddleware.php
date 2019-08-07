<?php

namespace App\Http\Middleware;

use App\Models\Merchant;
use Closure;

class AuthMerchantLoginMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($request->isMethod('POST')) {
            $user_id = $request->input('user_id');
            $reqaccess_token = $request->input('access_token');
        } else {
            $user_id = $_COOKIE['user_id'];
            $reqaccess_token = $_COOKIE['access_token'];
        }
        if ($access_token = Merchant::where(['merchant_id'=>$user_id])->value('access_token')) {
            if ($access_token == $reqaccess_token) {
                // 在这里可以定制你想要的返回格式, 亦或者是 JSON 编码格式
                return $next($request);
            }
            if ($request->isMethod('POST')) {
                return api_error(20001);
            } else {
                return redirect('/');
            }
        }
        if ($request->isMethod('POST')) {
            return api_error(20001);
        } else {
            return redirect('/');
        }
    }
}
