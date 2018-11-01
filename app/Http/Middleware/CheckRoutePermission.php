<?php
/**
 * Created by PhpStorm.
 * User: zengfanwei
 * Date: 2018/10/31
 * Time: 14:25
 */

namespace App\Http\Middleware;

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
        return $next($request);
    }

}