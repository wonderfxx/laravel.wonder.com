<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\GameList
 *
 * @property integer        $id                          自增ID
 * @property string         $game_code                   游戏简写
 * @property string         $game_name                   游戏名称
 * @property string         $game_coins_name             游戏币
 * @property string         $game_type                   游戏类型
 * @property string         $game_logo                   游戏图片
 * @property float          $proportion_usd              美金兑换比例
 * @property float          $proportion_local            本地货币比例
 * @property string         $proportion_local_currency   本地货币
 * @property float          $proportion_cp               CP结算比例
 * @property string         $proportion_cp_currency      CP结算货币
 * @property string         $recharge_api                充值API
 * @property string         $charge_back_api             退款API
 * @property string         $server_list_api             服务器API
 * @property string         $user_role_api               角色API
 * @property \Carbon\Carbon $created_at                  创建时间
 * @property \Carbon\Carbon $updated_at                  更新时间
 * @property string         $game_status                 游戏状态
 * @property string         $kongregate_api_key          KongregateKey
 * @property string         $kongregate_api_gid          KongregateGid
 * @property string         $kongregate_guest_key        KongregateGuestKey
 * @method static \Illuminate\Database\Query\Builder|\App\Models\GameList whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\GameList whereGameCode($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\GameList whereGameName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\GameList whereGameStatus($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\GameList whereGameCoinsName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\GameList whereGameType($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\GameList whereGameLogo($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\GameList whereProportionUsd($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\GameList whereProportionLocal($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\GameList whereProportionLocalCurrency($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\GameList whereProportionCp($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\GameList whereProportionCpCurrency($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\GameList whereRechargeApi($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\GameList whereChargeBackApi($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\GameList whereServerListApi($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\GameList whereUserRoleApi($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\GameList whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\GameList whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\GameList whereKongregateApiKey($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\GameList whereKongregateApiGid($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\GameList whereKongregateGuestKey($value)
 * @mixin \Eloquent
 */
class GameList extends Model
{
    public $timestamps = false;

    /**
     * 获取用户信息
     *
     * @param $gid
     *
     * @return Model|mixed|null|static
     */
    public static function getGameInfo($gid)
    {
        return self::whereGameCode($gid)->first();
    }

    /**
     * 获取CP专递货币和金额
     *
     * @param $gid
     * @param $game_coins
     *
     * @return array
     */
    public static function getCpAmountCurrnecy($gid, $game_coins)
    {
        $gameInfo = self::getGameInfo($gid);

        return [
            'amount'   => number_format($game_coins / $gameInfo->proportion_cp, 2, '.', ''),
            'currency' => $gameInfo->proportion_cp_currency,
        ];
    }

    /**
     * 获取字段名称
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
        $return['operation'] = [
            'field' => 'operation',
            'title' => '操作',
            'align' => 'center',
        ];

        return $return;
    }

    /**
     *  游戏列表
     *
     * @return array
     */
    public static function getGameNames()
    {

        $return = [];
        $data   = self::whereGameStatus('Y')->get(['game_name', 'game_code']);
        foreach ($data as $item) {
            $return[$item->game_code] = $item->game_name;
        }

        return $return;
    }
}
