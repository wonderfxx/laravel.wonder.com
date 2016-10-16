<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\GameServerList
 *
 * @property integer        $id                     自增ID
 * @property string         $game_code              游戏简写
 * @property string         $server_id              服务器ID
 * @property string         $server_type            服务器类型
 * @property string         $server_name            服务器名称
 * @property integer        $server_open_at         开服时间
 * @property integer        $server_close_at        关服时间
 * @property string         $server_lang            语言
 * @property string         $server_region          地区
 * @property string         $server_address         服务器地址
 * @property \Carbon\Carbon $created_at             创建时间
 * @property \Carbon\Carbon $updated_at             更新时间
 * @property string         $status                 启用状态
 * @method static \Illuminate\Database\Query\Builder|\App\Models\GameServerList whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\GameServerList whereGameCode($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\GameServerList whereServerId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\GameServerList whereServerType($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\GameServerList whereServerName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\GameServerList whereServerOpenAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\GameServerList whereServerCloseAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\GameServerList whereServerLang($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\GameServerList whereServerRegion($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\GameServerList whereServerAddress($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\GameServerList whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\GameServerList whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\GameServerList whereStatus($value)
 * @mixin \Eloquent
 */
class GameServerList extends Model
{
    public $timestamps = false;

    //
    public static function getColumns()
    {
        $data   = preg_split("/[\n]+/", (new \ReflectionClass(self::class))->getDocComment());
        $return = [];
        foreach ($data as $k => $value)
        {
            if (strstr($value, '@property'))
            {
                $temp           = preg_split("/[\s]+/", trim(str_replace(' * @property ', '', $value)));
                $index          = str_replace('$', '', $temp[1]);
                $return[$index] = [
                    'field' => $index,
                    'title' => ($temp[2]),
                    'align' => 'center',
                ];
            }
        }
        $return['operation'] = [
            'field' => 'operation',
            'title' => '操作',
            'align' => 'center',
        ];

        return $return;
    }
}
