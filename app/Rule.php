<?php
/**
 * Created by PhpStorm.
 * User: zengfanwei
 * Date: 2018/10/31
 * Time: 17:58
 */

namespace App;


use Illuminate\Database\Eloquent\Model;

class Rule extends Model
{
    protected $table = 'yy_auth_rule';

    public static $instance;

    public static function getInstance()
    {
        if(!self::$instance) {
            self::$instance = new Group();
        }

        return self::$instance;
    }

    public function getList()
    {
        return $this->where('status', 0)->orderBy('id', 'asc')->get()->toArray();
    }
}