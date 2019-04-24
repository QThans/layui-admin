<?php


namespace thans\layuiAdmin\middleware;


class Login
{
    public function handle($request, \Closure $next)
    {
        $path = $request->path();

        $check = \thans\layuiAdmin\facade\Auth::isLogin('/' . $path);

        if (!$check) {
            session('error_msg', "请先登录系统");
            return redirect(url('thans\layuiAdmin\controller\Login@index'));
        }

        return $next($request);
    }
}