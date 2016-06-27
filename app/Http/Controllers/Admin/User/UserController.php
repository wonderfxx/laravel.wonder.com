<?php

namespace App\Http\Controllers\Admin\User;

use App\Models\AdmUser;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;

class UserController extends Controller
{
    /**
     * UserController constructor.
     */
    public function __construct()
    {
        $this->middleware('admin');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.user.index', [
            'headers' => json_encode(array_values(AdmUser::getColumns()))
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function profile()
    {
        return view('admin.user.profile');
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
            'data' => AdmUser::whereIn((int)$id)->first()->toArray(),
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
        $status   = Input::get('status') == '0' ? '' : Input::get('status');
        $userid   = Input::get('userid');
        $username = urldecode(Input::get('username'));
        $email    = urldecode(Input::get('email'));

        //get data
        $handler = new AdmUser();
        $columns = \Schema::getColumnListing($handler->getTable());
        $result  = $handler
            ->when($username, function ($query) use ($username)
            {
                if ($username)
                {
                    return $query->whereUsername($username);
                }
                else
                {
                    return $query;
                }
            })
            ->when($status, function ($query) use ($status)
            {
                if ($status)
                {
                    return $query->whereStatus($status);
                }
                else
                {
                    return $query;
                }
            })
            ->when($userid, function ($query) use ($userid)
            {
                if ($userid)
                {
                    return $query->whereUserid($userid);
                }
                else
                {
                    return $query;
                }
            })
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
            ->orderBy('updated_at', 'desc')
            ->paginate(
                Input::get('pageSize'),
                $columns,
                'page',
                Input::get('pageNumber')
            );
        foreach ($result->items() as $items)
        {
            switch ($items->status)
            {
                case 'Y':
                    $items->status = ' <span class="label label-primary" > 审核通过</span>';
                    break;
                case 'P':
                    $items->status = ' <span class="label label-warning" > 等待审核</span>';
                    break;
                case 'N':
                    $items->status = ' <span class="label label-danger"> 禁用账号</span>';
                    break;
            }
            $items->updated_at = date('Y-m-d H:i', $items->updated_at);
            $items->created_at = $items->created_at == '0' ? '-' : date('Y-m-d H:i', $items->created_at);
            $items->operation        = '
                <a class="btn btn-success btn-xs btn-outline" href="javascript:info(' . $items->id . ')" >
                    <i class="fa fa-search" ></i >
                </a >
            ';
        }

        return $result;
    }
}
