<?php

namespace thans\layuiAdmin\controller;

use thans\layuiAdmin\facade\Auth;
use thans\layuiAdmin\facade\Json;
use thans\layuiAdmin\Form;
use thans\layuiAdmin\model\User;
use think\Exception;
use think\Request;

class Personal
{
    public function setting(Request $request)
    {
        $user = new User();
        $user = $user->hidden()->get(Auth::userId());
        if ($request->isAjax()) {
            $data = $request->param();
            if ($data['password'] != $data['confirm_password']) {
                Json::error('两次密码输入不一致');
            }
            $validate = new \thans\layuiAdmin\validate\User();
            if (!$validate->scene('personal')->check($data)) {
                Json::error($validate->getError());
            }

            try {
                $user->nickname = $data['nickname'];
                isset($data['avatar']) && $data['avatar'] ? $user->avatar = $data['avatar'] : '';
                if ($data['password']) {
                    $salt = random_str(20);
                    $user->password = encrypt_password($data['password'], $salt);
                    $user->salt = $salt;
                }
                $user->save();
                Auth::clearCache();
                Json::success('修改完成');
            } catch (Exception $e) {
                Json::error($e->getMessage());
            }
        }
        $form = new Form();
        $form->data($user);
        $form->url(url('thans\layuiAdmin\controller\Personal@setting'));
        $form->successEndScript('refresh');
        $form->text()->label('昵称')->name('nickname')->rules('required', true, 5, 50, '昵称必须5-50个字符之间');
        $form->upload()->label('头像')->name('avatar')->field('image')->url(url('thans\layuiAdmin\controller\Upload@image'))->value($user->avatar);
        $form->text()->type('password')->label('密码')->name('password')->placeholder('不填写，则不修改密码')->rules('password', false);
        $form->text()->type('password')->label('确认密码')->name('confirm_password')->placeholder('与密码保持一致');

        return $form->render();
    }
}
