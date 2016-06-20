<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\GameList
 *
 * @property integer        $id
 * @property string         $game_code                 游戏简写
 * @property string         $game_name                 游戏名称
 * @property string         $game_status               游戏状态
 * @property string         $game_coins_name           游戏币
 * @property string         $game_type                 游戏类型
 * @property string         $game_logo                 游戏图片
 * @property float          $proportion_usd            美金兑换比例
 * @property float          $proportion_local          本地货币比例
 * @property string         $proportion_local_currency 本地货币
 * @property float          $proportion_cp             CP结算比例
 * @property string         $proportion_cp_currency    CP结算货币
 * @property string         $recharge_api
 * @property string         $charge_back_api
 * @property string         $server_list_api
 * @property string         $user_role_api
 * @property \Carbon\Carbon $created_at                创建时间
 * @property \Carbon\Carbon $updated_at                更新时间
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
 * @mixin \Eloquent
 */
class GameList extends Model
{
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
}
