<?php
/**
 * Created by PhpStorm.
 * User: wonder
 * Date: 16/6/18
 * Time: 下午4:01
 */

namespace libraries;

class PaymentStatus
{

    /**
     * @var array
     */
    public static $paymentStatus = [

        // 充值状态码
        '2000' => '发钻成功',
        '2001' => '未知原因',
        '2002' => '用户不存在',
        '2003' => '游戏币小于1',
        '2004' => '订单已存在',
        '2005' => 'IP限制',
        '2006' => '没有此代理',
        '2007' => '签名错误',
        '2008' => '参数错误',
        '2009' => '保存失败',
        '2010' => '无返回值',
        '2011' => '取消发钻',
        '2012' => '黑名单用户',
        '2013' => '风控限制',

        // 订单状态
        '3000' => 'settled',
        '3001' => 'refund',     // 退款，持卡人因为各种原因退款。
        '3002' => 'chargeback', // 是索回或拒付，是持卡人否认这笔交易(卡是被盗刷)
        '3003' => 'disputed',   // 存在争议
        '3004' => 'pending',    // pending一般是E-check（电子支票）从发卡银行开出，资金会到随后的一段时间到账，即cleared
        '3005' => 'canceled',   // 取消
        '3006' => 'reversal',   // 还款
        '3007' => 'placed',     // 默认状态,下单成功

        // 支付校验状态
        '4000' => '初始化充值',
        '4001' => '平台订单号不存在',
        '4002' => '实际支付金额或货币不相符',
        '4003' => '渠道订单号已经存在',
        '4004' => '更新渠道信息失败',
        '4005' => '无效的订单支付状态',
        '4006' => '更新发钻信息失败',
        '4007' => '更新发钻信息成功',
        '4008' => '无效的退款状态',
        '4009' => '无效的还款状态',
        '4010' => '操作退款失败',
        '4011' => '操作退款成功',
        '4012' => '操作还款失败',
        '4013' => '操作还款成功',

    ];

    /**
     * 获取发钻订单状态
     * @return array
     */
    public static function getSendCoinsStatus()
    {
        return [
            '2000' => self::$paymentStatus['2000'],
            '2001' => self::$paymentStatus['2001'],
            '2002' => self::$paymentStatus['2002'],
            '2003' => self::$paymentStatus['2003'],
            '2004' => self::$paymentStatus['2004'],
            '2005' => self::$paymentStatus['2005'],
            '2006' => self::$paymentStatus['2006'],
            '2007' => self::$paymentStatus['2007'],
            '2008' => self::$paymentStatus['2008'],
            '2009' => self::$paymentStatus['2009'],
            '2010' => self::$paymentStatus['2010'],
            '2011' => self::$paymentStatus['2011'],
            '2012' => self::$paymentStatus['2012'],
            '2013' => self::$paymentStatus['2013'],
        ];
    }

    /**
     * 获取支付订单状态
     * @return array
     */
    public static function getPayStatus()
    {
        return [
            '3000' => self::$paymentStatus['3000'],
            '3001' => self::$paymentStatus['3001'],
            '3002' => self::$paymentStatus['3002'],
            '3003' => self::$paymentStatus['3003'],
            '3004' => self::$paymentStatus['3004'],
            '3005' => self::$paymentStatus['3005'],
            '3006' => self::$paymentStatus['3006'],
            '3007' => self::$paymentStatus['3007'],
        ];
    }

    /**
     * 支付成功
     * @return array
     */
    public static function getPaySuccess()
    {
        return [
            3000, 3006
        ];
    }

    /**
     * 退款
     *
     * @return array
     */
    public static function getRefund()
    {
        return [
            3001, 3002
        ];
    }

    /**
     * 还款
     *
     * @return array
     */
    public static function getReversal()
    {
        return [
            3006
        ];
    }

    /**
     * 发钻成功
     *
     * @return array
     */
    public static function getRechargeSuccess()
    {
        return [
            2000, 2004
        ];
    }
}