<?php
/**
 * Created by PhpStorm.
 * User: zengfanwei
 * Date: 2018/11/7
 * Time: 14:25
 */

namespace App\Http\Controllers\System;


use App\Components\Code;
use App\Components\Common;
use App\Http\Controllers\AuthController;
use App\Admin;
use App\SystemLogs;
use Illuminate\Http\Request;

class AdminController extends AuthController
{
    /**
     * 获取用户列表分页
     */
    public function getList()
    {
        $data = Admin::getInstance()->getList($this->request->all());

        $data['auth'] = [
            'canAdd'   => $this->canAdd(),
            'canEdit' => $this->canEdit()
        ];

        return $this->sendJson($data);
    }

    /**
     * 获取用户列表分页
     */
    public function getLogs()
    {
        $data = SystemLogs::getInstance()->getList($this->request->all());
        return $this->sendJson($data);
    }

    /**
     * 保存用户
     */
    public function save()
    {
        if(!$this->request->input('id')) {
            $rows = Admin::getInstance()->getRows(['username' => $this->request->input('username')]);
            if(!empty($rows)) {
                return $this->sendError(Code::ADMIN_EXIST);
            }
        }

        Admin::getInstance()->saveData($this->request->all());

        return $this->sendJson();
    }

    public function uploadAvatar()
    {
        $res = Common::uploadImgToLocalStorage($this->request, 'file');
        if($res['error'] !== 0) {
            return $this->sendError(Code::FAIL, $res['msg']);
        }

        return $this->sendJson(['img_path' => $res['img_path']]);
    }

    public function saveAvatar()
    {
        $this->setLoginInfo();
        Admin::getInstance()->saveData([
            'id' => $this->loginInfo['admin_id'],
            'avatar' => $this->request->input('avatar')
        ]);

        return $this->sendJson();
    }

    public function changePassword()
    {
        $this->setLoginInfo();
        if(!Admin::getInstance()->checkPassword($this->loginInfo['admin_id'], $this->request->input('old_password'))) {
            return $this->sendError(Code::OLD_PASSWORD_WRONG);
        }

        Admin::getInstance()->saveData([
            'id' => $this->loginInfo['admin_id'],
            'password' => $this->request->input('password')
        ]);

        return $this->sendJson();
    }

    public function getProfile()
    {
        $this->setLoginInfo();
        $rows = Admin::getInstance()->getRows([
            'id' => $this->loginInfo['admin_id'],
        ]);

        return $this->sendJson($rows[0] ?? []);
    }
}