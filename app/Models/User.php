<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * App\Models\User
 *
 * @property integer        $userid                 GMT-ID
 * @property string         $username               用户名
 * @property string         $password               用户密码
 * @property string         $email                  用户邮箱
 * @property string         $remember               记住密码
 * @property string         $register_ip            注册IP
 * @property string         $login_ip               登陆IP
 * @property string         $status                 用户状态
 * @property string         $last_login_game        用户最近登录游戏
 * @property integer        $last_login_server      用户最近登录服务器
 * @property \Carbon\Carbon $created_at             创建时间
 * @property \Carbon\Carbon $updated_at             更新时间
 * @method static AdmUser whereUserid($value)
 * @method static AdmUser whereUsername($value)
 * @method static AdmUser wherePassword($value)
 * @method static AdmUser whereEmail($value)
 * @method static AdmUser whereRemember($value)
 * @method static AdmUser whereRegisterIp($value)
 * @method static AdmUser whereLoginIp($value)
 * @method static AdmUser whereStatus($value)
 * @method static AdmUser whereCreatedAt($value)
 * @method static AdmUser whereUpdatedAt($value)
 * @method static AdmUser whereLastLoginGame($value)
 * @method static AdmUser whereLastLoginServer($value)
 * @mixin \Eloquent
 * @property string         $sns_id                 社交ID
 * @property string         $ad_source              用户来源
 * @method static User whereSnsId($value)
 * @method static User whereAdSource($value)
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
        'username',
        'email',
        'register_ip',
        'created_at',
        'login_ip',
        'updated_at',
        'ad_source',
        'status',
        'password',
        'sns_id',
        'last_login_game',
        'last_login_server',
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
        foreach ($data as $k => $value) {
            if (strstr($value, '@property')) {
                $temp           = preg_split("/[\s]+/", trim(str_replace(' * @property ', '', $value)));
                $index          = str_replace('$', '', $temp[1]);
                $return[$index] = [
                    'field' => $index,
                    'title' => ($temp[2]),
                    'align' => 'center',
                ];
            }
        }

        return $return;
    }

    public static function getRegUsers($start, $end)
    {

        $date_start = strtotime($start);
        $end        = !empty($end) ? $end . ' 23:59:59' : date('Y-m-d', time()) . ' 23:59:59';
        $date_end   = !empty($end) ? ' and `created_at` <=' . strtotime($end) : '';
        $sql        = "select userid,created_at from `users` where created_at>=" . $date_start . $date_end;
        $data       = \DB::select($sql);

        $result          = [
            'users' => 0,
            'date'  => [],
            'value' => [],
        ];
        $result['users'] = 0;
        foreach ($data as $items) {
            $date = date('Y-m-d', $items->created_at);
            @$result['value'][$date] += 1;
            $result['users'] += 1;
            @$result['date'][$date] = $date;
        }

        return $result;
    }

    public static function getLoginUsers($start, $end)
    {

        $date_start = strtotime($start);
        $end        = !empty($end) ? $end . ' 23:59:59' : date('Y-m-d', time()) . ' 23:59:59';
        $date_end   = !empty($end) ? ' and `created_at` <=' . strtotime($end) : '';
        $sql        =
            "select count(userid) as total,from_unixtime(`updated_at`,'%Y-%m-%d') as ctime from `users`";
        $sql        .= "where updated_at!=0 and created_at>=" . $date_start . $date_end . " group by ctime";
        $data       = \DB::select($sql);

        $result = [];
        foreach ($data as $items) {
            $result['date'][]  = $items->ctime;
            $result['value'][] = $items->total ? (int)$items->total : 0;
        }

        return $result;
    }
}
