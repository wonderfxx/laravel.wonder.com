<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\AdmUsersPwdReset
 *
 * @property integer $id
 * @property string $email 用户邮箱
 * @property string $token 重置令牌
 * @property \Carbon\Carbon $created_at 创建时间
 * @property integer $expired_at 失效时间
 * @method static \Illuminate\Database\Query\Builder|\App\Models\AdmUsersPwdReset whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\AdmUsersPwdReset whereEmail($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\AdmUsersPwdReset whereToken($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\AdmUsersPwdReset whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\AdmUsersPwdReset whereExpiredAt($value)
 * @mixin \Eloquent
 */
class AdmUsersPwdReset extends Model
{
    //
}
