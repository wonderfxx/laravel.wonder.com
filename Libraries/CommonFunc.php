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
     * @param $password
     *
     * @return string
     */
    public static function makeMd5Auth($password)
    {
        return md5(md5($password) . self::$authPasswordSalt);
    }
}