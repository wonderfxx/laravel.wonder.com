<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\GamePackageList
 *
 * @property integer        $id                     套餐ID
 * @property string         $game_code              游戏简写
 * @property string         $country                发布地区
 * @property string         $channel_code           渠道简写
 * @property string         $channel_sub_code       子渠道简写
 * @property float          $amount                 支付金额
 * @property string         $currency               支付货币
 * @property string         $currency_show          显示货币
 * @property float          $amount_usd             美金金额
 * @property integer        $game_coins             游戏币
 * @property integer        $game_coins_rewards     奖励币
 * @property string         $package_id             套餐ID
 * @property string         $product_id             产品唯一ID
 * @property string         $product_name           产品名称
 * @property string         $product_description    产品描述
 * @property string         $product_type           产品类型
 * @property string         $product_logo           套餐图片
 * @property string         $status                 启用状态
 * @property \Carbon\Carbon $created_at             创建时间
 * @property \Carbon\Carbon $updated_at             更新时间
 * @method static GamePackageList whereId($value)
 * @method static GamePackageList whereGameCode($value)
 * @method static GamePackageList whereCountry($value)
 * @method static GamePackageList whereChannelCode($value)
 * @method static GamePackageList whereChannelSubCode($value)
 * @method static GamePackageList whereAmount($value)
 * @method static GamePackageList whereCurrency($value)
 * @method static GamePackageList whereCurrencyShow($value)
 * @method static GamePackageList whereAmountUsd($value)
 * @method static GamePackageList whereGameCoins($value)
 * @method static GamePackageList whereGameCoinsRewards($value)
 * @method static GamePackageList wherePackageId($value)
 * @method static GamePackageList whereProductId($value)
 * @method static GamePackageList whereProductName($value)
 * @method static GamePackageList whereProductDescription($value)
 * @method static GamePackageList whereProductType($value)
 * @method static GamePackageList whereProductLogo($value)
 * @method static GamePackageList whereStatus($value)
 * @method static GamePackageList whereCreatedAt($value)
 * @method static GamePackageList whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class GamePackageList extends Model
{
    //
    public $timestamps = false;

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
