<?php

namespace App\Http\Controllers\Admin\Statistics;

use App\Models\User;
use App\Models\UsersBillingList;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

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
        $regUsers   = User::getRegUsers();
        $loginUsers = User::getLoginUsers();
        $data       = UsersBillingList::getRechargeList();
        $result     = UsersBillingList::getConversionRate();

        return view(
            'admin.statistics.index',
            [

                'placed_nums'       => json_encode($result['placed_nums']),
                'pay_nums'          => json_encode($result['pay_nums']),
                'date'              => json_encode($result['date']),
                'percent'           => json_encode($result['percent']),
                'amount_date'       => json_encode($data['date']),
                'amount_total'      => json_encode($data['value']),
                'head_orders_total' => $data['total'],
                'head_orders_nums'  => UsersBillingList::getOrderCount(),
                'head_pay_nums'     => UsersBillingList::getUserCount(),
                'head_reg_users'    => $regUsers['users'],

                'reg_date'    => json_encode($regUsers['date']),
                'reg_total'   => json_encode($regUsers['value']),
                'login_date'  => json_encode($loginUsers['date']),
                'login_total' => json_encode($loginUsers['value']),

            ]

        );

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

        $data = UsersBillingList::whereFgOrderId((int)$id)->first()->toArray();
        print_r($data);
        die;

        return view(
            'admin.billings.index_info',
            [
                'data' => UsersBillingList::whereFgOrderId((int)$id)->first()->toArray(),
            ]
        );
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
