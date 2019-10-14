<?php

namespace thans\layuiAdmin\Traits;

use thans\layuiAdmin\facade\AdminsAuth;
use think\Request;

trait FormActions
{
    protected $route = true;

    public function edit($id, Request $request)
    {
        $url = $this->buildUrl($request, 'update', ['id' => $id]);

        return $this->buildForm()->edit($id)->hiddenSubmit(
            ! AdminsAuth::check($url, 'put')
        )->url(
            $url
        )->render();
    }

    public function update($id, Request $request)
    {
        $this->buildForm()->update($id, $request->param());
    }

    public function save(Request $request)
    {
        $this->buildForm()->save($request->param());
    }

    public function delete($id)
    {
        $this->buildForm()->destroy($id);
    }

    public function create(Request $request)
    {
        $url = $this->buildUrl($request, 'save');

        return $this->buildForm()->hiddenSubmit(
            ! AdminsAuth::check($url, 'post')
        )->url($url)->render();
    }

    public function buildUrl(Request $request, $method, array $param = [])
    {
        if (property_exists($this, $method.'Url')) {
            $method .= 'Url';
            $url    = $this->$method;
            foreach ($param as $k => $v) {
                $url = str_replace('$'.$k, $v, $url);
            }

            return $url;
        }

        return $request->controller() && $this->route ? url($request->controller().'/'.$method, $param)
            : url(get_called_class().'/'.$method, $param);
    }
}
