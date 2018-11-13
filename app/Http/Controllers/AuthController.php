<?php
/**
 * Created by PhpStorm.
 * User: zengfanwei
 * Date: 2018/10/31
 * Time: 14:23
 */

namespace App\Http\Controllers;

use App\Components\Common;
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
        $path = dirname($this->request->getPathInfo()) . '/save';
        if(Common::checkPermission($path)) {
            return true;
        }

        return false;
    }

    public function canEdit()
    {
        $path = dirname($this->request->getPathInfo()) . '/save';
        if(Common::checkPermission($path)) {
            return true;
        }

        return false;
    }

    public function canDelete()
    {
        $path = dirname($this->request->getPathInfo()) . '/delete';
        if(Common::checkPermission($path)) {
            return true;
        }

        return false;
    }

}