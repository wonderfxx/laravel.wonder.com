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
        '2000'  => '发钻成功',
        '2001'  => '未知原因',
        '2002'  => '用户不存在',
        '2003'  => '游戏币小于1',
        '2004'  => '订单已存在',
        '2005'  => 'IP限制',
        '2006'  => '没有此代理',
        '2007'  => '签名错误',
        '2008'  => '参数错误',
        '2009'  => '保存失败',
        '2010'  => '无返回值',
        '2011'  => '取消发钻',
        '2012'  => '黑名单用户',
        '2013'  => '风控限制',

        // 订单状态
        '3000'  => 'settled',
        '3001'  => 'refund',     // 退款，持卡人因为各种原因退款。
        '3002'  => 'chargeback', // 是索回或拒付，是持卡人否认这笔交易(卡是被盗刷)
        '3003'  => 'disputed',   // 存在争议
        '3004'  => 'pending',    // pending一般是E-check（电子支票）从发卡银行开出，资金会到随后的一段时间到账，即cleared
        '3005'  => 'canceled',   // 取消
        '3006'  => 'reversal',   // 还款
        '3007'  => 'placed',     // 默认状态,下单成功

        //校验状态
        '4001' => '平台订单号不存在',
        '4002' => '实际支付金额或货币不相符',
        '4003' => '渠道订单号已经存在',
        '4004' => '更新渠道信息失败',
        '4005' => '更新发钻信息失败',
        '4006' => '无效的订单支付状态',
        ''

    ];

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
    public static function getRefund(){
        return [
            3001, 3002
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