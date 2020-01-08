<?php

namespace thans\layuiAdmin\tool;

use think\facade\Request;

class Utils
{
    public $treeParentKey = 'parent_id';
    public $treeTitleColumn = 'name';

    /**
     * 构建列表查询参数
     * @param mixed|null $searchField 搜索查询字段
     * @param string $alias 表的别名
     * @return array 
     */
    public function buildParams($searchField = null, $alias = '')
    {
        $where = [];

        $filter = Request::param('filter');

        if (isset($filter['keyword'])) {
            $where[] = [$searchField, 'like', '%' . $filter['keyword'] . '%'];
            unset($filter['keyword']);
        }
        $keyword = Request::param('keyword');
        if ($keyword) {
            $where[] = [$searchField, 'like', '%' . $keyword . '%'];
        }
        if ($filter) {
            foreach ($filter as $key => $value) {
                if ($value !== '') {
                    $where[] = [$key, '=', $value];
                }
            }
        }

        $sort = Request::param('sort');
        $order = '';
        if ($sort) {
            foreach ($sort as $key => $value) {
                if ($value) {
                    $order = $key . ' ' . $value ?: $order . ',' . $key . ' ' . $value;
                }
            }
        }
        $order = $order ?: ($alias ? $alias . '.id desc' : 'id desc');
        $page  = Request::param('page/d', 1);

        $limit = Request::param('limit/d', 15);

        return [$where, $order, $page, $limit];
    }

    public function buildTree($data = [], $child = true, $label = '', $parent = 0, $deep = 0, &$tree = [])
    {
        if (empty($data)) {
            return [];
        }
        foreach ($data as $key => $val) {
            if ($val[$this->treeParentKey] == $parent) {
                $val['label'] = str_repeat($label, $deep) . $val[$this->treeTitleColumn];
                $val['deep']  = $deep;
                if (!$child) {
                    $tree[] = $val;
                    $this->buildTree($data, $child, $label, $val['id'], $deep + 1, $tree);
                } else {
                    $children = $this->buildTree($data, $child, $label, $val['id'], $deep + 1);
                    if ($children) {
                        $val['children'] = $children;
                    }
                    $tree[] = $val;
                }
            }
        }

        return $tree;
    }
}
