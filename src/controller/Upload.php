<?php

namespace thans\layuiAdmin\controller;

use thans\layuiAdmin\facade\Json;
use think\exception\ValidateException;
use think\facade\Config;
use think\facade\Env;
use think\facade\Filesystem;
use think\Request;

class Upload
{
    public function image(Request $request)
    {
        $file = $request->file();
        try {
            validate(['image' => Config::get('admin.upload.image')])->check($file);
            $savename = Filesystem::disk('public')->putFile('uploads/images', $file['image']);
            Json::success('上传成功', DIRECTORY_SEPARATOR.'storage'.DIRECTORY_SEPARATOR.$savename);
        } catch (ValidateException $e) {
            Json::error($e->getMessage());
        }
    }

    public function file(Request $request)
    {
        $file = $request->file();
        try {
            validate(['file' => Config::get('admin.upload.file')])->check($file);
            $savename = Filesystem::disk('public')->putFile('uploads/files', $file['file']);
            Json::success('上传成功', DIRECTORY_SEPARATOR.'storage'.DIRECTORY_SEPARATOR.$savename);
        } catch (ValidateException $e) {
            Json::error($e->getMessage());
        }
    }
}
