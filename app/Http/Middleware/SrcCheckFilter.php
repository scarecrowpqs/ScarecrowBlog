<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class SrcCheckFilter
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
        //TODO::资源请求来源检测
        $hostList = $this->getAllGetSrcList();
        $requestHost = $request->getHost();
        if (in_array($requestHost, $hostList)) {
            return $next($request);
        } else {
            return abort(403, '<*_*!>你请求的资源走丢了......');
        }
    }

    /**
     * 获取允许访问的域名列表
     * @return array
     */
    private function getAllGetSrcList() {
        $str = config('app.customConfig.allGetSrcHostList');
        $hostList = explode(',', $str);
        return $hostList;
    }
}
