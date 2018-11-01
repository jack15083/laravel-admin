<?php
/**
 * Created by PhpStorm.
 * User: zengfanwei
 * Date: 2018/10/31
 * Time: 14:04
 */

namespace App;


use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    protected $table = 'yy_auth_group';

    public static $instance;

    public static function getInstance()
    {
        if(!self::$instance) {
            self::$instance = new Group();
        }

        return self::$instance;
    }

    public function getList($condition)
    {
        $model = $this;

        if(!empty($condition['id'])) {
            $model = $model->where('id', $condition['id']);
        }

        if(!empty($condition['title'])) {
            $model = $model->where('title', 'like',  '%' . $condition['title'] . '%');
        }

        return $model->orderBy('id', 'asc')->get()->toArray();
    }
}