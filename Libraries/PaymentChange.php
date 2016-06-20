<?php
/**
 * Created by PhpStorm.
 * User: wonder
 * Date: 16/6/20
 * Time: 下午9:49
 */

namespace libraries;

use App\Models\UsersBillingChange;
use App\Models\UsersBillingList;

/**
 * 记录订单变更
 *
 * Class PaymentRisk
 * @package libraries
 */
class PaymentChange
{

    /**
     *  标记成退款
     *
     * @param $order_id
     * @param $status
     *
     * @return bool
     */
    public static function processRefund($order_id, $status)
    {

        if (UsersBillingList::recordChange($order_id, $status))
        {
            UsersBillingChange::recordChange($order_id, $status, 'refund');

            return true;
        }
        else
        {
            return false;
        }
    }

    /**
     * 标记成还款
     *
     * @param $order_id
     * @param $status
     *
     * @return bool
     */
    public static function processReversal($order_id, $status)
    {

        if (UsersBillingList::recordChange($order_id, $status))
        {
            UsersBillingChange::recordChange($order_id, $status, 'reversal');

            return true;
        }
        else
        {
            return false;
        }
    }

}