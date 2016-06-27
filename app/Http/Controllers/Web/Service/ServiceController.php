<?php
/**
 * Created by PhpStorm.
 * User: wonder
 * Date: 16/6/25
 * Time: 上午6:12
 */

namespace App\Http\Controllers\Web\Service;

use App\Http\Controllers\Controller;

class ServiceController extends Controller
{

    /**
     * 服务请求
     *
     * @param $service
     * @param $action
     *
     * @return mixed
     */
    public function initService($service, $action)
    {

        return (new \ReflectionClass('App\Http\Controllers\Web\Service\\' . ucfirst($service) . 'ServiceController'))
            ->newInstance()->$action();
    }

}