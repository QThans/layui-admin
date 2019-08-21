<?php

namespace thans\layuiAdmin\middleware;

class Login
{
    public function handle($request, \Closure $next)
    {
        $check = \thans\layuiAdmin\facade\AdminsAuth::id();

        if (! $check) {
            session('error_msg', '请先登录系统');

            return redirect(url('thans\layuiAdmin\controller\Login@index'));
        }

        return $next($request);
    }
}
