<?php

namespace App\Http\Controllers\Admin\Billings;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;

class BillingUsersController extends Controller
{
    public $filter = ['password', 'remember','operation'];

    /**
     * UserController constructor.
     */
    public function __construct()
    {
        $this->middleware('admin');
        //共享数据
        view()->share([
                          'headers' => User::getColumns(),
                      ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $columns = User::getColumns();
        $return  = [];

        foreach ($columns as $val)
        {
            if (!in_array($val['field'], $this->filter))
            {
                $return[] = $val;
            }
        }
        $return[] = [
            'field' => 'operation',
            'title' => '操作',
            'align' => 'center',
        ];

        return view('admin.billings.users', [
            'headers' => json_encode($return),
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
        return view('admin.billings.users_info', [
            'data' => User::whereUserid((int)$id)->first()->toArray(),
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
        $user_id = Input::get('user_id');
        $email   = urldecode(Input::get('email'));

        //get data
        $handler = new User();
        $columns = \Schema::getColumnListing($handler->getTable());
        $result  = $handler
            ->when($email, function ($query) use ($email)
            {
                if ($email)
                {
                    return $query->whereEmail($email);
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
                    return $query->whereUserid($user_id);
                }
                else
                {
                    return $query;
                }
            })
            ->paginate(
                Input::get('pageSize'),
                $columns,
                'page',
                Input::get('pageNumber')
            );
        foreach ($result->items() as $items)
        {

            if ($items->status == 'Y')
            {
                $items->status = '<span class="label label-primary">正常用户</span>';
            }
            else
            {
                $items->status = '<span class="label label-danger">封禁用户</span>';
            }

            $items->created_at = $items->created_at == '0' ? '-' : date('Y-m-d H:i', $items->created_at);
            $items->updated_at = $items->updated_at == '0' ? '-' : date('Y-m-d H:i', $items->updated_at);
            $items->operation  = '
                <a class="btn btn-success btn-xs btn-outline" href="javascript:info(' . $items->userid . ')" >
                    <i class="fa fa-search" ></i >
                </a >
            ';
        }

        return $result;
    }
}
