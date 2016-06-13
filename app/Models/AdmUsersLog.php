<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\AdmUsersLog
 *
 * @property integer $userid 帐号ID
 * @property string $login_ip 登录IP
 * @property string $browser 浏览器
 * @property \Carbon\Carbon $created_at 登录时间
 * @method static \Illuminate\Database\Query\Builder|\App\Models\AdmUsersLog whereUserid($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\AdmUsersLog whereLoginIp($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\AdmUsersLog whereBrowser($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\AdmUsersLog whereCreatedAt($value)
 * @mixin \Eloquent
 */
class AdmUsersLog extends Model
{
    //
}
