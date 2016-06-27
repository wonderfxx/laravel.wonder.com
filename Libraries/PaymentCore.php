<?php

namespace libraries;

use App\Models\UsersBillingList;

/**
 *
 * 处理支付渠道订单逻辑
 * 操作充值、退款、还款
 *
 * Class PaymentCore
 */
class PaymentCore
{

    //平台信息
    public $fg_order_id;

    //渠道信息
    public $channel_code;
    public $channel_sub_code;
    public $channel_amount;
    public $channel_currency;

    public $channel_order_id;
    public $channel_phone;
    public $channel_email;
    public $channel_pay_time;

    //支付信息,支付,退款,还款
    public $payment_status;

    //其他
    public $serial_number;
    public $is_test_order = false;

    //返回消息
    public $status;

    /**
     * 实例化DB对象
     */
    public function __construct()
    {
        // 支付序列号
        $this->serial_number = time() . rand(100, 999) . "|";
        $this->status        = PaymentStatus::$paymentStatus['4000'];
    }

    /**
     * 充值
     */
    public function initRecharge()
    {
        // 验证订单是否存在
        $placedBillsInfo = $this->_checkPlatformOrderIdExist();
        if ($placedBillsInfo)
        {
            // 验证支付金额和货币是否合法
            if ($this->_checkAmountCurrencyIsValid($placedBillsInfo))
            {
                // 验证渠道订单号是否已经存在
                if (!$this->_checkChannelOrderIdExist())
                {
                    //更新渠道信息
                    $updateChannelInfo = $this->_updateChannelInfo();
                    if ($updateChannelInfo)
                    {
                        $this->_sendRechargeRequest();
                    }
                    else
                    {
                        $this->status = PaymentStatus::$paymentStatus['4004'];
                    }
                }
                else
                {
                    $this->status = PaymentStatus::$paymentStatus['4003'];
                }
            }
            else
            {
                $this->status = PaymentStatus::$paymentStatus['4002'];
            }
        }
        else
        {
            $this->status = PaymentStatus::$paymentStatus['4001'];
        }
    }

    /**
     * 退款
     */
    public function initRefund()
    {
        // 验证是否为退款
        if (in_array($this->payment_status, PaymentStatus::getRefund()))
        {
            if (!PaymentChange::processRefund($this->fg_order_id, $this->payment_status))
            {
                $this->status = PaymentStatus::$paymentStatus['4010'];
            }
            else
            {
                $this->status = PaymentStatus::$paymentStatus['4011'];
            }
        }
        else
        {
            $this->status = PaymentStatus::$paymentStatus['4008'];
        }
    }

    /**
     * 还款
     */
    public function initReversal()
    {
        // 验证是否为还款
        if (in_array($this->payment_status, PaymentStatus::getReversal()))
        {
            if (!PaymentChange::processReversal($this->fg_order_id, $this->payment_status))
            {
                $this->status = PaymentStatus::$paymentStatus['4012'];
            }
            else
            {
                $this->status = PaymentStatus::$paymentStatus['4013'];
            }
        }
        else
        {
            $this->status = PaymentStatus::$paymentStatus['4009'];
        }
    }

    /**
     * 检查当前订单是否已经存在
     * @return bool
     */
    private function _checkPlatformOrderIdExist()
    {

        return UsersBillingList::whereFgOrderId($this->fg_order_id)->first();
    }

    /**
     * 校验订单金额和支付货币，是否与下订单时保持一致
     *
     * @param $placedInfo
     *
     * @return bool
     */
    private function _checkAmountCurrencyIsValid($placedInfo)
    {

        if ($this->channel_currency == $placedInfo->currency && $this->channel_amount >= $placedInfo->amount)
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    /**
     * 校验第三方订单编号是否已经存在
     * @return bool
     */
    private function _checkChannelOrderIdExist()
    {
        if (UsersBillingList::whereChannelCode($this->channel_code)
                            ->whereChannelSubCode($this->channel_sub_code)
                            ->whereChannelOrderId($this->channel_order_id)
                            ->first()
        )
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    /**
     * 更新渠道数据
     *
     * @return bool|int
     */
    private function _updateChannelInfo()
    {
        return UsersBillingList::whereFgOrderId($this->fg_order_id)
                               ->update(
                                   [
                                       'channel_order_id' => $this->channel_order_id,
                                       'channel_phone'    => $this->channel_phone,
                                       'channel_email'    => $this->channel_email,
                                       'channel_pay_time' => $this->channel_pay_time,
                                       'channel_status'   => $this->payment_status,
                                       'is_test'          => ($this->is_test_order === true) ? 'Y' : 'N',
                                   ]);
    }

    /**
     * 充值请求
     * @return Ambigous <string, mixed>
     */
    private function _sendRechargeRequest()
    {

        $orderInfo = UsersBillingList::whereFgOrderId($this->fg_order_id)->first();
        if (!in_array($orderInfo->channel_status, PaymentStatus::getPaySuccess()))
        {
            $this->status = PaymentStatus::$paymentStatus['4005'];
        }
        else
        {
            if (!UsersBillingList::updateSendStatus($orderInfo->fg_order_id, PaymentRecharge::rechargeApi($orderInfo)))
            {
                $this->status = PaymentStatus::$paymentStatus['4006'];
            }
            else
            {
                $this->status = PaymentStatus::$paymentStatus['4007'];
            }
        }
    }
}