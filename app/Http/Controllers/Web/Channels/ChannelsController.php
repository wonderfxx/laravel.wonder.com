<?php
/**
 * Created by PhpStorm.
 * User: wonder
 * Date: 16/6/25
 * Time: 上午6:12
 */

namespace App\Http\Controllers\Web\Channels;

use App\Http\Controllers\Controller;

class ChannelsController extends Controller
{

    /**
     * @param $channel
     *
     * @return mixed
     */
    public function initCallback($channel)
    {
        return (new \ReflectionClass('App\Http\Controllers\Web\Channels\\' . ucfirst($channel) . 'Controller'))
            ->newInstance()
            ->initCallback();
    }

}