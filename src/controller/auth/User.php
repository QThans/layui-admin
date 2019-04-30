<?php


namespace thans\layuiAdmin\controller\auth;

//管理员管理
use thans\layuiAdmin\facade\Auth;
use thans\layuiAdmin\facade\Utils;
use thans\layuiAdmin\facade\Json;
use thans\layuiAdmin\Form;
use thans\layuiAdmin\model\AuthRole;
use thans\layuiAdmin\Table;
use thans\layuiAdmin\model\User as UserModel;
use think\Exception;
use think\Request;

class User
{
    public function index(Request $request)
    {
        if ($request->isAjax()) {
            list($where, $order, $page, $limit) = Utils::buildParams('name|nickname|email|mobile');
            $where[] = ['admin', 'eq', 1];
            $user = UserModel::where($where);
            $list = $user->order($order)->page($page)->limit($limit)->select();
            $total = $user->count();
            Json::success('获取成功', $list, ['total' => $total]);
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
        $url = url('thans\layuiAdmin\controller\auth\User/edit', 'id={{ d.id }}');
        if (Auth::check($url)) {
            $tb->tool('编辑', $url);
        }
        $url = url('thans\layuiAdmin\controller\auth\User/create');
        if (Auth::check($url)) {
            $tb->action('新增管理员', $url);
        }
        $tb->toolWidth(70);
        return $tb->render();
    }

    public function create()
    {
        return $this->buildForm(url('thans\layuiAdmin\controller\auth\User/save'));
    }

    public function save(Request $request)
    {
        $data = $request->param();
        try {
            $validate = new \thans\layuiAdmin\validate\User();
            if (!$validate->scene('insert')->check($data)) {
                Json::error($validate->getError());
            }
            $data['salt'] = random_str(20);
            $data['password'] = encrypt_password($data['password'], $data['salt']);
            $data['admin'] = 1;
            $user = UserModel::create($data);
            if ($data['roles']) {
                $user->roles()->save(explode(',', $data['roles']));
            }
            Json::success('保存成功');
        } catch (Exception $e) {
            Json::error($e->getMessage());
        }
    }

    public function edit($id)
    {
        $user = new UserModel();
        $user = $user->hidden()->get($id, 'roles');
        return $this->buildForm(url('thans\layuiAdmin\controller\auth\User/update', 'id=' . $id), 'PUT', $user);
    }

    public function update($id, Request $request)
    {
        $data = $request->param();
        try {
            $validate = new \thans\layuiAdmin\validate\User();
            if (!$validate->scene('edit')->check($data)) {
                Json::error($validate->getError());
            }
            $user = UserModel::get($id);
            if (isset($data['password']) && $data['password']) {
                $user->salt = random_str(20);
                $user->password = encrypt_password($data['password'], $user->salt);
            }
            $user->name = $data['name'];
            $user->nickname = $data['nickname'];
            $user->mobile = $data['mobile'];
            $user->email = $data['email'];
            $user->status = $data['status'];
            $user->save();
            $user->roles()->detach();
            if ($data['roles']) {
                $user->roles()->save(explode(',', $data['roles']));
            }
            Json::success('更新成功');
        } catch (Exception $e) {
            Json::error($e->getMessage());
        }
    }

    public function buildForm($url, $method = 'POST', $data = [])
    {
        $form = new Form();
        $form->url($url);
        $form->method($method);
        $form->data($data);
        $form->text()->label('用户名')->name('name')->placeholder('请输入用户名')->rules('account')->tips("用户名支持中英文、数字、下划线，不支持数字开头");
        $form->text()->label('昵称')->name('nickname')->placeholder('请输入昵称')->rules('required', true, 5, 100);
        $placeholder = '请输入密码';
        if ($data) {
            $placeholder = '留空不更新密码';
        }
        $form->text()->label('密码')->name('password')->placeholder($placeholder)->rules('password', (boolean)!$data)->tips('密码必须6到24位，且不能出现空格');
        $form->text()->label('邮箱')->name('email')->placeholder('请输入邮箱')->rules('email', false);
        $form->text()->label('手机号')->name('mobile')->placeholder('请输入手机号')->rules('mobile', false);
        $op = [
            ['title' => '正常', 'val' => 0],
            ['title' => '禁用', 'val' => 1]
        ];
        $form->select()->label('状态')->name('status')->options($op);
        $op = [];
        $roles = AuthRole::select();
        foreach ($roles as $val) {
            $op[] = ['title' => $val['name'], 'val' => $val['id']];
        }
        $data['roles'] = isset($data['roles']) && $data['roles'] ? implode(',', array_column($data->roles->toArray(), 'id')) : '';
        $form->multiSelect()->label('权限组选择')->name('roles')->options($op);
        return $form->render();
    }
}