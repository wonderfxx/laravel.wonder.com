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
 * @property integer $user_id            GMT-ID
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
 * @method static UsersBillingList whereFgOrderId($value)
 * @method static UsersBillingList whereGameCode($value)
 * @method static UsersBillingList whereServerId($value)
 * @method static UsersBillingList whereCountry($value)
 * @method static UsersBillingList whereChannelCode($value)
 * @method static UsersBillingList whereChannelSubCode($value)
 * @method static UsersBillingList whereChannelOrderId($value)
 * @method static UsersBillingList whereChannelPhone($value)
 * @method static UsersBillingList whereChannelEmail($value)
 * @method static UsersBillingList whereChannelPayTime($value)
 * @method static UsersBillingList whereChannelStatus($value)
 * @method static UsersBillingList whereUserId($value)
 * @method static UsersBillingList whereUserGrade($value)
 * @method static UsersBillingList whereUserRole($value)
 * @method static UsersBillingList whereUserRoleId($value)
 * @method static UsersBillingList whereUserIpAddress($value)
 * @method static UsersBillingList whereAmount($value)
 * @method static UsersBillingList whereCurrency($value)
 * @method static UsersBillingList whereAmountUsd($value)
 * @method static UsersBillingList whereGameCoins($value)
 * @method static UsersBillingList whereGameCoinsRewards($value)
 * @method static UsersBillingList whereProductId($value)
 * @method static UsersBillingList whereProductType($value)
 * @method static UsersBillingList whereCreatedTime($value)
 * @method static UsersBillingList whereSendCoinsStatus($value)
 * @method static UsersBillingList whereSendTime($value)
 * @method static UsersBillingList whereIsTest($value)
 * @mixin \Eloquent
 * @property integer $updated_time       变更时间
 * @method static UsersBillingList whereUpdatedTime($value)
 * @property integer $package_id         套餐编号
 * @method static UsersBillingList wherePackageId($value)
 */
class UsersBillingList extends Model
{

    protected $primaryKey = 'fg_order_id';
    public    $timestamps = false;

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
                   ->update(
                       [
                           'channel_status' => $status,
                           'updated_time'   => time(),
                       ]
                   );
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
                   ->update(
                       [

                           'send_coins_status' => $status,
                           'send_time'         => time(),
                       ]
                   );
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
     * 统计汇总
     *
     * @param        $start
     * @param string $end
     *
     * @return array
     */
    public static function getStatistic($start, $end = '')
    {

        $data = self::getOrderList($start, $end);

        /**
         * 获取每日用户的转化率
         *
         * conversion
         */
        $conversion = [
            'placed_nums' => [],
            'pay_nums'    => [],
            'date'        => [],
            'percent'     => [],
        ];
        /**
         *
         * recharge
         */
        $recharge = [
            'total' => 0,
            'value' => [],
            'date'  => [],
        ];

        foreach ($data as $items) {

            $date = date('Y-m-d', $items->created_time);

            /**
             * conversion
             */
            @$conversion['placed_nums'][$date] += 1;
            if (in_array($items->send_coins_status, ['2000', '2004'])) {
                @$conversion['pay_nums'][$date] += 1;
            }
            @$conversion['date'][$date] = $date;

            /**
             * 获取每日营收
             *
             * recharge
             */
            $amount = number_format($items->amount / 10, '2', '.', '');
            if (in_array($items->send_coins_status, ['2000', '2004'])) {
                @$recharge['value'][$date] += $amount;
                $recharge['total'] += $amount;
            }
            else {
                @$recharge['value'][$date] += 0;
            }
            @$recharge['date'][$date] = $date;
        }
        /**
         * conversion
         */
        foreach ($conversion['placed_nums'] as $key => $item) {
            $pay                         = isset($conversion['pay_nums'][$key]) ? $conversion['pay_nums'][$key] : 0;
            $conversion['percent'][$key] = number_format($pay / $item, '4', '.', '') * 100;
        }

        return [
            'conversion' => $conversion,
            'recharge'   => $recharge,
        ];
    }

    /**
     * 订单笔数用户笔数
     *
     * @param        $start
     * @param string $end
     *
     * @return array
     */
    public static function getOrderCount($start, $end = '')
    {

        $date_start = strtotime($start);
        $end        = !empty($end) ? $end . ' 23:59:59' : date('Y-m-d', time()) . ' 23:59:59';
        $date_end   = !empty($end) ? ' and `created_time` <=' . strtotime($end) : '';

        $sql  = "SELECT count(fg_order_id) AS orders,count(DISTINCT user_id) AS users FROM `users_billing_lists`";
        $sql  .= "where send_coins_status in('2000','2004') and created_time>=" . $date_start . $date_end;
        $data = \DB::select($sql);

        return [
            'orders' => $data[0]->orders,
            'users'  => $data[0]->users,
        ];
    }

    /**
     * 指定时间内的订单
     *
     * @param        $start
     * @param string $end
     *
     * @return mixed
     */
    private static function getOrderList($start, $end = '')
    {

        $date_start = strtotime($start);
        $end        = !empty($end) ? $end . ' 23:59:59' : date('Y-m-d', time()) . ' 23:59:59';
        $date_end   = !empty($end) ? ' and `created_time` <=' . strtotime($end) : '';
        $sql        =
            "SELECT created_time,send_coins_status,amount FROM `users_billing_lists` WHERE `created_time`>= $date_start $date_end ";

        return \DB::select($sql);
    }
}
