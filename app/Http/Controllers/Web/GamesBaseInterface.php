<?php
/**
 * Created by PhpStorm.
 * User: wonder
 * Date: 16/6/20
 * Time: 下午7:32
 */

namespace App\Http\Controllers\Web;

use App\Models\User;
use App\Models\UsersBillingList;

/**
 * Interface GamesBaseInterface
 * @package App\Http\Controllers\Web
 */
interface GamesBaseInterface
{
    /**
     * 实现充值
     *
     * @param $info
     *
     * @return mixed
     */
    public function finishRecharge(UsersBillingList $info);

    /**
     * 实现登陆
     *
     * @param $info
     *
     * @return mixed
     */
    public function finishLogin(User $info);

    /**
     * 实现下单
     *
     * @param $info
     *
     * @return mixed
     */
    public function finishPlaced(UsersBillingList $info);

    /**
     * 实现退款
     *
     * @param $info
     *
     * @return mixed
     */
    public function finishRefund(UsersBillingList $info);

}