<?php
/**
 * Created by PhpStorm.
 * User: zengfanwei
 * Date: 2018/10/31
 * Time: 14:03
 */

namespace App\Http\Controllers\System;

use App\Components\Code;
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

        return $this->sendJson([
            'list' => $data,
            'auth' => [
                'canAdd'   => $this->canAdd(),
                'canEdit' => $this->canEdit()
            ]
        ]);
    }

    /**
     * 保存管理组
     */
    public function save()
    {
        if(!$this->request->input('id')) {
            $rows = Group::getInstance()->getRows(['title' => $this->request->input('title')]);
            if(!empty($rows)) {
                return $this->sendError(Code::GROUP_EXIST);
            }
        }

        Group::getInstance()->saveData($this->request->all());

        return $this->sendJson();
    }
}