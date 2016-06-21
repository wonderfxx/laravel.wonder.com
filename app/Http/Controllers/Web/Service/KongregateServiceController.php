<?php

namespace App\Http\Controllers\Web\Service;

use App\Http\Controllers\Controller;
use App\Models\GameServerList;
use App\Models\User;
use Illuminate\Support\Facades\Input;
use libraries\CommonFunc;

class KongregateServiceController extends Controller
{
    private $authApi = 'https://api.kongregate.com/api/authenticate.json';

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
        $gameServerInfo = GameServerList::whereGameCode($credentials['gid'])->whereServerId($credentials['sid']);
        $isLogin        = $this->getUserAuth($credentials['uid'], $credentials['token'], $gameServerInfo->kongregate_api_key);
        if ($isLogin)
        {
            //user email
            $loginEmail = $isLogin['user_id'] . '@kongregate.net';

            // is already register
            $user = User::whereEmail($loginEmail)->first();
            if ($user)
            {
                // 同步登陆网站
                \Auth::guard()->login($user);

                // 更新登陆时间
                $user->update(['login_ip' => \Request::getClientIp(), 'updated_at' => time()]);
            }
            else
            {
                User::create([
                                 'username'    => $isLogin['username'],
                                 'email'       => $loginEmail,
                                 'sns_id'      => $credentials['uid'],
                                 'ad_source'   => 'kongregate',
                                 'password'    => CommonFunc::makeMd5Auth(CommonFunc::makeRandomPassword(12)),
                                 'remember'    => 'N',
                                 'register_ip' => \Request::getClientIp(),
                                 'status'      => 'Y',
                                 'created_at'  => time(),
                             ]);
            }
        }

        return redirect('/games/' . $credentials['gid'] . '/' . $credentials['sid']);
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
    public function getUserAuth($user_id, $game_auth_token, $api_key)
    {

        $result = CommonFunc::curlRequest($this->authApi
                                          . "?user_id=$user_id&game_auth_token=$game_auth_token&api_key=$api_key");
        $result = \GuzzleHttp\json_decode($result, true);
        if ($result['success'])
        {
            return [
                'username' => $result['username'],
                'user_id'  => $result['user_id']
            ];
        }
        else
        {
            return false;
        }
    }

}