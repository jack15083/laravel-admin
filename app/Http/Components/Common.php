<?php
/**
 * Created by PhpStorm.
 * User: zengfanwei
 * Date: 2017/7/10
 * Time: 17:42
 */

namespace App\Components;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class Common
{
    /**
     * 上传图片到本地服务器
     * @param Request $request
     * @param $key
     * @return array
     */
    public static function uploadImgToLocalStorage(Request $request, $key)
    {
        $res  = ['error' => 1, 'msg' => ''];
        $file = $request->file($key);

        if(!$file->isValid()) {
            $res['msg'] = '上传文件不合法';
            return $res;
        }

        $ext = $file->getClientOriginalExtension();
        if(!in_array($ext, ['jpg', 'png', 'gif'])) {
            $res['msg'] = '图片格式不正确';
            return $res;
        }

        $fileSize = $file->getClientSize();
        if($fileSize > 1024 * 1024 * 2) {
            $res['msg'] = '图片大小不能超过2M';
            return $res;
        }

        //存储文件。disk里面的public。总的来说，就是调用disk模块里的public配置
        $path = Storage::disk('public')->putFile('avatars', $file);

        $res['error']   = 0;
        $res['img_path'] = Storage::url($path);
        return $res;
    }

    /**
     * 密码加密
     * @param $password
     * @return bool|mixed|string
     */
    public static function hashPassword($password)
    {
        return password_hash($password, PASSWORD_DEFAULT, ['cost' => 12]);
    }

    /**
     * 生成菜单树
     * @param $list
     * @param $pid
     * @return array
     */
    public static function generateRuleTree($list, $pid)
    {
        $tree = [];
        foreach ($list as $row) {
            if($row['pid'] === $pid) {
                $row = [
                    'id'       => $row['id'],
                    'label'    => $row['title'],
                    'pid'      => $row['pid'],
                    'path'     => $row['name'],
                    'icon'     => $row['icon']
                ];

                $children = self::generateRuleTree($list, $row['id']);
                if(!empty($children)) {
                    $row['children'] = $children;
                }

                $tree[] = $row;
            }
        }

        return $tree;
    }

    /**
     * 检查路由权限
     * @param $path
     * @param $isPreg
     * @return bool
     */
    public static function checkPermission($path, $isPreg = false)
    {
        $loginInfo = session('loginInfo');
        $rules = $loginInfo['rules'] ?? [];

        if(empty($rules)) {
            return false;
        }

        if(!$isPreg) $path = preg_replace('/(^\/)|(\/$)/', '', $path);

        foreach ($rules as $value) {
            if(!$isPreg && $path === $value) {
                return true;
            }

            if($isPreg && preg_match($path, $value)) {
                return true;
            }
        }

        return false;
    }
}