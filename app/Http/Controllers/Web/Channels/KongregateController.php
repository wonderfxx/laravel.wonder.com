<?php

namespace App\Http\Controllers\Web\Channels;

use App\Http\Controllers\Controller;
use libraries\PaymentCore;

class KongregateController extends Controller
{

    public $paymentCore;

    /**
     *
     * KongregateController constructor.
     */
    public function __construct()
    {
        $this->paymentCore = new PaymentCore();
    }

    public function initPaymentParams()
    {

        $this->fg_order_id      = '';
        $this->channel_code     = '';
        $this->channel_sub_code = '';
        $this->channel_amount   = '';
        $this->channel_currency = '';
        $this->channel_order_id = '';
        $this->channel_phone    = '';
        $this->channel_email    = '';
        $this->channel_pay_time = '';
        $this->payment_status   = '';
    }

    /**
     * 初始化支付
     */
    public function initCallback()
    {
        $this->initPaymentParams();
        $this->paymentCore->initRecharge();

        echo $this->paymentCore->status;
    }

    public function makeFramePage()
    {
        return view('web.kongregate');
    }
}