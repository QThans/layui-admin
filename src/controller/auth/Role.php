<?php

namespace thans\layuiAdmin\controller\auth;

use thans\layuiAdmin\facade\Auth;
use thans\layuiAdmin\facade\Json;
use thans\layuiAdmin\facade\Utils;
use thans\layuiAdmin\Form;
use thans\layuiAdmin\model\AuthPermission;
use thans\layuiAdmin\model\AuthRole;
use thans\layuiAdmin\model\Menu;
use thans\layuiAdmin\Table;
use think\Exception;
use think\Request;

class Role
{
    public function index(Request $request)
    {
        if ($request->isAjax()) {
            list($where, $order, $page, $limit) = Utils::buildParams('name|alias');
            $authRole = AuthRole::where($where);
            $list = $authRole->order($order)->page($page)->limit($limit)->select();
            $total = $authRole->count();
            Json::success('获取成功', $list, ['total' => $total]);
        }
        $tb = new Table();
        $tb->title('权限组');
        $tb->url(url('thans\layuiAdmin\controller\auth\Role/index'));

        $tb->column('id', 'ID', 100);
        $tb->column('name', '权限组名称');
        $tb->column('alias', '权限组别名');
        $tb->status()->option(0, '启用')->option(1, '禁用', 'danger');
        $tb->column('status', '状态', 100, 'status', ['align' => 'center']);
        $tb->column('create_time', '创建时间');
        $tb->column('update_time', '更新时间');
        $url = url('thans\layuiAdmin\controller\auth\Role/create');
        if (Auth::check($url)) {
            $tb->action('新增权限组', $url);
        }
        $url = url('thans\layuiAdmin\controller\auth\Role/edit', 'id={{ d.id }}');
        if (Auth::check($url)) {
            $tb->tool('编辑', $url);
        }
        $url = url('thans\layuiAdmin\controller\auth\Role/delete', 'id={{ d.id }}');
        if (Auth::check($url, 'delete')) {
            $tb->tool('删除', $url, 'confirmAjax', 'danger', 'DELETE', 'd.id != 1', '确定删除权限组吗？已关联用户权限将被取消');
        }
        $tb->toolWidth(120);

        return $tb->render();
    }

    public function create()
    {
        return $this->buildForm(url('thans\layuiAdmin\controller\auth\Role/save'));
    }

    public function save(Request $request)
    {
        $data = $request->param();

        try {
            $this->validate($data);
            $authRole = new AuthRole();
            $authRole->name = $data['name'];
            $authRole->alias = $data['alias'];
            $authRole->status = isset($data['status']) ? $data['status'] : 0;
            $authRole->save();
            if (isset($data['menus']) && $data['menus']) {
                $authRole->menus()->save(array_values($data['menus']));
            }
            if (isset($data['permissions']) && $data['permissions']) {
                $authRole->permissions()->save(explode(',', $data['permissions']));
            }
            Json::success('保存成功');
        } catch (Exception $e) {
            Json::error($e->getMessage());
        }
    }

    public function edit($id)
    {
        $data = AuthRole::get($id, ['menus', 'permissions']);

        return $this->buildForm(url('thans\layuiAdmin\controller\auth\Role/update', 'id='.$id), 'PUT', $data);
    }

    private function validate($data)
    {
        $validate = new \thans\layuiAdmin\validate\AuthRole();
        if (!$validate->check($data)) {
            Json::error($validate->getError());
        }
    }

    public function update($id, Request $request)
    {
        $data = $request->param();

        try {
            $this->validate($data);
            $authRole = AuthRole::get($id);
            $authRole->save($data);
            $authRole->menus()->detach();
            $authRole->permissions()->detach();
            if (isset($data['menus']) && $data['menus']) {
                $authRole->menus()->save(array_values($data['menus']));
            }
            if (isset($data['permissions']) && $data['permissions']) {
                $authRole->permissions()->save(explode(',', $data['permissions']));
            }
            Json::success('更新成功');
        } catch (Exception $e) {
            Json::error($e->getMessage());
        }
    }

    public function delete($id)
    {
        if ($id === 1) {
            Json::error('无法删除默认数据');
        }
        AuthRole::destroy($id);
        Json::success('删除完成');
    }

    private function buildForm($url, $method = 'POST', $data = [])
    {
        $form = new Form();
        $form->url($url);
        $form->method($method);
        $data['permissions'] = isset($data['permissions']) && $data['permissions'] ? implode(',', array_column($data->permissions->toArray(), 'id')) : '';
        $form->data($data);
        $form->text()->name('name')->label('权限组名称')->placeholder('请输入权限组名称')->rules('required', true, 2, 100);
        $form->text()->name('alias')->label('权限组别名')->placeholder('请输入权限组别名')->rules('required', true, 2, 20);
        $form->onoff()->label('是否禁用')->name('status')->value(0);
        $menus = Menu::where('status', 0)->select()->toArray();
        if ($data && isset($data->menus)) {
            foreach ($menus as &$menu) {
                $menu['checked'] = false;
                foreach ($data->menus as $val) {
                    if ($val['id'] == $menu['id']) {
                        $menu['checked'] = true;
                    }
                }
            }
        }
        $form->authtree()->items($menus)->label('菜单选择')->name('menus');
        $permission = AuthPermission::select();
        $op = [];
        foreach ($permission as $val) {
            $op[] = ['title' => $val['name'], 'val' => $val['id']];
        }
        $form->multiSelect()->label('权限选择')->name('permissions')->options($op);

        return $form->render();
    }
}
