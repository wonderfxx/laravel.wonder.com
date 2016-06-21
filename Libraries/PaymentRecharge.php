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
     * 发钻中间处理
     *
     * @param UsersBillingList $orderInfo
     *
     * @return bool
     */
    public static function rechargeApi(UsersBillingList $orderInfo = array())
    {

        $gameInfoApi = new \ReflectionClass('App\Http\Controllers\Web\Games\\' . ucfirst($orderInfo->game_code) . 'InitController');
        if (UsersBillingList::updateSendStatus(
            $orderInfo->fg_order_id,
            $gameInfoApi->newInstance()->finishRecharge($orderInfo)))
        {
            return true;
        }
        else
        {
            return false;
        }
    }
}