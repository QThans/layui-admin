<?php


namespace thans\layuiAdmin\middleware;


use thans\layuiAdmin\facade\Json;
use thans\layuiAdmin\facade\Jump;

class Auth
{
    public function handle($request, \Closure $next, $auth = true)
    {
        $isAdmin = \thans\layuiAdmin\facade\Auth::isAdmin();
        if (!$isAdmin) {
            if (!$request->isAjax()) {
                Jump::result('没有权限', 'close', '您可以刷新重试或返回上一页，亦可联系我们');
            } else {
                Json::error("没有权限");
            }
        }
        if ($auth === false) {
            return $next($request);
        }
        $path = $request->path();
        $check = \thans\layuiAdmin\facade\Auth::check($path);
        if (!$check) {
            if (!$request->isAjax()) {
                Jump::result('没有权限', 'close', '您可以刷新重试或返回上一页，亦可联系我们');
            } else {
                Json::error("没有权限");
            }
        }
        return $next($request);
    }
}