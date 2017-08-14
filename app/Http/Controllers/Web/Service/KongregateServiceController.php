<?php

namespace App\Http\Controllers\Web\Service;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Web\Games\PlayController;
use App\Models\GameList;
use App\Models\User;
use Illuminate\Support\Facades\Input;
use libraries\CommonFunc;
use Symfony\Component\HttpFoundation\JsonResponse;

class KongregateServiceController extends Controller
{
    private $authApi      = 'https://www.kongregate.com/api/authenticate.json';
    private $statisticApi = 'https://api.kongregate.com/api/submit_statistics.json';
    private $statisticKey = 'ZsRtm5Ya3.Q&MHm!M';

    /**
     * 同步登陆
     *
     * @return \Symfony\Component\HttpFoundation\Response|static
     */
    public function checkAuth()
    {

        $credentials    = [
            'gid'   => Input::get('gid'),
            'sid'   => Input::get('sid'),
            'uid'   => Input::get('uid'),
            'token' => Input::get('token'),
        ];

        //验证kongregate是否存在该用户
        $gameServerInfo = GameList::whereGameCode($credentials['gid'])->first();
        $isLogin        = $this->getUserAuth(
            $credentials['uid'],
            $credentials['token'],
            $gameServerInfo->kongregate_api_key
        );
        if (!$isLogin) {
            $isLogin = $this->getUserAuth(
                $credentials['uid'],
                $credentials['token'],
                $gameServerInfo->kongregate_api_key
            );
        }
        if ($isLogin) {

            //user email
            $loginEmail = $isLogin['user_id'] . '@kongregate.net';

            // is already register
            $user = User::whereEmail($loginEmail)->first();
            if ($user) {
                // 同步登陆网站
                \Auth::guard()->login($user);

                // 更新登陆时间
                $user->update(
                    [
                        'login_ip'          => \Request::getClientIp(),
                        'updated_at'        => time(),
                        'last_login_game'   => $credentials['gid'],
                        'last_login_server' => $credentials['sid'],
                    ]
                );
            }
            else {
                User::create(
                    [
                        'username'          => $isLogin['username'],
                        'email'             => $loginEmail,
                        'sns_id'            => $credentials['uid'],
                        'last_login_game'   => $credentials['gid'],
                        'last_login_server' => $credentials['sid'],
                        'ad_source'         => 'kongregate',
                        'password'          => CommonFunc::makeMd5Auth(CommonFunc::makeRandomPassword(12)),
                        'remember'          => 'N',
                        'register_ip'       => \Request::getClientIp(),
                        'status'            => 'Y',
                        'created_at'        => time(),
                    ]
                );
                $user = User::whereEmail($loginEmail)->first();
                if ($user) {
                    // 同步登陆网站
                    \Auth::guard()->login($user);
                }
            }

            return PlayController::getInstance()->play($credentials['gid'], $credentials['sid'], true);
        }
        else {
            return PlayController::getInstance()->play($credentials['gid'], $credentials['sid']);
        }
    }

    /**
     * 提交数据
     *
     * @return mixed
     */
    public function reportData()
    {

        //获取参数
        $credentials = [
            'gid'    => Input::get('gid'),
            'sid'    => Input::get('sid'),
            'uid'    => Input::get('uid'),
            'grade'  => Input::get('grade'),
            'loaded' => Input::get('loaded'),
            'coins'  => Input::get('coins'),
        ];

        //安全校验
        $sign = md5(
            md5(
                $credentials['uid'] . $credentials['sid'] . $credentials['gid'] . $credentials['grade']
                . $credentials['loaded']
                . $credentials['coins']
            ) . $this->statisticKey
        );
        if (Input::get('sign') != $sign) {
            return JsonResponse::create(['status' => 'failed'], 200);
        }

        //获取真实的SNS ID
        $userInfo           = User::whereUserid($credentials['uid'])->first();
        $credentials['uid'] = $userInfo->sns_id;

        //获取数据
        $data[$credentials['gid'] . '-s' . $credentials['sid'] . '-user-grade']  = $credentials['grade'];
        $data[$credentials['gid'] . '-s' . $credentials['sid'] . '-user-loaded'] = $credentials['loaded'];
        $data[$credentials['gid'] . '-s' . $credentials['sid'] . '-user-coins']  = $credentials['coins'];

        $gameServerInfo = GameList::whereGameCode($credentials['gid'])->first();
        $isReported     = $this->submitGameData($credentials['uid'], $gameServerInfo->kongregate_api_key, $data);
        if ($isReported) {

            return JsonResponse::create(['status' => 'success'], 200);
        }
        else {
            return JsonResponse::create(['status' => 'failed'], 200);
        }
    }

    /**
     * 验证用户的有效性
     *
     * @param $user_id
     * @param $game_auth_token
     * @param $api_key
     *
     * @return array|bool
     */
    private function getUserAuth($user_id, $game_auth_token, $api_key)
    {

        $result = CommonFunc::curlRequest(
            $this->authApi
            . "?user_id=$user_id&game_auth_token=$game_auth_token&api_key=$api_key"
        );
        $result = json_decode($result, true);
        if ($result['success']) {
            return [
                'username' => $result['username'],
                'user_id'  => $result['user_id'],
            ];
        }
        else {
            return false;
        }
    }

    /**
     * 提交统计数据
     *
     * @param $user_id
     * @param $api_key
     * @param $statistic_data
     *
     * @return bool
     */
    private function submitGameData($user_id, $api_key, $statistic_data)
    {

        $data            = $statistic_data;
        $data['user_id'] = $user_id;
        $data['api_key'] = $api_key;
        $result          = CommonFunc::curlRequest($this->statisticApi, $data);
        $result          = json_decode($result, true);

        //记录日日志
        CommonFunc::writeCurlLog($data, 'reportData');

        if ($result['success']) {
            return true;
        }
        else {
            return false;
        }
    }
}
