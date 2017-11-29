<?php

namespace App\Http\Controllers\Admin\Billings;

use App\Models\UsersBillingList;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use libraries\PaymentStatus;

class BillingsController extends Controller
{
    public $filter = ['fg_order_id', 'game_code', 'channel_code', 'channel_order_id',
                      'channel_status', 'user_id','user_role', 'amount', 'currency', 'game_coins'
                      , 'created_time', 'send_coins_status', 'send_time'];

    /**
     * UserController constructor.
     */
    public function __construct()
    {
        $this->middleware('admin');

        //共享数据
        view()->share([
                          'headers' => UsersBillingList::getColumns(),
                      ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pay      = PaymentStatus::getPayStatus();
        $send     = PaymentStatus::getSendCoinsStatus();
        $pay['']  = '请选择订单状态';
        $send[''] = '请选择发钻状态';

        $columns = UsersBillingList::getColumns();
        $return  = [];

        foreach ($columns as $val)
        {
            if (in_array($val['field'], $this->filter))
            {
                $return[] = $val;
            }
        }
        $return[] = [
            'field' => 'operation',
            'title' => '操作',
            'align' => 'center',
        ];

        return view('admin.billings.index', [
            'headers'    => json_encode($return),
            'payStatus'  => $pay,
            'sendStatus' => $send
        ]);
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
        return view('admin.billings.index_info', [
            'data' => UsersBillingList::whereFgOrderId((int)$id)->first()->toArray(),
        ]);
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

    /**
     * 处理分页
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function page()
    {

        //search
        $fg_order_id       = Input::get('fg_order_id');
        $channel_order_id  = Input::get('channel_order_id');
        $user_id           = Input::get('user_id');
        $send_coins_status = Input::get('send_coins_status') ? Input::get('send_coins_status') : '';
        $channel_status    = Input::get('channel_status');

        //get data
        $handler = new UsersBillingList();
        $columns = \Schema::getColumnListing($handler->getTable());
        $result  = $handler
            ->when($fg_order_id, function ($query) use ($fg_order_id)
            {
                if ($fg_order_id)
                {
                    return $query->whereFgOrderId($fg_order_id);
                }
                else
                {
                    return $query;
                }
            })
            ->when($channel_order_id, function ($query) use ($channel_order_id)
            {
                if ($channel_order_id)
                {
                    return $query->whereChannelOrderId($channel_order_id);
                }
                else
                {
                    return $query;
                }
            })
            ->when($user_id, function ($query) use ($user_id)
            {
                if ($user_id)
                {
                    return $query->whereUserId($user_id);
                }
                else
                {
                    return $query;
                }
            })
            ->when($send_coins_status, function ($query) use ($send_coins_status)
            {
                if ($send_coins_status)
                {
                    return $query->whereSendCoinsStatus($send_coins_status);
                }
                else
                {
                    return $query;
                }
            })
            ->when($channel_status, function ($query) use ($channel_status)
            {
                if ($channel_status)
                {
                    return $query->whereChannelStatus($channel_status);
                }
                else
                {
                    return $query;
                }
            })
            ->orderBy('created_time', 'desc')
            ->paginate(
                Input::get('pageSize'),
                $columns,
                'page',
                Input::get('pageNumber')
            );
        foreach ($result->items() as $items)
        {
            $items->operation        = '
                <a class="btn btn-success btn-xs btn-outline" href="javascript:info(' . $items->fg_order_id . ')" >
                    <i class="fa fa-search" ></i >
                </a >
            ';
//            $items->fg_order_id      = '<b>' . $items->fg_order_id . '</b>';
            $items->user_id          = '<b>' . $items->user_id . '</b>';
            $items->channel_order_id = '<b>' . $items->channel_order_id . '</b>';

            if (key_exists($items->send_coins_status, PaymentStatus::$paymentStatus))
            {
                if (in_array($items->send_coins_status, PaymentStatus::getRechargeSuccess()))
                {
                    $items->send_coins_status = '<span class="label label-primary">' . PaymentStatus::$paymentStatus[$items->send_coins_status] . '</span>';
                }
                else
                {
                    $items->send_coins_status = '<span class="label label-danger">' . PaymentStatus::$paymentStatus[$items->send_coins_status] . '</span>';
                }
            }
            if (key_exists($items->channel_status, PaymentStatus::$paymentStatus))
            {
                if (in_array($items->channel_status, PaymentStatus::getPaySuccess()))
                {
                    $items->channel_status = '<span class="label label-primary">' . PaymentStatus::$paymentStatus[$items->channel_status] . '</span>';
                }
                else
                {
                    $items->channel_status = '<span class="label label-danger">' . PaymentStatus::$paymentStatus[$items->channel_status] . '</span>';
                }
            }

            $items->created_time     = $items->created_time == '0' ? '-' : date('Y-m-d H:i', $items->created_time);
            $items->channel_pay_time = $items->channel_pay_time == '0' ? '-' : date('Y-m-d H:i', $items->channel_pay_time);
            $items->send_time        = $items->send_time == '0' ? '-' : date('Y-m-d H:i', $items->send_time);
        }

        return $result;
    }
}
