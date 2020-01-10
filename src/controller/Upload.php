<?php

namespace thans\layuiAdmin\controller;

use thans\layuiAdmin\facade\Json;
use think\exception\ValidateException;
use think\facade\Config;
use think\facade\Filesystem;
use think\Request;

//公共默认上传
class Upload
{
    public function image(Request $request)
    {
        $file = $request->file();
        try {
            validate(['image|图片' => Config::get('admin.upload.image')])->check($file);
            $savename = Filesystem::putFile('uploads/images', $file['image']);
            Json::success('上传成功', $savename, ['url' => Filesystem::getUrl($savename),'msg'=>'123']);
        } catch (ValidateException $e) {
            Json::error($e->getMessage(),200);
        }
    }

    public function file(Request $request)
    {
        $file = $request->file();
        try {
            validate(['file' => Config::get('admin.upload.file')])->check($file);
            $savename = Filesystem::putFile('uploads/files', $file['file']);
            Json::success('上传成功', $savename, ['url' => Filesystem::getUrl($savename)]);
        } catch (ValidateException $e) {
            Json::error($e->getMessage(),200);
        }
    }
}
