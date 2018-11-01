<?php
/**
 * Created by PhpStorm.
 * User: zengfanwei
 * Date: 2018/10/31
 * Time: 14:03
 */

namespace App\Http\Controllers\System;


use App\Group;
use App\Http\Controllers\AuthController;

class GroupController extends AuthController
{
    /**
     * 获取管理组列表
     */
    public function getList()
    {
        $data = Group::getInstance()->getList($this->request->all());
        return $this->sendJson($data);
    }
}