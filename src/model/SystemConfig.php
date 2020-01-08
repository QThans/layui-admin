<?php

namespace thans\layuiAdmin\model;

use think\Model;

class SystemConfig extends Model
{
    protected $name = 'system_config';

    public function setAliasAttr($value)
    {
        return trim($value);
    }
    public static function onBeforeWrite(Model $model)
    {
        $where = $model['id'] ? [['id', '<>', $model['id']]] : '';
        if (self::where('name', $model['name'])->where('config_tab_id', $model['config_tab_id'])->where($where)->find()) {
            abort(404, '配置名称已存在');
        }
        if (self::where('alias', $model['alias'])->where('config_tab_id', $model['config_tab_id'])->where($where)->find()) {
            abort(404, '配置别名已存在');
        }
    }
}
