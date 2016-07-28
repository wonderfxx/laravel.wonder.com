<?php

namespace App\Http\Controllers\Web\Games;

use App\Http\Controllers\Controller;
use App\Models\GameList;
use App\Models\User;
use App\Models\UsersBillingList;
use libraries\CommonFunc;
use libraries\GamesBaseInterface;
use Sinergi\BrowserDetector\Browser;

class LoapkInitController extends Controller implements GamesBaseInterface
{

    private $loginApi = 'https://loapk{$}.fingertactic.com/?';
    private $loginKey = '0kuZ^B*9tpG+=8^y';

    private $rechargeApi = 'https://loapk{$}.fingertactic.com/payapi.php?do=PayKongreGate';
    private $rechargeKey = '1#C*-VMsUEGs1t*(';

    private $isOpenCpConvert = false;
    private $game_code       = 'loapk';

    /**
     * 初始化游戏
     *
     * @param $sid
     * @param $isLogin
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     */
    public function play($sid, $isLogin)
    {

        if ($isLogin && \Auth::guard()->check())
        {
            return redirect($this->finishLogin(\Auth::guard()->user(), $sid));
        }
        else
        {
            //detect user browser
            $browser = new Browser();
            if ($browser->getName() == 'Safari' && $browser->getVersion() == '9.1.1')
            {
                $isSafariBorwser = true;
            }
            else
            {
                $isSafariBorwser = false;
            }

            return view('web.games.' . $this->game_code, [
                'url_address'       => '',
                'game_code'         => $this->game_code,
                'server_id'         => $sid,
                'is_safari_browser' => $isSafariBorwser
            ]);
        }
    }

    /**
     * 实现充值
     *
     * @param UsersBillingList $info
     *
     * @return int
     */
    public function finishRecharge(UsersBillingList $info)
    {

        //按照比例CP传值
        if ($this->isOpenCpConvert)
        {
            $cpInfo         = GameList::getCpAmountCurrnecy($info->game_code, $info->game_coins);
            $info->amount   = $cpInfo['amount'];
            $info->currency = $cpInfo['currency'];
        }

        //请求信息
        $requestData         = [
            'puid'      => $info->user_id,
            'serverid'  => $info->server_id,
            'orderid'   => $info->fg_order_id,
            'productid' => $info->product_id,
            'money'     => $info->amount,
            'gold'      => $info->game_coins + $info->game_coins_rewards,
        ];
        $requestData['sign'] = md5($requestData['puid'] . $requestData['serverid'] . $requestData['orderid']
                                   . $requestData['productid'] . $requestData['money'] . $requestData['gold']
                                   . $this->rechargeKey);
        $result              = CommonFunc::curlRequest(str_replace('{$}', $requestData['serverid'], $this->rechargeApi), $requestData);
        switch ($result)
        {
            case 0: //操作失败
                $status = 2001;
                break;

            case 1: //成功
                $status = 2000;
                break;

            case -1: //参数不完整或错误
                $status = 2008;
                break;

            case -2: //校验码错误
                $status = 2007;
                break;

            case -3: //角色不存在
                $status = 2002;
                break;

            default:
                $status = 2010;
        }

        //记录日志

        return $status;
    }

    /**
     * 实现登陆
     *
     * @param User $info
     * @param int  $server_id
     *
     * @return string
     *
     */
    public function finishLogin(User $info, $server_id)
    {
        $time                = time();
        $requestData         = [
            'puid' => $info->userid,
            'time' => $time,
        ];
        $requestData['sign'] = md5($requestData['puid'] . $requestData['time'] . $this->loginKey);

        return str_replace('{$}', $server_id, $this->loginApi) . http_build_query($requestData);
    }

}
