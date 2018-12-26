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
    public $timestamps = false;

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
        foreach ($condition as $key => $value) {
            if(in_array($key, ['page', 'pageSize']) || !$value) {
                unset($condition[$key]);
            }
        }

        $data = $this->where($condition)
            ->orderBy('id', 'ASC')
            ->get()
            ->toArray();

        foreach ($data as &$row) {
            $row['rules'] = explode(',', $row['rules']);
        }

        return $data;
    }

    public function saveData($params)
    {
        if(!empty($params['id'])) {
            $group = $this->find($params['id']);
        } else {
            $group = new self();
        }

        $group->status = (int) $params['status'];
        $group->rules  = implode(',', array_unique($params['rules']));
        $group->title  = $params['title'];

        $group->save();
    }

    public function getRows($conditons)
    {
        return $this->where($conditons)->orderBy('id', 'asc')->get()->toArray();
    }
}