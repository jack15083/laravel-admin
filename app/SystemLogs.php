<?php
/**
 * Created by PhpStorm.
 * User: zengfanwei
 * Date: 2018/11/8
 * Time: 15:14
 */

namespace App;


use Illuminate\Database\Eloquent\Model;

class SystemLogs extends Model
{
    protected $table = 'yy_admin_log';

    public $timestamps = false;

    public static $instance;

    public static function getInstance()
    {
        if(!self::$instance) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public function getList($condition, $pageSize = 20)
    {
        foreach ($condition as $key => $value) {
            if(in_array($key, ['page', 'pageSize']) || !$value) {
                unset($condition[$key]);
            }
        }

        $data = $this->where($condition)
            ->orderBy('create_time', 'desc')
            ->paginate($pageSize)
            ->toArray();

        foreach ($data['data'] as &$row) {
            $row['create_time'] = date('Y-m-d H:i:s', $row['create_time']);
        }

        return $data;
    }

    public function saveData($params)
    {
        $model = new self();
        $model->create_time = microtime(true);

        foreach ($params as $key => $value) {
            $model->{$key} = $value;
        }

        $model->save();
    }
}