<?php

namespace thans\layuiAdmin\controller;

use thans\layuiAdmin\facade\AdminsAuth;
use thans\layuiAdmin\facade\Json;
use thans\layuiAdmin\facade\Utils;
use thans\layuiAdmin\Form;
use thans\layuiAdmin\model\AuthPermission;
use thans\layuiAdmin\model\Menu as MenuModel;
use thans\layuiAdmin\Table;
use thans\layuiAdmin\Traits\FormActions;
use think\Request;

class Menu
{
    use FormActions;

    public function index(Request $request)
    {
        if ($request->isAjax()) {
            list($where, $order, $page, $limit) = Utils::buildParams('name|url|permission');
            $menu = new MenuModel();
            $list = $menu->select();
            $list = Utils::buildTree($list, false, '└―');
            $count = $menu->where($where)->count();
            Json::success('获取成功', $list, ['total' => $count]);
        }
        $tb = new Table();
        $tb->url(url('thans\layuiAdmin\controller\Menu/index'));
        $tb->column('id', 'ID', 100);
        $tb->column('label', '菜单名称', 300);
        $tb->icon();
        $tb->column('icon', 'ICON', 100, 'icon', ['align' => 'center']);
        $tb->column('uri', 'URI', 200);
        $tb->column('permission', '权限绑定', 200);
        $tb->status()->option(0, '显示')->option(1, '隐藏', 'danger');
        $tb->column('status', '状态', 100, 'status', ['align' => 'center']);
        $tb->column('create_time', '创建时间', 200);
        $tb->column('update_time', '更新时间', 200);
        $url = url('thans\layuiAdmin\controller\Menu/create');
        if (AdminsAuth::check($url)) {
            $tb->action('新增菜单', $url);
        }
        $url = url('thans\layuiAdmin\controller\Menu/edit', ['id' => '{{ d.id }}']);
        if (AdminsAuth::check($url)) {
            $tb->tool('编辑', $url, 'formLayer');
        }
        $url = url('thans\layuiAdmin\controller\Menu/delete', ['id' => '{{ d.id }}']);
        if (AdminsAuth::check($url, 'DELETE')) {
            $tb->tool('删除', $url, 'confirmAjax', 'danger', 'DELETE');
        }
        $tb->title('菜单管理');

        return $tb->render();
    }

    private function buildForm()
    {
        $menu = new MenuModel();
        $form = new Form($menu, new \thans\layuiAdmin\validate\Menu());
        $parent = [];
        $parent[] = ['val' => 0, 'title' => '根菜单'];
        foreach (Utils::buildTree($menu->select(), false, '└―') as $val) {
            $parent[] = ['val' => $val['id'], 'title' => $val['label']];
        }
        $form->select()->name('parent_id')->label('上级菜单')->options($parent);
        $form->text()->name('name')->label('菜单名称')->rules('required');
        $form->icon()->name('icon')->label('ICON');
        $form->number()->name('order')->label('排序')->value(1000);
        $form->text()->name('uri')->label('URI')->placeholder('请输入URI');
        $status = [];
        $status[] = ['val' => 0, 'title' => '启用'];
        $status[] = ['val' => 1, 'title' => '禁用'];
        $form->select()->name('status')->label('状态')->options($status);

        return $form;
    }
}
