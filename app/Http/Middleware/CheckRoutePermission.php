<?php
/**
 * Created by PhpStorm.
 * User: zengfanwei
 * Date: 2018/10/31
 * Time: 14:25
 */

namespace App\Http\Middleware;

use App\Components\Code;
use App\Components\Common;
use App\Http\Controllers\Controller;
use App\SystemLogs;
use Closure;

class CheckRoutePermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $loginInfo = session('loginInfo');
        $base = new Controller($request);
        if(empty($loginInfo)) {
            return $base->sendError(Code::UN_LOGIN);
        }

        //检查权限
        if(!Common::checkPermission($request->getPathInfo())) {
            return $base->sendError(Code::NO_PERMISSION, sprintf(Code::getError(Code::NO_PERMISSION),
                $request->getPathInfo()));
        }

        $this->saveSystemLogs($request);
        return $next($request);
    }

    /**
     * 保存系统操作日志
     * @param  \Illuminate\Http\Request  $request
     */
    public function saveSystemLogs($request)
    {
        $params = $request->all();
        if(isset($params['password'])) unset($params['password']);

        SystemLogs::getInstance()->saveData([
            'func'     => $request->getPathInfo(),
            'url'      => $request->getRequestUri(),
            'ip'       => $request->getClientIp(),
            'details'  => json_encode($params),
            'admin_id' => 1,
            'operator' => 'god'
        ]);
    }

}