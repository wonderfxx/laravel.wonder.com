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
     * 发钻处理
     * @param UsersBillingList $orderInfo
     *
     * @return mixed
     */
    public static function rechargeApi(UsersBillingList $orderInfo)
    {

        $gameInfoApi = new \ReflectionClass('App\Http\Controllers\Web\Games\\' . ucfirst($orderInfo->game_code) . 'InitController');

        return $gameInfoApi->newInstance()->finishRecharge($orderInfo);
    }
}