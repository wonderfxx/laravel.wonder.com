<?php

namespace App\Http\Controllers\Web\Api;

use App\Models\GamePackageList;
use App\Models\UsersBillingList;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;

class BillingsController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $rules       = [
            'game_code'    => 'required',
            'server_id'    => 'required',
            'user_id'      => 'required',
            'user_grade'   => 'required',
            'product_id'   => 'required',
            'country'      => 'required',
            'channel_code' => 'required',
            'product_type' => 'required',
        ];
        $credentials = [
            'game_code'        => $request->get('game_code'),
            'server_id'        => $request->get('server_id'),
            'user_id'          => $request->get('user_id'),
            'user_role'        => $request->get('user_role'),
            'user_role_id'     => $request->get('user_role_id') ? $request->get('user_role_id') : 0,
            'user_grade'       => $request->get('user_grade') ?: 0,
            'product_id'       => $request->get('product_id'),
            'country'          => $request->get('country'),
            'channel_code'     => $request->get('channel_code'),
            'channel_sub_code' => $request->get('channel_sub_code'),
            'product_type'     => $request->get('product_type'),
        ];

        // check
        $validator = \Validator::make($credentials, $rules);
        if (!$validator->passes())
        {
            return JsonResponse::create($validator->messages(), 422);
        }

        // 验证套餐
        $billingInfo = GamePackageList::whereGameCode($credentials['game_code'])
                                      ->whereCountry($credentials['country'])
                                      ->whereChannelCode($credentials['channel_code'])
                                      ->whereChannelSubCode($credentials['channel_sub_code'])
                                      ->whereProductId($credentials['product_id'])
                                      ->first();
        if (!$billingInfo)
        {
            return JsonResponse::create(['product_id' => 'Invalid Product Id.'], 422);
        }

        //用户信息
        $credentials['user_ip_address']    = \Request::getClientIp();
        $credentials['created_time']       = time();
        $credentials['country']            = $billingInfo->country;
        $credentials['channel_code']       = $billingInfo->channel_code;
        $credentials['channel_sub_code']   = $billingInfo->channel_sub_code;
        $credentials['amount']             = $billingInfo->amount;
        $credentials['currency']           = $billingInfo->currency;
        $credentials['amount_usd']         = $billingInfo->amount_usd;
        $credentials['game_coins']         = $billingInfo->game_coins;
        $credentials['game_coins_rewards'] = $billingInfo->game_coins_rewards;
        $credentials['product_type']       = $billingInfo->product_type;
        $credentials['package_id']         = $billingInfo->id;
        $orderInfo                         = UsersBillingList::whereFgOrderId(UsersBillingList::insertGetId($credentials, 'fg_order_id'))
                                                             ->first();

        return JsonResponse::create(['fg_order_id' => $orderInfo->fg_order_id, 'package_id' => $orderInfo->package_id],
                                    200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $orderInfo = UsersBillingList::whereFgOrderId($id)->first();;
        if (!$orderInfo)
        {
            return JsonResponse::create(['error' => 'Invalid Order Id.'], 422);
        }
        else
        {

            return JsonResponse::create($orderInfo, 200);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int                      $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
