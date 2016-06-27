<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * App\Models\User
 *
 * @property integer        $userid      用户ID
 * @property string         $username    用户名
 * @property string         $password    用户密码
 * @property string         $email       用户邮箱
 * @property string         $remember    记住密码
 * @property string         $register_ip 注册IP
 * @property string         $login_ip    登陆IP
 * @property string         $status      用户状态
 * @property \Carbon\Carbon $created_at  创建时间
 * @property \Carbon\Carbon $updated_at  更新时间
 * @method static \Illuminate\Database\Query\Builder|\App\Models\AdmUser whereUserid($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\AdmUser whereUsername($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\AdmUser wherePassword($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\AdmUser whereEmail($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\AdmUser whereRemember($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\AdmUser whereRegisterIp($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\AdmUser whereLoginIp($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\AdmUser whereStatus($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\AdmUser whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\AdmUser whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property string $sns_id 社交ID
 * @property string $ad_source 用户来源
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User whereSnsId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User whereAdSource($value)
 */
class User extends Authenticatable
{

    protected $primaryKey = 'userid';
    public    $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username', 'email', 'register_ip',
        'created_at', 'login_ip', 'updated_at', 'ad_source', 'status',
        'password', 'sns_id'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [

    ];

    /**
     * 当前表列名称
     *
     * @return array
     */
    public static function getColumns()
    {
        $data   = preg_split("/[\n]+/", (new \ReflectionClass(self::class))->getDocComment());
        $return = [];
        foreach ($data as $k => $value)
        {
            if (strstr($value, '@property'))
            {
                $temp     = preg_split("/[\s]+/", trim(str_replace(' * @property ', '', $value)));
                $index    = str_replace('$', '', $temp[1]);
                $return[$index] = [
                    'field' => $index,
                    'title' => ($temp[2]),
                    'align' => 'center',
                ];
            }
        }

        return $return;
    }

}
