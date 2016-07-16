<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesResources;

class Controller extends BaseController
{
    use AuthorizesRequests, AuthorizesResources, DispatchesJobs, ValidatesRequests;

    public function post()
    {
    }

    /**
     * 设置记录日志的地址
     *
     * @param        $filename
     * @param string $logDirName
     */
    public function setLogPath($filename, $logDirName = 'channels')
    {
        \Log::useDailyFiles(storage_path() . '/logs/' . date('Ymd', time()) . '/' . $filename);
    }
}
