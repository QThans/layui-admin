<?php

namespace thans\layuiAdmin\Traits;

use thans\layuiAdmin\facade\AdminsAuth;
use think\Request;

trait FormActions
{
    public function edit($id, Request $request)
    {
        $url = $request->controller() ? url($request->module().'/'
            .$request->controller().'/update', 'id='.$id)
            : url(get_class($this).'/update', 'id='.$id);
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
        $url = $request->controller() ? url($request->module().'/'
            .$request->controller().'/save') : url(get_class($this).'/save');

        return $this->buildForm()->hiddenSubmit(
            ! AdminsAuth::check($url, 'put')
        )->url($url)->render();
    }
}
