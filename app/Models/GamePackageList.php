<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\GamePackageList
 *
 * @property integer $id
 * @property string $game_code 游戏简写
 * @property string $country 发布地区
 * @property string $channel_code 渠道简写
 * @property string $channel_sub_code 子渠道简写
 * @property float $amount 支付金额
 * @property string $currency 支付货币
 * @property string $currency_show 显示货币
 * @property float $amount_usd 美金金额
 * @property integer $game_coins 游戏币
 * @property integer $game_coins_rewards 奖励币
 * @property string $product_id 产品唯一ID
 * @property string $product_name 产品名称
 * @property string $product_description 产品描述
 * @property string $product_type 产品类型
 * @property string $product_logo 套餐图片
 * @property string $status 启用状态
 * @property \Carbon\Carbon $created_at 创建时间
 * @property \Carbon\Carbon $updated_at 更新时间
 * @method static \Illuminate\Database\Query\Builder|\App\Models\GamePackageList whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\GamePackageList whereGameCode($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\GamePackageList whereCountry($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\GamePackageList whereChannelCode($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\GamePackageList whereChannelSubCode($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\GamePackageList whereAmount($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\GamePackageList whereCurrency($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\GamePackageList whereCurrencyShow($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\GamePackageList whereAmountUsd($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\GamePackageList whereGameCoins($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\GamePackageList whereGameCoinsRewards($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\GamePackageList whereProductId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\GamePackageList whereProductName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\GamePackageList whereProductDescription($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\GamePackageList whereProductType($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\GamePackageList whereProductLogo($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\GamePackageList whereStatus($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\GamePackageList whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\GamePackageList whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class GamePackageList extends Model
{
    //
    public    $timestamps = false;
}
