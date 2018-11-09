<?php
/**
 * Created by PhpStorm.
 * User: zengfanwei
 * Date: 2018/10/31
 * Time: 14:23
 */

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    protected $loginInfo;

    public function __construct(Request $request)
    {
        parent::__construct($request);

        //检查权限
        $this->middleware('admin');
    }

    public function setLoginInfo()
    {
        $this->loginInfo = session('loginInfo');
    }

    public function canAdd()
    {
        return true;
    }

    public function canEdit()
    {
        return true;
    }

    public function canDelete()
    {
        return true;
    }

}