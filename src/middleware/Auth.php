<?php


namespace thans\layuiAdmin\middleware;


class Auth
{
    public function handle($request, \Closure $next)
    {
        $path = $request->path();



        return $next($request);
    }
}