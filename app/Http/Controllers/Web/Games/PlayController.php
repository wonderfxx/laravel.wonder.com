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
    public static $instance;

    /**
     * @return PlayController
     */
    public static function getInstance()
    {
        if (!is_null(self::$instance) && is_object(self::$instance))
        {
            return self::$instance;
        }
        self::$instance = new PlayController();

        return self::$instance;
    }
    
    /**
     *  渲染游戏页面
     *
     * @param      $gid
     * @param int  $sid
     * @param bool $isLogin
     *
     * @return mixed
     */
    public function play($gid, $sid = 1, $isLogin = false)
    {

        return (new \ReflectionClass('App\Http\Controllers\Web\Games\\' . ucfirst($gid) . 'InitController'))
            ->newInstance()
            ->play($sid, $isLogin);
    }

}