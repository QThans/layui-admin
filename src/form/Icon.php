<?php


namespace thans\layuiAdmin\form;

use thans\layuiAdmin\Traits\Field;
use think\facade\Cache;

class Icon
{
    use Field;

    public $tmpl = 'form/input';

    public $type = 'hidden';

    public $search = true;

    public $page = true;

    public $limit = 12;

    public $data = ["layui-icon-rate-half", "layui-icon-rate", "layui-icon-rate-solid", "layui-icon-cellphone", "layui-icon-vercode", "layui-icon-login-wechat", "layui-icon-login-qq", "layui-icon-login-weibo", "layui-icon-password", "layui-icon-username", "layui-icon-refresh-3", "layui-icon-auz", "layui-icon-spread-left", "layui-icon-shrink-right", "layui-icon-snowflake", "layui-icon-tips", "layui-icon-note", "layui-icon-home", "layui-icon-senior", "layui-icon-refresh", "layui-icon-refresh-1", "layui-icon-flag", "layui-icon-theme", "layui-icon-notice", "layui-icon-website", "layui-icon-console", "layui-icon-face-surprised", "layui-icon-set", "layui-icon-template-1", "layui-icon-app", "layui-icon-template", "layui-icon-praise", "layui-icon-tread", "layui-icon-male", "layui-icon-female", "layui-icon-camera", "layui-icon-camera-fill", "layui-icon-more", "layui-icon-more-vertical", "layui-icon-rmb", "layui-icon-dollar", "layui-icon-diamond", "layui-icon-fire", "layui-icon-return", "layui-icon-location", "layui-icon-read", "layui-icon-survey", "layui-icon-face-smile", "layui-icon-face-cry", "layui-icon-cart-simple", "layui-icon-cart", "layui-icon-next", "layui-icon-prev", "layui-icon-upload-drag", "layui-icon-upload", "layui-icon-download-circle", "layui-icon-component", "layui-icon-file-b", "layui-icon-user", "layui-icon-find-fill", "layui-icon-loading", "layui-icon-loading-1", "layui-icon-add-1", "layui-icon-play", "layui-icon-pause", "layui-icon-headset", "layui-icon-video", "layui-icon-voice", "layui-icon-speaker", "layui-icon-fonts-del", "layui-icon-fonts-code", "layui-icon-fonts-html", "layui-icon-fonts-strong", "layui-icon-unlink", "layui-icon-picture", "layui-icon-link", "layui-icon-face-smile-b", "layui-icon-align-left", "layui-icon-align-right", "layui-icon-align-center", "layui-icon-fonts-u", "layui-icon-fonts-i", "layui-icon-tabs", "layui-icon-radio", "layui-icon-circle", "layui-icon-edit", "layui-icon-share", "layui-icon-delete", "layui-icon-form", "layui-icon-cellphone-fine", "layui-icon-dialogue", "layui-icon-fonts-clear", "layui-icon-layer", "layui-icon-date", "layui-icon-water", "layui-icon-code-circle", "layui-icon-carousel", "layui-icon-prev-circle", "layui-icon-layouts", "layui-icon-util", "layui-icon-templeate-1", "layui-icon-upload-circle", "layui-icon-tree", "layui-icon-table", "layui-icon-chart", "layui-icon-chart-screen", "layui-icon-engine", "layui-icon-triangle-d", "layui-icon-triangle-r", "layui-icon-file", "layui-icon-set-sm", "layui-icon-add-circle", "layui-icon-404", "layui-icon-about", "layui-icon-up", "layui-icon-down", "layui-icon-left", "layui-icon-right", "layui-icon-circle-dot", "layui-icon-search", "layui-icon-set-fill", "layui-icon-group", "layui-icon-friends", "layui-icon-reply-fill", "layui-icon-menu-fill", "layui-icon-log", "layui-icon-picture-fine", "layui-icon-face-smile-fine", "layui-icon-list", "layui-icon-release", "layui-icon-ok", "layui-icon-help", "layui-icon-chat", "layui-icon-top", "layui-icon-star", "layui-icon-star-fill", "layui-icon-close-fill", "layui-icon-close", "layui-icon-ok-circle", "layui-icon-add-circle-fine"];

    public function end()
    {
        $this->id = uniqid();
        $this->hide();
        $this->obj->module('iconPicker');
        $icon = Cache::remember('fa-iconfont_icons', function () {
            $faFile = file_get_contents($this->obj->builder->css['fa-iconfont']);
            preg_match_all('/.fa-(.*?):before/m', $faFile, $matches, PREG_PATTERN_ORDER, 3300);
            $icon = [];
            foreach ($matches[1] as $val) {
                $icon[] = 'fa-' . $val;
            }
            return $icon;
        });
        $data = json_encode(array_merge($this->data, $icon));
        $this->obj->script(
            'authtree' . $this->id,
            <<<EOD
            iconPicker.render({
                elem: '#{$this->id}',
                data: {$data},
                // 是否开启搜索：true/false，默认true
                search: {$this->search},
                // 是否开启分页：true/false，默认true
                page: {$this->page},
                // 每页显示数量，默认12
                limit: {$this->limit},
                // 点击回调
                click: function (data) {
                },
                // 渲染成功后的回调
                success: function(d) {
                }
            });
EOD
        );
        $this->attr('lay-filter', $this->id);
        $val = isset($this->obj->data[$this->name]) ? $this->obj->data[$this->name] : '';
        $setValueScript = $this->name ? ";iconPicker.checkIcon('{$this->id}', '{$val}');" : "";
        $this->obj->setValueScript('icon_' . $this->id, $setValueScript);
    }
}
