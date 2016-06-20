<?php
/**
 * Created by PhpStorm.
 * User: wonder
 * Date: 16/6/20
 * Time: 下午9:07
 */

namespace libraries;

use App\Models\UsersBillingList;

class PaymentRecharge
{

    /**
     * 发钻
     *
     * @param array $orderInfo
     *
     * @return array
     */
    public static function rechargeApi(UsersBillingList $orderInfo = array())
    {

        $gameInfoApi = new \ReflectionClass(ucfirst($orderInfo->game_code) . 'InitController');
        if (UsersBillingList::updateSendStatus($orderInfo->fg_order_id, $gameInfoApi->finishRecharge($orderInfo)))
        {
            return true;
        }
        else
        {
            return false;
        }
    }

}