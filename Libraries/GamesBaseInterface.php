<?php

/**
 * Created by PhpStorm.
 * User: wonder
 * Date: 16/6/20
 * Time: 下午7:32
 */

namespace libraries;

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
     * @param User $info
     * @param      $server_id
     *
     * @return mixed
     */
    public function finishLogin(User $info, $server_id);

}