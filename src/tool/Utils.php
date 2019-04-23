<?php


namespace thans\layuiAdmin\tool;


use think\facade\Request;

class Utils
{
    public function buildParams($searchField = null)
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
                $where[] = [$key, '=', $value];
            }
        }

        $order = 'id desc';//TODO 排序

        $page = Request::param('page/d', 1);

        $limit = Request::param('limit/d', 15);

        return [$where, $order, $page, $limit];
    }
}