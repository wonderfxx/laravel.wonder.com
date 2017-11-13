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
 * @property string         $kongregate_api_key     API_KEY
 * @property string         $kongregate_api_gid     API_GID
 * @property string         $kongregate_guest_key   API_GUEST_KEY
 * @method static GameServerList whereId($value)
 * @method static GameServerList whereGameCode($value)
 * @method static GameServerList whereServerId($value)
 * @method static GameServerList whereServerType($value)
 * @method static GameServerList whereServerName($value)
 * @method static GameServerList whereServerOpenAt($value)
 * @method static GameServerList whereServerCloseAt($value)
 * @method static GameServerList whereServerLang($value)
 * @method static GameServerList whereServerRegion($value)
 * @method static GameServerList whereServerAddress($value)
 * @method static GameServerList whereCreatedAt($value)
 * @method static GameServerList whereUpdatedAt($value)
 * @method static GameServerList whereStatus($value)
 * @mixin \Eloquent
 * @method static GameServerList whereKongregateApiGid($value)
 * @method static GameServerList whereKongregateApiKey($value)
 * @method static GameServerList whereKongregateGuestKey($value)
 */
class GameServerList extends Model
{

    public $timestamps = false;

    //
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
        $return['operation'] = [
            'field' => 'operation',
            'title' => '操作',
            'align' => 'center',
        ];

        return $return;
    }
}
