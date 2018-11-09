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
    public $timestamps = false;

    public static $instance;

    public static function getInstance()
    {
        if(!self::$instance) {
            self::$instance = new Rule();
        }

        return self::$instance;
    }

    public function getList($condition = [])
    {
        return $this->where($condition)->orderBy('id', 'asc')->get()->toArray();
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
        }

        foreach ($params as $key => $value) {
            $model->{$key} = $value;
        }

        $model->save();
    }

    /**
     * 获取用户权限
     * @param $adminId
     * @return array
     */
    public function getRulesByUID($adminId)
    {
        $groupIds = GroupAccess::getInstance()->getGroupIdByUID($adminId);

        $data = [];
        //god组有所有权限
        if(in_array(1, $groupIds)) {
            $rules = Rule::getInstance()->where('status', 1)->get()->toArray();
            foreach ($rules as $rule) {
                $data[$rule['id']] = $rule['name'];
            }

            return $data;
        }

        $groups = Group::getInstance()->whereIn('id', $groupIds)->get()->toArray();

        foreach ($groups as $row) {
            $ruleIds = explode(',' , $row['rules']);
            $rules = Rule::getInstance()->where('status', 1)->whereIn('id', $ruleIds)->get()->toArray();
            foreach ($rules as $rule) {
                $data[$rule['id']] = $rule['name'];
            }
        }

        return $data;
    }
}