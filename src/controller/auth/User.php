<?php


namespace thans\layuiAdmin\controller\auth;

//管理员管理
use thans\layuiAdmin\facade\Utils;
use thans\layuiAdmin\facade\Json;
use thans\layuiAdmin\Table;
use thans\layuiAdmin\model\User as UserModel;
use think\Request;

class User
{
    public function index(Request $request)
    {
        if ($request->isAjax()) {
            list($where, $order, $page, $limit) = Utils::buildParams('name|nickname|email|mobile');
            $user = UserModel::where($where);
            $where[] = ['admin', 'eq', 1];
            $list = $user->order($order)->page($page)->limit($limit)->select();
            $total = $user->count();
            Json::success('获取成功', $list, 200, ['total' => $total]);
        }
        $tb = new Table();
        $tb->title('管理员');
        $tb->url(url('thans\layuiAdmin\controller\auth\User/index'));
        $tb->column('id', 'ID', 100);
        $tb->column('name', '用户名');
        $tb->column('nickname', '昵称');
        $tb->column('email', '邮箱');
        $tb->column('mobile', '手机号');
        $tb->column('status_text', '状态', 100, 'status', ['align' => 'center']);
        $tb->column('last_login_time', '最后登录时间');
        $tb->column('create_time', '创建时间');
        $tb->column('update_time', '更新时间');
        $tb->status(['field' => 'status'])->option(0, '正常')->option(1, '禁用', 'danger');
        $tb->tool('编辑', url('thans\layuiAdmin\controller\auth\User/edit', 'id={{ d.id }}'));
        $tb->tool('权限组分配', url('thans\layuiAdmin\controller\auth\User@role', 'id={{ d.id }}'));
        $tb->tool('菜单分配', url('thans\layuiAdmin\controller\auth\User@menu', 'id={{ d.id }}'));
        $tb->action('新增管理员', url('thans\layuiAdmin\controller\auth\User/create'));
        $tb->toolWidth(220);
        return $tb->render();
    }

    public function create()
    {
        return $this->buildForm(url('thans\layuiAdmin\controller\auth\User/save'));
    }

    public function save()
    {

    }

    public function edit($id)
    {
        $user = new UserModel();
        $user = $user->hidden()->get($id);
        return $this->buildForm(url('thans\layuiAdmin\controller\auth\User/update', 'id=' . $id), 'PUT', $user);
    }

    public function update($id, Request $request)
    {

    }

    public function buildForm($url, $method = 'POST', $data = [])
    {

    }

    public function role($id, Request $request)
    {
        if ($request->isPost()) {

        }
    }

    public function menu($id, Request $request)
    {
        if ($request->isPost()) {

        }
    }
}