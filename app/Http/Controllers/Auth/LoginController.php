<?php

namespace App\Http\Controllers\Auth;

use App\Admin;
use App\Components\Code;
use App\Components\Common;
use App\Http\Controllers\Controller;
use App\Rule;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    /**
     * 登录方法
     * @return $this|\Illuminate\Http\JsonResponse
     */
    public function login()
    {
        $adminModel = new Admin();
        $username =  $this->request->input('username');
        $userInfo = $adminModel->getRows(['username' => $username])[0] ?? [];

        if(empty($userInfo)) {
            return $this->sendError(Code::LOGIN_ERROR);
        }

        if(time() - $userInfo['last_login'] < 3600 && $userInfo['try_time'] > 5) {
            return $this->sendError(Code::LOGIN_TRY_ERROR);
        }

        $checkPass = $adminModel->checkPassword($userInfo['id'], $this->request->input('password'));

        if(!$checkPass) {
            $adminModel->saveData([
                'id' => $userInfo['id'],
                'try_time' => $userInfo['try_time'] + 1
            ]);

            return $this->sendError(Code::LOGIN_ERROR);
        }

        $adminModel->saveData([
            'id'         => $userInfo['id'],
            'try_time'   => 0,
            'last_login' => microtime(true),
            'last_ip'    => $this->request->getClientIp()
        ]);

        $rules = Rule::getInstance()->getRulesByUID($userInfo['id']);
        $this->request->session()->put('loginInfo', [
            'admin_id' => $userInfo['id'],
            'username' => $userInfo['username'],
            'rules'    => $rules,
        ]);

        $menus = [];
        $list = Rule::getInstance()->getList(['menu' => 1, 'status' => 1]);
        foreach ($list as $row) {
            if(in_array($row['name'], $rules)) {
                $menus[] = $row;
            }
        }

        $userInfo['menus'] = Common::generateRuleTree($menus, 0);

        return $this->sendJson($userInfo);
    }

    /**
     * 登出
     * @return $this|\Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        $this->request->session()->forget('loginInfo');
        return $this->sendJson();
    }
}
