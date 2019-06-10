<?php

namespace thans\layuiAdmin\Traits;

use thans\layuiAdmin\facade\Auth;
use think\Request;

trait FormActions
{
    public function edit($id)
    {
        return $this->buildForm()->edit($id)->hiddenSubmit(
            !Auth::check(url(get_class($this).'/update'), 'put')
        )->url(
            url(get_class($this).'/update', 'id='.$id)
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

    public function create()
    {
        return $this->buildForm()->hiddenSubmit(
            !Auth::check(url(get_class($this).'/update'), 'put')
        )->url(url(get_class($this).'/save'))->render();
    }
}
