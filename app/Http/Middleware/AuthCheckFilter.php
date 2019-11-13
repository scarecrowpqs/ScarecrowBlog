<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use function Scarecrow\checkLogin;

class AuthCheckFilter
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        //TODO::编写权限验证逻辑
        if (checkLogin()) {
            return $next($request);
        } else {
            if ($request->ajax()) {
                return response()->json([
                    'status'    =>  'NO',
                    'info'      =>  '无权限访问此接口'
                ]);
            } else {
                return redirect('/back/login');
            }
        }
    }
}
