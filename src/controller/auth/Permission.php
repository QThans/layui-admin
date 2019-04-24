<?php


namespace thans\layuiAdmin\controller\auth;


use thans\layuiAdmin\facade\Auth;
use thans\layuiAdmin\facade\Json;
use thans\layuiAdmin\facade\Utils;
use thans\layuiAdmin\Form;
use thans\layuiAdmin\model\AuthPermission;
use thans\layuiAdmin\Table;
use think\Exception;
use think\Request;

class Permission
{
    public function index(Request $request)
    {
        if ($request->isAjax()) {
            list($where, $order, $page, $limit) = Utils::buildParams('name|alias|path');
            $permission = AuthPermission::where($where)->order($order);
            $list = $permission->page($page)->limit($limit)->select();
            $total = $permission->count();
            Json::success('获取成功', $list, 200, ['total' => $total]);
        }
        $tb = new Table();
        $tb->title('权限列表');
        $tb->url(url('thans\layuiAdmin\controller\auth\Permission/index'));


        $tb->column('id', 'ID');

        $tb->column('name', '权限名称');
        $tb->column('alias', '权限别名', 250);
        $tb->column('http_method', 'HTTP Method', 250);
        $tb->column('path', '网址', 300);
        $url = url('thans\layuiAdmin\controller\auth\Permission/edit', 'id={{ d.id }}');
        if (Auth::check($url)) {
            $tb->tool('编辑', $url, 'formLayer');
        }
        $url = url('thans\layuiAdmin\controller\auth\Permission/delete', 'id={{ d.id }}');
        if (Auth::check($url, 'DELETE')) {
            $tb->tool('删除', $url, 'confirmAjax', 'danger', 'DELETE', 'd.id != 1');
        }
        $url = url('thans\layuiAdmin\controller\auth\Permission/create');
        if (Auth::check($url)) {
            $tb->action('新增权限', $url);
        }
        return $tb->render();
    }

    public function create()
    {
        return $this->buildForm(url('thans\layuiAdmin\controller\auth\Permission/save'));
    }

    public function save(Request $request)
    {
        $data = $request->param();
        try {
            $validate = new \thans\layuiAdmin\validate\Permission();

            if (!$validate->check($data)) {
                Json::error($validate->getError());
            }
            $permission = new AuthPermission();
            $permission->allowField(true)->save($data);
            Json::success('保存成功');
        } catch (Exception $e) {
            Json::error($e->getMessage(), 500);
        }
    }

    public function edit($id)
    {
        $permission = AuthPermission::get($id);
        return $this->buildForm(url('thans\layuiAdmin\controller\auth\Permission/update', 'id=' . $id), 'PUT', $permission);
    }

    public function update($id, Request $request)
    {
        $data = $request->param();
        try {
            $validate = new \thans\layuiAdmin\validate\Permission();

            if (!$validate->check($data)) {
                Json::error($validate->getError());
            }
            $permission = new AuthPermission();
            $permission = $permission->get($id);
            $permission->allowField(true)->save($data);
            Json::success('更新成功');
        } catch (Exception $e) {
            Json::error($e->getMessage(), 500);
        }
    }

    public function delete($id)
    {
        if ($id === 1) {
            Json::error("无法删除默认数据");
        }
        AuthPermission::destroy($id);
        Json::success("删除完成");
    }

    private function buildForm($url, $method = 'POST', $data = [])
    {
        $form = new Form();
        $form->method($method);
        $form->data($data);
        $form->url($url);
        $form->text()->name('name')->label('权限名称')->rules('required');
        $form->text()->name('alias')->label('别名')->tips('仅支持字母、下划线、"."，必须字母开头')->rules('/^[a-zA-Z][a-zA-Z0-9_.-]+$/', '请输入正确的别名');
        $methods = [];
        $methods[] = ['val' => 'GET', 'title' => 'GET'];
        $methods[] = ['val' => 'POST', 'title' => 'POST'];
        $methods[] = ['val' => 'PUT', 'title' => 'PUT'];
        $methods[] = ['val' => 'DELETE', 'title' => 'DELETE'];
        $methods[] = ['val' => 'PATCH', 'title' => 'PATCH'];
        $methods[] = ['val' => 'OPTIONS', 'title' => 'OPTIONS'];
        $methods[] = ['val' => 'HEAD', 'title' => 'HEAD'];
        $form->multiSelect()->name('http_method')->options($methods)->label('HTTP Method')->tips('留空支持所有');
        $form->textarea()->name('path')->label('HTTP地址')->tips('换行分割')->rule('required');
        $form->hiddenSubmit(!Auth::check($url, $method));
        return $form->render();
    }
}