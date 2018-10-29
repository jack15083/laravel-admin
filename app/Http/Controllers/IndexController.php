<?php
/**
 * Created by PhpStorm.
 * User: zengfanwei
 * Date: 2018/10/19
 * Time: 15:54
 */

namespace App\Http\Controllers;


class IndexController extends Controller
{
    public function test()
    {
        return $this->sendJson();
    }
}