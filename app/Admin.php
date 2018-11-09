<?php
/**
 * Created by PhpStorm.
 * User: zengfanwei
 * Date: 2018/11/7
 * Time: 14:31
 */

namespace App;


use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    protected $table = 'yy_auth_admin';

    public $timestamps = false;
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password'
    ];

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
            $row['last_login']  = date('Y-m-d H:i:s', $row['last_login']);
            $row['create_time'] = date('Y-m-d H:i:s', $row['create_time']);
            $row['groups']      = GroupAccess::getInstance()->getGroupIdByUID($row['id']);
        }

        return $data;
    }

    public function getRows($conditons)
    {
        return $this->where($conditons)->orderBy('id', 'asc')->get()->toArray();
    }

    public function saveData($params)
    {
        if(!empty($params['id'])) {
            $model = $this->find($params['id']);
        } else {
            $model = new self();
            $model->create_time = microtime(true);
        }

        foreach ($params as $key => $value) {
            if($key === 'groups') {
                continue;
            }

            if($key === 'password') {
                if($value) {
                    $model->{$key} = password_hash($value, PASSWORD_DEFAULT, ['cost' => 12]);
                }
                continue;
            }

            $model->{$key} = $value;
        }

        $model->save();

        if(!empty($params['groups'])) {
            $this->saveAdminGroup($model->id, $params['groups']);
        }
    }

    public function saveAdminGroup($adminId, $groups)
    {
        GroupAccess::getInstance()->where('uid', $adminId)->delete();
        foreach ($groups as $id) {
            $model = new GroupAccess();
            $model->uid = $adminId;
            $model->group_id = $id;
            $model->save();
        }
    }

    public function checkPassword($id, $password)
    {
        $row = $this->find($id);
        $row = $row->makeVisible(['password'])->toArray();
        if(empty($row)) return false;

        if(password_verify($password, $row['password'])) {
            return true;
        }

        return false;
    }
}