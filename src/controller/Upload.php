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
            validate(['image|图片' => Config::get('admin.upload.image')], ['image.fileSize' => '图片大小不符', 'image.fileExt' => '图片后缀不符', 'image.fileMime' => 'Mime类型错误', 'image.image' => '尺寸\类型错误'])->check($file);
            $file = $request->param('type') == 'ck' ? $file['upload'] : $file['image'];
            $savename = Filesystem::putFile('uploads/images', $file);
            if ($request->param('type') == 'ck') {
                return json([
                    'uploaded' => 1,
                    'fileName' => $file->getOriginalMime(),
                    'url' => Filesystem::getUrl($savename)
                ]);
            }
            Json::success('上传成功', $savename, ['url' => Filesystem::getUrl($savename)]);
        } catch (ValidateException $e) {
            if ($request->param('type') == 'ck') {
                return json([
                    'uploaded' => 0,
                    'error' => [
                        'message' => $e->getMessage()
                    ]
                ]);
            }
            Json::error($e->getMessage(), 200);
        }
    }

    public function file(Request $request)
    {
        $file = $request->file();
        try {
            validate(['file' => Config::get('admin.upload.file')], ['image.fileSize' => '文件大小不符', 'image.fileExt' => '文件后缀不符', 'image.fileMime' => 'Mime类型错误'])->check($file);
            $file = $request->param('type') == 'ck' ? $file['upload'] : $file['file'];
            $savename = Filesystem::putFile('uploads/files', $file);
            if ($request->param('type') == 'ck') {
                return json([
                    'uploaded' => 1,
                    'fileName' => $file->getOriginalMime(),
                    'url' => Filesystem::getUrl($savename)
                ]);
            }
            Json::success('上传成功', $savename, ['url' => Filesystem::getUrl($savename)]);
        } catch (ValidateException $e) {
            if ($request->param('type') == 'ck') {
                return json([
                    'uploaded' => 0,
                    'error' => [
                        'message' => $e->getMessage()
                    ]
                ]);
            }
            Json::error($e->getMessage(), 200);
        }
    }
}
