<?php

namespace thans\layuiAdmin\tool;

use think\facade\Request;

class Utils
{
    public $treeParentKey = 'parent_id';
    public $treeTitleColumn = 'name';

    public function buildParams($searchField = null)
    {
        $where = [];

        $filter = Request::param('filter');

        if (isset($filter['keyword'])) {
            $where[] = [$searchField, 'like', '%'.$filter['keyword'].'%'];
            unset($filter['keyword']);
        }
        $keyword = Request::param('keyword');
        if ($keyword) {
            $where[] = [$searchField, 'like', '%'.$keyword.'%'];
        }
        if ($filter) {
            foreach ($filter as $key => $value) {
                if ($value !== '') {
                    $where[] = [$key, '=', $value];
                }
            }
        }

        $order = 'id desc'; //TODO 排序

        $page = Request::param('page/d', 1);

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
                $val['label'] = str_repeat($label, $deep).$val[$this->treeTitleColumn];
                $val['deep'] = $deep;
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
