<?php
namespace thans\layuiAdmin\model;

use think\Model;

class UserMeta extends Model
{
    protected $name = 'user_meta';
    public function user()
    {
        return $this->belongsTo('user');
    }
}
