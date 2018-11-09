<?php
/**
 * Created by PhpStorm.
 * User: zengfanwei
 * Date: 2018/11/7
 * Time: 16:26
 */

namespace App;


use Illuminate\Database\Eloquent\Model;

class GroupAccess extends Model
{
    protected $table = 'yy_auth_group_access';
    public static $instance;
    public $timestamps = false;

    public static function getInstance()
    {
        if(!self::$instance) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public function getGroupIdByUID($adminId)
    {
        $data = $this->where('uid', $adminId)->get()->toArray();

        $ids = [];
        foreach ($data as $row) {
            $ids[] = $row['group_id'];
        }

        return $ids;
    }
}