<?php
/**
 * Created by PhpStorm.
 * User: wonder
 * Date: 16/6/25
 * Time: 上午6:12
 */

namespace App\Http\Controllers\Web\Games;

use App\Http\Controllers\Controller;

class PlayController extends Controller
{

    /**
     * 渲染游戏页面
     *
     * @param     $gid
     * @param int $sid
     *
     * @return mixed
     */
    public function play($gid, $sid = 1)
    {

        return (new \ReflectionClass('App\Http\Controllers\Web\Games\\' . ucfirst($gid) . 'InitController'))
            ->newInstance()
            ->play($sid);
    }
}