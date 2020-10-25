<?php

namespace thans\layuiAdmin\tool;

use thans\layuiAdmin\Page;
use think\exception\HttpResponseException;
use think\Response;
use think\response\Redirect;

class Jump
{
    /**
     * 应用实例.
     *
     * @var \think\App
     */
    protected $app;

    /**
     * 操作成功跳转的快捷方法.
     *
     * @param mixed  $msg    提示信息
     * @param string $url    跳转的URL地址
     * @param mixed  $tips   返回的数据
     * @param int    $wait   跳转等待时间
     * @param array  $header 发送的Header信息
     *
     * @return void
     */
    public function success($msg = '', $url = null, $tips = '', $wait = 3, array $header = [])
    {
        $result = [
            'code' => 1,
            'msg'  => $msg,
            'tips' => $tips,
            'url'  => $url,
            'wait' => $wait,
        ];

        $this->build($result, $header);
    }

    /**
     * 操作错误跳转的快捷方法.
     *
     * @param mixed  $msg    提示信息
     * @param string $url    跳转的URL地址
     * @param mixed  $tips   返回的数据
     * @param int    $wait   跳转等待时间
     * @param array  $header 发送的Header信息
     *
     * @return void
     */
    public function error($msg = '', $url = null, $tips = '', $wait = 3, array $header = [])
    {
        $result = [
            'code' => 0,
            'msg'  => $msg,
            'tips' => $tips,
            'url'  => $url,
            'wait' => $wait,
        ];
        $this->build($result, $header);
    }

    /**
     * 返回封装后的API数据到客户端.
     *
     * @param mixed $tips   要返回的数据
     * @param mixed $msg    提示信息
     * @param array $header 发送的Header信息
     *
     * @return void
     */
    public function result($msg = '', $url = null, $tips = '', $wait = 3, array $header = [])
    {
        $result = [
            'code' => -1,
            'msg'  => $msg,
            'tips' => $tips,
            'url'  => $url,
            'wait' => $wait,
        ];
        $this->build($result, $header);
    }

    private function build($result, $header)
    {
        if (is_null($result['url'])) {
            $result['url'] = 'javascript:history.back(-1);';
        } elseif ('close' === $result['url']) {
            $result['url'] = 'close';
        } elseif ('' !== $result['url']) {
            $result['url'] = (strpos($result['url'], '://') || 0 === strpos($result['url'], '/')) ? $result['url'] : url($result['url']);
        }
        $page = new Page();

        $page->tmpl(DIRECTORY_SEPARATOR.'jump');
        $page->builder->module('jquery');
        $page->builder->script(
            'jump_close',
            <<<'EOT'
        $('#close').on('click',function(){
            if (self.frameElement && self.frameElement.tagName == "IFRAME") {
                parent.layui.$(window.parent.document).find('.closeNowTab').click();
            }else{
                location.href = 'about:blank';
            }
            return false;
        });
EOT
        );

        $page->builder->view->assign($result);

        $page = $page->render();

        $response = Response::create($result, 'html')->header($header)->content($page);

        throw new HttpResponseException($response);
    }

    /**
     * URL重定向.
     *
     * @param string    $url    跳转的URL表达式
     * @param array|int $params 其它URL参数
     * @param int       $code   http code
     * @param array     $with   隐式传参
     *
     * @return void
     */
    public function redirect($url, $params = [], $code = 302, $with = [])
    {
        $response = new Redirect($url);

        if (is_int($params)) {
            $code = $params;
            $params = [];
        }

        $response->code($code)->params($params)->with($with);

        throw new HttpResponseException($response);
    }
}
