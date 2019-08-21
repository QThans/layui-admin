<?php

namespace thans\layuiAdmin\controller\auth;

use thans\layuiAdmin\facade\AdminsAuth;
use thans\layuiAdmin\facade\Json;
use thans\layuiAdmin\facade\Utils;
use thans\layuiAdmin\Form;
use thans\layuiAdmin\model\AuthPermission;
use thans\layuiAdmin\model\AuthRole;
use thans\layuiAdmin\model\Menu;
use thans\layuiAdmin\Table;
use thans\layuiAdmin\Traits\FormActions;
use think\Request;

class Role
{
    use FormActions;

    public function index(Request $request)
    {
        if ($request->isAjax()) {
            list($where, $order, $page, $limit) = Utils::buildParams(
                'name|alias'
            );
            $authRole = AuthRole::where($where);
            $list = $authRole->order($order)->page($page)->limit($limit)
                ->select();
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
        if (AdminsAuth::check($url)) {
            $tb->action('新增权限组', $url);
        }
        $url = url(
            'thans\layuiAdmin\controller\auth\Role/edit', ['id' => '{{ d.id }}']
        );
        if (AdminsAuth::check($url)) {
            $tb->tool('编辑', $url);
        }
        $url = url(
            'thans\layuiAdmin\controller\auth\Role/delete', ['id' => '{{ d.id }}']
        );
        if (AdminsAuth::check($url, 'delete')) {
            $tb->tool(
                '删除', $url, 'confirmAjax', 'danger', 'DELETE', 'd.id != 1',
                '确定删除权限组吗？已关联管理员权限将被取消'
            );
        }
        $tb->toolWidth(120);

        return $tb->render();
    }

    private function buildForm()
    {
        $form = new Form(
            new AuthRole(), new \thans\layuiAdmin\validate\AuthRole()
        );

        $form->text()->name('name')->label('权限组名称')->placeholder('请输入权限组名称')
            ->rules('required', true, 2, 100);
        $form->text()->name('alias')->label('权限组别名')->placeholder('请输入权限组别名')
            ->rules('required', true, 2, 20);
        $form->onoff()->label('是否禁用')->name('status')->value(1);

        $menus = Menu::where('status', 0)->select()->toArray();

        $form->authtree()->items($menus)->label('菜单选择')->name('menus');

        $permission = AuthPermission::select();
        $op = [];
        foreach ($permission as $val) {
            $op[] = ['title' => $val['name'], 'val' => $val['id']];
        }
        $form->multiSelect()->label('权限选择')->name('permissions')->options($op);
        $form->relation('menus');
        $form->relation('permissions');
        $form->beforeRead(
            function (Form $form) {
                $form->data['permissions'] = isset($form->data['permissions'])
                && $form->data['permissions']
                    ? implode(
                        ',', array_column($form->data->permissions->toArray(), 'id')
                    ) : '';
                $form->data['menus'] = isset($form->data['menus'])
                && $form->data['menus']
                    ? implode(
                        ',', array_column($form->data->menus->toArray(), 'id')
                    ) : '';
            }
        );

        $form->afterSave(
            function (Form $form, $data) {
                if (isset($data['menus']) && $data['menus']) {
                    $form->model->menus()->save(array_values($data['menus']));
                }
                if (isset($data['permissions']) && $data['permissions']) {
                    $form->model->permissions()->save(
                        explode(',', $data['permissions'])
                    );
                }
            }
        );

        $form->afterUpdate(
            function (Form $form, $model, $data) {
                $model->menus()->detach();
                $model->permissions()->detach();
                if (isset($data['menus']) && $data['menus']) {
                    $model->menus()->save(array_values($data['menus']));
                }
                if (isset($data['permissions']) && $data['permissions']) {
                    $model->permissions()->save(
                        explode(',', $data['permissions'])
                    );
                }
            }
        );

        $form->beforeDestroy(
            function (Form $form, $model) {
                if ($model['id'] == 1) {
                    Json::error('无法删除默认数据');
                }
            }
        );

        return $form;
    }
}
