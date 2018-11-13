<?php
/**
 * 错误码常量类
 * User: zengfanwei
 * Date: 2017/6/21
 * Time: 17:14
 */

namespace App\Components;


class Code
{
    const SUCCESS = 0;
    const FAIL = 1;
    const SERVER_ERROR = 2;
    const DATABASE_ERROR = 3;
    const UN_LOGIN = 4;
    const LOGIN_ERROR = 5;
    const NO_PERMISSION = 6;

    const GROUP_EXIST = 1001;
    const RULE_EXIST = 1002;
    const ADMIN_EXIST = 1003;
    const OLD_PASSWORD_WRONG = 1004;
    const LOGIN_TRY_ERROR = 1005;

    public static $message = [
        self::SUCCESS => '成功',
        self::FAIL => '失败',
        self::SERVER_ERROR => '服务器错误',
        self::DATABASE_ERROR => '数据库正忙请稍后再试',
        self::UN_LOGIN => '未登录',

        self::GROUP_EXIST => '用户组名称已存在!',
        self::RULE_EXIST => '路径已存在！',
        self::ADMIN_EXIST => '用户名已存在！',
        self::OLD_PASSWORD_WRONG => '原密码错误',
        self::LOGIN_ERROR => '用户名或密码错误！',
        self::LOGIN_TRY_ERROR => '输错密码次数太多，请一小时后再试！',
        self::NO_PERMISSION => '没有%s的接口权限，请联系管理员！'
    ];

    public static function getError($code)
    {
        return isset(self::$message[$code]) ? self::$message[$code] : self::$message[self::SERVER_ERROR];
    }
}