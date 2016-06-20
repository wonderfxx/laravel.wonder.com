<?php
/**
 * Created by PhpStorm.
 * User: wonder
 * Date: 16/6/18
 * Time: 下午4:01
 */

namespace libraries;

class CommonFunc
{
    protected static $authPasswordSalt = 'zXm1rUgHsLsotB745y';

    /**
     * Generate md5 auth
     *
     * @param        $data 数据
     * @param string $salt 密钥
     *
     * @return string
     */
    public static function makeMd5Auth($data, $salt = '')
    {
        if (empty($salt))
        {
            $salt = self::$authPasswordSalt;
        }

        return md5(md5($data) . $salt);
    }

    /**
     * Curl 远程提交数据
     *
     * @param       $url
     * @param array $data
     * @param int   $timeout
     *
     * @return bool|mixed
     */
    public static function curlRequest($url, $data = array(), $timeout = 10)
    {

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 2);
        if (!empty($_SERVER['HTTP_USER_AGENT']))
        {
            curl_setopt($curl, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
        }
        curl_setopt($curl, CURLOPT_AUTOREFERER, 1);
        if (!empty($data))
        {
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        }
        curl_setopt($curl, CURLOPT_TIMEOUT, $timeout);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $resultData = curl_exec($curl);
        $httpInfo   = curl_getinfo($curl);

        //记录日志
        $writeLogData = array(
            'urlAddress' => $url,
            'urlData'    => $data,
            'httpCode'   => $httpInfo['http_code'],
            'resultData' => $resultData
        );
        self::writeCurlLog($writeLogData);

        if (curl_errno($curl))
        {
            curl_close($curl);

            return false;
        }
        else
        {
            curl_close($curl);

            return $resultData;
        }
    }

    /**
     * Socket 模拟远程POST/GET请求
     *
     * @param        $urlAddress
     * @param string $data
     * @param bool   $head
     * @param string $port
     * @param string $timeout
     * @param string $contentType
     *
     * @return array
     */
    public static function socketRequest($urlAddress, $data = '', $head = false, $port = '80', $timeout = '10', $contentType = 'application/x-www-form-urlencoded')
    {

        // 处理请求数据
        $url        = parse_url($urlAddress);
        $scheme     = $url['scheme'];
        $host       = $url['host'];
        $path       = !empty($url['path']) ? $url['path'] : '';
        $query      = !empty($url['query']) ? "?" . $url['query'] : '';
        $resultInfo = array('result' => '', 'header' => array());
        $headerInfo = 1;

        // 区分请求协议
        if ($scheme == 'https')
        {
            $socket = fsockopen('ssl://' . $host, 443, $errno, $errstr, $timeout);
        }
        else
        {
            $socket = fsockopen($host, $port, $errno, $errstr, $timeout);
        }

        // POST 配置参数
        if (!empty($data))
        {
            if (is_array($data))
            {
                $data = http_build_query($data);
            }
            $http = "POST $path$query HTTP/1.1\r\n";
            $http .= "Host: $host\r\n";
            if (!empty($_SERVER['HTTP_USER_AGENT']))
            {
                $http .= "User-Agent: " . $_SERVER['HTTP_USER_AGENT'] . "\r\n";
            }
            $http .= "Content-Type: $contentType\r\n";
            $http .= "Content-length: " . strlen($data) . "\r\n";
            $http .= "Connection: close\r\n\r\n";
            $http .= $data . "\r\n\r\n";
        }
        else
        {
            $http = "GET $path$query HTTP/1.1\r\n";
            $http .= "Host: $host\r\n";
            if (!empty($_SERVER['HTTP_USER_AGENT']))
            {
                $http .= "User-Agent: " . $_SERVER['HTTP_USER_AGENT'] . "\r\n";
            }
            $http .= "User-Agent: " . $_SERVER['HTTP_USER_AGENT'] . "\r\n";
            $http .= "Accept: */*\r\n";
            $http .= "Connection: close\r\n\r\n";
        }

        // 发送头信息 + 获取数据 + 关闭请求
        fwrite($socket, $http);
        while (!feof($socket))
        {
            $line = fgets($socket, 4096);
            if ($headerInfo && ($line == "\n" || $line == "\r\n"))
            {
                $headerInfo = 0;
            }
            else if (!$headerInfo)
            {
                $resultInfo['result'] .= $line;
            }
            else
            {
                $resultInfo['header'][] = $line;
            }
        }
        fclose($socket);

        // 记录请求日志
        $writeLogData = array(
            'urlAddress' => $urlAddress,
            'urlData'    => $data,
            'httpCode'   => !empty($resultInfo['header'][0]) ? $resultInfo['header'][0] : '',
            'resultData' => !empty($resultInfo['result']) ? $resultInfo['result'] : '',
        );
        self::writeCurlLog($writeLogData);

        // 返回数据
        return !empty($head) ? $resultInfo : $resultInfo['result'];
    }

    /**
     * 记录日志
     *
     * @param array $data
     */
    public static function writeCurlLog($data = array())
    {
        \Log::info($data);
    }
}