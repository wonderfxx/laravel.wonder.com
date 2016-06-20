<?php

namespace App\Http\Controllers\Admin\Home;

use App\Http\Controllers\Web\GamesBaseInterface;
use App\Models\GameList;
use App\Models\User;
use App\Models\UsersBillingList;
use libraries\CommonFunc;

class LoakInitController implements GamesBaseInterface
{

    /**
     * 实现充值
     *
     * @param $info
     *
     * @return mixed
     */
    public function finishRecharge(UsersBillingList $info)
    {

        //游戏信息
        $gameInfo = GameList::getGameInfo($info->game_code);

        //请求信息
        $requestData = $info;
        $result      = CommonFunc::curlRequest($gameInfo->recharge_api, $requestData);
        switch ($result->status)
        {
            case 1:

                return 2001;
                break;
            default:

                return 2010;
        }
    }

    /**
     * 实现登陆
     *
     * @param $info
     *
     * @return mixed
     */
    public function finishLogin(User $info)
    {
    }

    /**
     * 实现下单
     *
     * @param $info
     *
     * @return mixed
     */
    public function finishPlaced(UsersBillingList $info)
    {
    }

    /**
     * 实现退款
     *
     * @param $info
     *
     * @return mixed
     */
    public function finishRefund(UsersBillingList $info)
    {
    }

}
