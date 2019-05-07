<?php


namespace thans\layuiAdmin\controller;


use thans\layuiAdmin\facade\Json;
use think\facade\Config;
use think\facade\Env;
use think\Request;

class Upload
{
    public function image(Request $request)
    {
        $file = $request->file('image');
        if (!$file) {
            Json::error("请选择图片");
        }
        // 移动到框架应用根目录/uploads/ 目录下
        $info = $file->validate(['size' => Config::get('admin.upload.image.size'), 'ext' => Config::get('admin.upload.image.ext')])->move(Env::get('root_path') . '/public/uploads');
        if ($info) {
            Json::success('上传成功', '/uploads/' . $info->getSaveName());
        } else {
            // 上传失败获取错误信息
            Json::error($file->getError());
        }
    }

    public function file(Request $request)
    {
        $file = $request->file('file');
        if (!$file) {
            Json::error("请选择文件");
        }
        $info = $file->validate(['size' => Config::get('admin.upload.file.size'), 'ext' => Config::get('admin.upload.file.ext')])->move(Env::get('root_path') . '/public/uploads');
        if ($info) {
            Json::success('上传成功', '/uploads/' . $info->getSaveName());
        } else {
            // 上传失败获取错误信息
            Json::error($file->getError());
        }
    }
}