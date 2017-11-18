<?php

namespace App\Http\Controllers\Admin\Statistics;

use App\Models\User;
use App\Models\UsersBillingList;
use App\Models\UsersLoginLog;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;

class UserEveryDayController extends Controller
{

    /**
     * UserController constructor.
     */
    public function __construct()
    {

        $this->middleware('admin');

        //共享数据
        view()->share(
            [
                'headers' => UsersBillingList::getColumns(),
            ]
        );
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $start      = !empty(Input::get('start')) ? Input::get('start') : date('Y-m-d', strtotime('-6 day'));
        $end        = Input::get('end');
        $regUsers   = User::getRegUsers($start, $end);
        $loginUsers = UsersLoginLog::getLoginUser($start, $end);
        $result     = UsersBillingList::getStatistic($start, $end);
        $orders     = UsersBillingList::getOrderCount($start, $end);
        $data       = $result['recharge'];
        $result     = $result['conversion'];

        return view(
            'admin.statistics.index',
            [

                'placed_nums'       => json_encode(array_values($result['placed_nums'])),
                'pay_nums'          => json_encode(array_values($result['pay_nums'])),
                'date'              => json_encode(array_values($result['date'])),
                'percent'           => json_encode(array_values($result['percent'])),
                'amount_date'       => json_encode(array_values($data['date'])),
                'amount_total'      => json_encode(array_values($data['value'])),
                'head_orders_total' => $data['total'],
                'head_orders_nums'  => $orders['orders'],
                'head_pay_nums'     => $orders['users'],
                'head_reg_users'    => $regUsers['users'],
                'date_start'        => $start,
                'date_end'          => $end,
                'reg_date'          => json_encode(array_values($regUsers['date'])),
                'reg_total'         => json_encode(array_values($regUsers['value'])),
                'login_date'        => json_encode($loginUsers['date']),
                'login_total'       => json_encode($loginUsers['value']),
            ]
        );
    }

    public function create()
    {
        //
    }

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

        return view(
            'admin.billings.index_info',
            [
                'data' => UsersBillingList::whereFgOrderId((int)$id)->first()->toArray(),
            ]
        );
    }

    public function edit($id)
    {
        //
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param                          $id
     */
    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }

}
