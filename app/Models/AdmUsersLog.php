<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\AdmUsersLog
 *
 * @property integer        $userid     帐号ID
 * @property string         $login_ip   登录IP
 * @property string         $browser    浏览器
 * @property \Carbon\Carbon $created_at 登录时间
 * @method static AdmUsersLog whereUserid($value)
 * @method static AdmUsersLog whereLoginIp($value)
 * @method static AdmUsersLog whereBrowser($value)
 * @method static AdmUsersLog whereCreatedAt($value)
 * @mixin \Eloquent
 */
class AdmUsersLog extends Model
{

    public    $timestamps = false;
    protected $primaryKey = 'userid';
}
