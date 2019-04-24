<?php


namespace thans\layuiAdmin\middleware;


use thans\layuiAdmin\facade\Jump;

class Auth
{
    public function handle($request, \Closure $next)
    {
        $path = $request->path();
        $check = \thans\layuiAdmin\facade\Auth::check($path);
        if (!$check) {
            Jump::result('没有权限', 'close', '您可以刷新重试或返回上一页，亦可联系我们');
        }
        return $next($request);
    }
}