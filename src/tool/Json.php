<?php


namespace thans\layuiAdmin\tool;


use think\Container;
use think\exception\HttpResponseException;
use think\Response;

class Json
{
    /**
     * 操作成功跳转的快捷方法
     * @access protected
     * @param mixed $msg 提示信息
     * @param string $url 跳转的URL地址
     * @param mixed $data 返回的数据
     * @param integer $wait 跳转等待时间
     * @param array $header 发送的Header信息
     * @return void
     */
    public function success($msg = '', $data = '', $statusCode = '200', array $res = [], $url = null, $wait = 3, array $header = [])
    {
        if (is_null($url)) {
            $url = '';
        } elseif ('' !== $url) {
            $url = (strpos($url, '://') || 0 === strpos($url, '/')) ? $url : Container::get('url')->build($url);
        }

        $result = [
            'code' => 0,
            'msg' => $msg,
            'data' => $data,
            'redirect' => $url,
            'wait' => $wait,
        ];

        $response = Response::create(array_merge($res, $result), 'json', $statusCode)->header($header);

        throw new HttpResponseException($response);
    }

    /**
     * 操作错误跳转的快捷方法
     * @access protected
     * @param mixed $msg 提示信息
     * @param mixed $statusCode 错误HTTP代码
     * @param string $url 跳转的URL地址
     * @param mixed $data 返回的数据
     * @param integer $wait 跳转等待时间
     * @param array $header 发送的Header信息
     * @return void
     */
    public function error($msg = '', $statusCode = '400', $url = null, $data = '', $wait = 3, array $header = [])
    {
        if (is_null($url)) {
            $url = '';
        } elseif ('' !== $url) {
            $url = (strpos($url, '://') || 0 === strpos($url, '/')) ? $url : $this->app['url']->build($url);
        }

        $result = [
            'error_msg' => $msg,
            'data' => $data,
            'redirect' => $url,
            'wait' => $wait,
        ];

        $response = Response::create($result, 'json', $statusCode)->header($header);

        throw new HttpResponseException($response);
    }
}