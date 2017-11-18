<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\UsersLoginLog
 * @property integer        $id                     自增ID
 * @property integer        $userid                 GMT-ID
 * @property string         $login_ip               登陆IP
 * @property \Carbon\Carbon $created_at             登陆时间
 * @mixin \Eloquent
 */
class UsersLoginLog extends Model
{

    protected $primaryKey = 'id';
    public    $timestamps = false;
    protected $fillable   = ['userid', 'login_ip', 'created_at'];

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

    /**
     * 访问日志
     *
     * @param $userid
     */
    public static function recordLoginLog($userid)
    {

        self::create([
                         'userid'     => $userid,
                         'login_ip'   => \Request::getClientIp(),
                         'created_at' => time(),
                     ]);
    }

    /**
     * 获取每日登陆人数
     *
     * @param        $start
     * @param string $end
     *
     * @return array
     */
    public static function getLoginUser($start, $end = '')
    {

        $date_start = strtotime($start);
        $end        = !empty($end) ? $end . ' 23:59:59' : date('Y-m-d', time()) . ' 23:59:59';
        $date_end   = !empty($end) ? ' and `created_at` <=' . strtotime($end) : '';

        $sql  = "SELECT userid,created_at FROM `users_login_log`";
        $sql  .= "where created_at>=" . $date_start . $date_end;
        $data = \DB::select($sql);

        $result = [
            'value' => [],
            'date'  => [],
        ];
        foreach ($data as $item) {
            $date = date('Y-m-d', $item->created_at);
            @$result['value'][$date][$item->userid] = 1;
            @$result['date'][$date] = $date;
        }
        $nums = [];
        foreach ($result['value'] as $k => $v) {
            $nums[] = count($v);
        }

        return [
            'date'  => array_values($result['date']),
            'value' => $nums,
        ];
    }

}
