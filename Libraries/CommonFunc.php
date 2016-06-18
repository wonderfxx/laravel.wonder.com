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

}