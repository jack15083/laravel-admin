<?php

namespace App\Http\Controllers\Auth;

use App\Admin;
use App\Components\Code;
use App\Components\Common;
use App\Components\KKLApi;
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

    public $ddLoginUrl = 'https://oapi.dingtalk.com/sns/';
    public $ddAppId = 'dingoamx6u18gw3pthjsbi';
    public $ddAppSecret = 'rbKv-MEG3k81py-Ci2FVkBVddt0uiBs3t864hKBN9BKjFHKRP46ec__upxlk8NqT';

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

        $userInfo = $this->loginSuccess($userInfo);

        return $this->sendJson($userInfo);
    }

    private function loginSuccess($userInfo)
    {
        Admin::getInstance()->saveData([
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

        return $userInfo;
    }

    /**
     * 钉钉登录
     * @return $this|\Illuminate\Http\JsonResponse
     */
    public function ddlogin()
    {
        $code = $this->request->input('code');
        if(empty($code)) {
            return $this->sendError(Code::FAIL);
        }

        $accessToken = $this->getAccessToken();

        // 获取持久验证码
        $reqUrl1 = $this->ddLoginUrl . 'get_persistent_code?access_token=' . $accessToken;
        $curlRes = KKLApi::my_curl($reqUrl1, ('{"tmp_auth_code": "' . $code . '"}'), 'POST', 5,
            array('Content-Type:application/json'));
        $jsonArr = json_decode($curlRes[1] ?? '{"errcode": 1}', true);
        if(0 !== $jsonArr['errcode']) {
            return $this->sendError(Code::FAIL);
        }

        //获取sns token
        $reqUrl = $this->ddLoginUrl . '/get_sns_token?access_token=' . $accessToken;
        $json = '{"openid": "' . $jsonArr['openid'] . '","persistent_code": "' . $jsonArr['persistent_code'].'"}';
        $curlRes = KKLApi::my_curl($reqUrl, $json, 'POST', 5, array('Content-Type:application/json'));
        $jsonArr = json_decode($curlRes[1] ?? '{"errcode": 1}', true);
        if(0 !== $jsonArr['errcode']) {
            return $this->sendError(Code::FAIL);
        }

        //获取钉钉用户信息
        $reqUrl = $this->ddLoginUrl . '/getuserinfo?sns_token=' . $jsonArr['sns_token'];
        $curlRes = KKLApi::my_curl($reqUrl, '', 'GET', 5, array('Content-Type:application/json'));
        $jsonArr = json_decode($curlRes[1] ?? '{"errcode": 1}', true);
        if(0 !== $jsonArr['errcode']) {
            return $this->sendError(Code::FAIL);
        }

        $userInfo = Admin::getInstance()->getRows(['dingtalk_globalid' => $jsonArr['user_info']['dingId']])[0] ?? [];
        if(empty($userInfo)) {
            return $this->sendError(Code::FAIL);
        }

        $this->loginSuccess($userInfo);

        return $this->sendJson($userInfo);
    }

    /**
     * 钉钉accessToken
     * @return string
     */
    public function getAccessToken()
    {
        $redis = new \Redis();
        $redis->connect(config('database.redis.default.host'), config('database.redis.default.port'));
        $redis->auth(config('database.redis.default.password'));
        $login_atkey = 'product_dtalk_login_accesstoken';
        $accessToken = $redis->get($login_atkey);

        if(!empty($accessToken)) {
            return $accessToken;
        }

        $reqUrl = $this->ddLoginUrl . http_build_query([
                'appid'     => $this->ddAppId,
                'appsecret' => $this->ddAppSecret
            ]);

        $curlRes = KKLApi::my_curl($reqUrl, '', 'GET', 5, array('Content-Type:application/json'));
        if($curlRes[0] !== 200) {
            return $this->sendError(Code::FAIL);
        }
        $jsonArr = json_decode($curlRes[1], true);
        if(0 !== $jsonArr['errcode']) {
            return $this->sendError(Code::FAIL);
        }
        $accessToken = $jsonArr['access_token'];
        $redis->setEx($login_atkey, 7000, $accessToken);
        return $accessToken;
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
