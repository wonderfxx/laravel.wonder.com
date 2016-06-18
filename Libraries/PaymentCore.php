<?php
use App\Models\GameList;
use App\Models\UsersBillingList;
use libraries\CommonFunc;
use libraries\PaymentStatus;

/**
 *
 * @author 平台发钻接口
 *
 */
class PaymentCore
{

    //平台信息
    private $fg_order_id;

    //渠道信息
    private $channel_code;
    private $channel_sub_code;
    private $channel_order_id;
    private $channel_phone;
    private $channel_email;
    private $channel_amount;
    private $channel_currency;
    private $channel_pay_time;
    private $channel_status;

    //发钻信息
    private $send_coins_status;
    private $chargeback_status;

    //其他
    private $random_serial_number;
    private $is_test_order = false;
    private $refund_status = false;
    private $status;

    /**
     * 实例化DB对象
     */
    public function __construct()
    {
        // 支付序列号
        $this->random_serial_number = time() . rand(100, 999) . "|";
    }

    /**
     * 触发充值
     */
    public function initSendCoins()
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
                        $this->_rechargeGame();
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
     * 检查当前订单是否已经存在
     * @return bool
     */
    public function _checkPlatformOrderIdExist()
    {

        return UsersBillingList::whereFgOrderId($this->fg_order_id)->get();
    }

    /**
     * 校验订单金额和支付货币，是否与下订单时保持一致
     *
     * @param $placedInfo
     *
     * @return bool
     */
    public function _checkAmountCurrencyIsValid($placedInfo)
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
    public function _checkChannelOrderIdExist()
    {
        if (UsersBillingList::whereChannelCode($this->channel_code)
                            ->whereChannelSubCode($this->channel_sub_code)
                            ->whereChannelOrderId($this->channel_order_id)
                            ->get()
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
    public function _updateChannelInfo()
    {
        return UsersBillingList::whereFgOrderId($this->fg_order_id)
                               ->update(
                                   [
                                       'channel_code'     => $this->channel_code,
                                       'channel_sub_code' => $this->channel_sub_code,
                                       'channel_order_id' => $this->channel_order_id,
                                       'channel_phone'    => $this->channel_phone,
                                       'channel_email'    => $this->channel_email,
                                       'channel_pay_time' => $this->channel_pay_time,
                                       'channel_status'   => $this->channel_status,
                                       'is_test'          => ($this->is_test_order === true) ? 'Y' : 'N',
                                   ]);
    }


    public function _updateSendCoinsInfo()
    {

       Auth::
        
        if (UsersBillingList::whereFgOrderId($this->fg_order_id)
            ->first()
            ->update($result))){

        }else{

        }}
            return true;)
    }

    /**
     * 给游戏充钻
     * @return Ambigous <string, mixed>
     */
    public function _rechargeGame()
    {

        $orderInfo = UsersBillingList::whereFgOrderId($this->fg_order_id)->first();
        if (!in_array($orderInfo->channel_status, PaymentStatus::getPaySuccess()))
        {
            $this->status = PaymentStatus::$paymentStatus['4006'];
            
        }
        else
        {
            $gameInfo = GameList::whereGameCode($orderInfo->game_code)->first();


        }


    }

    /**
     * 记录渠道订单详情
     *
     * @param $data
     *
     * @return bool
     */
    public function _insertPaywayBills($data)
    {

        $paywaysHandle = $this->_loadModel('Bills' . ucfirst($this->pay_way));

        // 去掉不存在的字段
        $fields = $paywaysHandle->getFields();
        foreach ($data as $k => $v)
        {
            if (!in_array($k, $fields))
            {
                unset($data[$k]);
            }
        }

        // 记录到数据库
        $_return = $paywaysHandle->insert($data);
        if (!$_return)
        {
            return false;
        }
        else
        {
            return true;
        }
    }

    /**
     * 更新订单变更记录
     *
     * @param $data
     */
    public function _recordBillsChange($data)
    {
        $billsHandle       = $this->_loadModel('Bills');
        $billsChangeHandle = $this->_loadModel('BillsChange');

        $result = $billsHandle->getOne("oas_orderid = '" . $this->oas_orderid . "' AND third_orderid='" . $this->third_orderid . "'");
        if (!empty($result))
        {
            $result     = $result[0];
            $insertData = array(
                'oas_orderid' => $this->oas_orderid,
                'userid'      => $result['userid'],
                'pay_email'   => $result['pay_email'],
                'pay_time'    => $result['pay_time'],
                'status'      => $data['status'],
                'remark'      => $data['remark'],
                'update_time' => time()
            );
            $billsChangeHandle->insert($insertData);
        }
    }

}