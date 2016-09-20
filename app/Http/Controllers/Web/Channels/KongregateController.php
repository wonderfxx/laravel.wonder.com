<?php

namespace App\Http\Controllers\Web\Channels;

use App\Http\Controllers\Controller;
use libraries\CommonFunc;
use Request;
use App\Models\GamePackageList;
use App\Models\GameServerList;
use libraries\PaymentCore;
use Symfony\Component\HttpFoundation\JsonResponse;

class KongregateController extends Controller
{

    public $paymentCore;
    public $requestHandler;
    public $channel = 'kongregate';
    public $randomSerialNumber;

    public function __construct()
    {
        parent::setLogPath($this->channel);
        $this->randomSerialNumber = time() . rand(100, 999);
    }

    /**
     * 初始化支付
     *
     * @return KongregateController|\Symfony\Component\HttpFoundation\Response|static
     */
    public function initCallback()
    {

        //纪录请求日志
        \Log::info($this->randomSerialNumber . '-address:' . Request::getClientIp());
        \Log::info($this->randomSerialNumber . '-request:', Request::all());

        //验证参数是否有效
        $gameInfo = GameServerList::whereGameCode(Request::get('gid'))->whereServerId(Request::get('sid'))->first();
        if (!$gameInfo) {
            \Log::info($this->randomSerialNumber . '-request: validate game error.');

            return JsonResponse::create(['success' => 'false'], 422);
        }

        //验证参数签名是否有效
        $requestData = $this->parse_signed_request($gameInfo->kongregate_api_key);

        if (!$requestData) {
            \Log::info($this->randomSerialNumber . '-sign: validate sign error.');

            return JsonResponse::create(['success' => 'false'], 422);
        }
        //验证参数
        \Log::info($this->randomSerialNumber . '-sign:', $requestData);

        // order params: fg_order_id,package_id
        $extraParams                   = explode(',', $requestData['order_info']);
        $requestData['cb_fg_order_id'] = $extraParams[0];
        $requestData['cb_package_id']  = $extraParams[1];
        $this->requestHandler          = $requestData;
        if ($this->requestHandler['event'] == 'item_order_request') {
            return $this->getPackageDetail();
        }
        else if ($this->requestHandler['event'] == 'item_order_placed') {
            \Log::info($this->randomSerialNumber . '-send: send data');

            return $this->sendCoins();
        }
        else {
            \Log::info($this->randomSerialNumber . '-cancel:', $this->requestHandler);

            return JsonResponse::create(["state" => "canceled"], 200);
        }
    }

    /**
     * 获取产品信息
     *
     * @return \Symfony\Component\HttpFoundation\Response|static
     */
    public function getPackageDetail()
    {

        $itemInfo = GamePackageList::whereId($this->requestHandler['cb_package_id'])->first();
        if (empty($itemInfo)) {
            \Log::info($this->randomSerialNumber . '-detail: empty package error.');

            return JsonResponse::create(['success' => 'false'], 422);
        }
        else {
            $items = [
                [
                    "name"        => $itemInfo->product_name,
                    "description" => $itemInfo->product_description,
                    "price"       => (int)$itemInfo->amount,
                    "image_url"   => $itemInfo->product_logo,
                ],
            ];
            \Log::info($this->randomSerialNumber . '-detail: ', $items);

            return JsonResponse::create(['items' => $items], 200);
        }

    }

    /**
     * 发钻
     *
     * @return \Symfony\Component\HttpFoundation\Response|static
     */
    public function sendCoins()
    {

        $itemInfo                      = GamePackageList::whereId($this->requestHandler['cb_package_id'])->first();
        $paymentCore                   = new PaymentCore();
        $paymentCore->fg_order_id      = $this->requestHandler['cb_fg_order_id'];
        $paymentCore->channel_code     = $itemInfo->channel_code;
        $paymentCore->channel_sub_code = $itemInfo->channel_sub_code;
        $paymentCore->channel_amount   = $itemInfo->amount;
        $paymentCore->channel_currency = $itemInfo->currency;
        $paymentCore->channel_order_id = $this->requestHandler['order_id'];
        $paymentCore->channel_phone    = '';
        $paymentCore->channel_email    = '';
        $paymentCore->channel_pay_time = time();
        $paymentCore->payment_status   = '3000';

        //发钻
        $paymentCore->initRecharge();

        \Log::info($this->randomSerialNumber . '-send:' . $paymentCore->status);

        return JsonResponse::create(["state" => "completed"], 200);
    }

    /**
     * @param $game_api_key
     *
     * @return bool|mixed
     */
    protected function parse_signed_request($game_api_key)
    {

        $sign = Request::get('signed_request');
        // Get the signed request from the request parameters
        if (empty($sign)) {
            return false;
        }

        // Split the string at the period character to get the signature/payload
        list($encoded_sig, $payload) = explode('.', $sign, 2);

        // base64_url decode the payload and then parse it as JSON
        $sig  = $this->base64_url_decode($encoded_sig);
        $data = json_decode($this->base64_url_decode($payload), true);

        // Verify the signature algorithm
        if (strtoupper($data['algorithm']) !== 'HMAC-SHA256') {
            return false;
        }

        // Make sure that we calculate the same signature for the payload as was sent
        $expected_sig = hash_hmac('sha256', $payload, $game_api_key, $raw = true);
        if ($sig !== $expected_sig) {
            return false;
        }

        // Return the params
        return $data;
    }

    /**
     * Decodes a base64_url encoded string
     *
     * @param $input
     *
     * @return string
     */
    protected function base64_url_decode($input)
    {
        return base64_decode(strtr($input, '-_', '+/'));
    }
}
