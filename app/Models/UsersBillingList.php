<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\UsersBillingList
 *
 * @property integer $fg_order_id        平台订单号
 * @property string  $game_code          游戏简写
 * @property string  $server_id          服务器
 * @property string  $country            发布地区
 * @property string  $channel_code       渠道简写
 * @property string  $channel_sub_code   子渠道简写
 * @property string  $channel_order_id   渠道订单号
 * @property string  $channel_phone      支付手机
 * @property string  $channel_email      支付邮箱
 * @property integer $channel_pay_time   支付时间
 * @property integer $channel_status     支付状态
 * @property integer $user_id            用户标示
 * @property string  $user_grade         用户等级
 * @property string  $user_role          用户角色
 * @property string  $user_role_id       用户角色ID
 * @property string  $user_ip_address    支付IP
 * @property float   $amount             支付金额
 * @property string  $currency           支付货币
 * @property float   $amount_usd         美金金额
 * @property integer $game_coins         游戏币
 * @property integer $game_coins_rewards 奖励币
 * @property string  $product_id         产品唯一ID
 * @property string  $product_type       产品类型
 * @property integer $created_time       下单时间
 * @property integer $send_coins_status  发钻状态
 * @property integer $send_time          发钻时间
 * @property string  $is_test            测试订单
 * @method static \Illuminate\Database\Query\Builder|\App\Models\UsersBillingList whereFgOrderId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\UsersBillingList whereGameCode($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\UsersBillingList whereServerId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\UsersBillingList whereCountry($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\UsersBillingList whereChannelCode($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\UsersBillingList whereChannelSubCode($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\UsersBillingList whereChannelOrderId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\UsersBillingList whereChannelPhone($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\UsersBillingList whereChannelEmail($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\UsersBillingList whereChannelPayTime($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\UsersBillingList whereChannelStatus($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\UsersBillingList whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\UsersBillingList whereUserGrade($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\UsersBillingList whereUserRole($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\UsersBillingList whereUserRoleId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\UsersBillingList whereUserIpAddress($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\UsersBillingList whereAmount($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\UsersBillingList whereCurrency($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\UsersBillingList whereAmountUsd($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\UsersBillingList whereGameCoins($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\UsersBillingList whereGameCoinsRewards($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\UsersBillingList whereProductId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\UsersBillingList whereProductType($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\UsersBillingList whereCreatedTime($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\UsersBillingList whereSendCoinsStatus($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\UsersBillingList whereSendTime($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\UsersBillingList whereIsTest($value)
 * @mixin \Eloquent
 * @property integer $updated_time       变更时间
 * @method static \Illuminate\Database\Query\Builder|\App\Models\UsersBillingList whereUpdatedTime($value)
 * @property integer $package_id         套餐编号
 * @method static \Illuminate\Database\Query\Builder|\App\Models\UsersBillingList wherePackageId($value)
 */
class UsersBillingList extends Model
{

    public $timestamps = false;

    /**
     *  变更订单状态
     *
     * @param $fg_order_id
     * @param $status
     *
     * @return bool|int
     */
    public static function recordChange($fg_order_id, $status)
    {
        return self::whereFgOrderId($fg_order_id)
                   ->update([
                                'channel_status' => $status,
                                'updated_time'   => time()
                            ]);
    }

    /**
     *
     * 更新发钻状态
     *
     * @param $fg_order_id
     * @param $status
     *
     * @return bool|int
     */
    public static function updateSendStatus($fg_order_id, $status)
    {
        return self::whereFgOrderId($fg_order_id)
                   ->update([

                                'send_coins_status' => $status,
                                'send_time'         => time(),
                            ]);
    }

    /**
     * 当前表列名称
     *
     * @return array
     */
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
