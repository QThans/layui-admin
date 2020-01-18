<?php

namespace thans\layuiAdmin\middleware;

use thans\layuiAdmin\facade\Json;
use thans\layuiAdmin\facade\Jump;

class AdminsAuth
{
    public function handle($request, \Closure $next)
    {
        $path = $request->pathinfo();
        $check = \thans\layuiAdmin\facade\AdminsAuth::check($path);
        if (!$check) {
            if (!$request->isAjax()) {
                Jump::result('没有权限', 'close', '您可以刷新重试或返回上一页，亦可联系我们');
            } else {
                Json::error('没有权限');
            }
        }

        return $next($request);
    }
}
