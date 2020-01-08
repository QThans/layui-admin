<?php

namespace thans\layuiAdmin\model;

use think\Model;

class SystemConfigTab extends Model
{
    protected $name = 'system_config_tab';

    public function getByAlias($alias)
    {
        return $this->where('alias', $alias)->find();
    }

    public static function onBeforeWrite(Model $model)
    {
        $where = $model['id'] ? [['id', '<>', $model['id']]] : '';
        if (self::where('name', $model['name'])->where($where)->find()) {
            abort(404, '配置分类名称已存在');
        }
        if (self::where('alias', $model['alias'])->where($where)->find()) {
            abort(404, '配置分类别名已存在');
        }
    }
}
