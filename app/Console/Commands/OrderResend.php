<?php

namespace App\Console\Commands;

use App\Models\UsersBillingList;
use App\Http\Requests;
use libraries\PaymentRecharge;
use libraries\PaymentStatus;
use Illuminate\Console\Command;

class OrderResend extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sms:resend_order';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '重发失败的支付订单';

    /**
     * OrderResend constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $result = UsersBillingList::whereNotIn('send_coins_status', PaymentStatus::getRechargeSuccess())
                                  ->whereIn('channel_status', PaymentStatus::getPaySuccess())
                                  ->get();
        if (!empty($result)) {
            foreach ($result as $key => $orderInfo) {
                $this->resend($orderInfo);
            }
        }
    }

    /**
     * @param UsersBillingList $orderInfo
     *
     * @return \Symfony\Component\HttpFoundation\Response|static
     */
    public function resend(UsersBillingList $orderInfo)
    {
        $status = PaymentRecharge::rechargeApi($orderInfo);
        UsersBillingList::updateSendStatus($orderInfo->fg_order_id, $status);
        if (in_array($status, PaymentStatus::getRechargeSuccess())) {
            $data = ['st' => 'OK', 'msg' => '补发成功'];
        }
        else {
            $data = ['st' => 'NO', 'msg' => PaymentStatus::$paymentStatus[$status]];
        }
        \Log::useDailyFiles(storage_path() . '/logs/' . date('Ymd', time()) . '/resend_orders');
        \Log::info($orderInfo->fg_order_id . ':', $data);

        return $data;
    }
}
