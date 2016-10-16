<?php

namespace App\Http\Controllers\Admin\Games;

use App\Models\GameList;
use App\Models\GameServerList;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Symfony\Component\HttpFoundation\JsonResponse;

class GameServerListController extends Controller
{
    public $filter = [
        'game_code',
        'server_id',
        'server_open_at',
        'server_close_at',
        'game_coins_rewards',
        'status',
        'updated_at',
        'id',
    ];

    /**
     * UserController constructor.
     */
    public function __construct()
    {
        $this->middleware('admin');
        //共享数据
        view()->share(
            [
                'headers' => GameServerList::getColumns(),
                'games'   => GameList::getGameNames(),
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
        $columns = GameServerList::getColumns();
        $return  = [];

        foreach ($columns as $val) {
            if (in_array($val['field'], $this->filter)) {
                $return[] = $val;
            }
        }
        $return[] = [
            'field' => 'operation',
            'title' => '操作',
            'align' => 'center',
        ];

        return view(
            'admin.games.server',
            [
                'headers' => json_encode($return),
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
        return view('admin.games.server_add');
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
        $rules     = [
            'game_code'   => 'required',
            'server_id'   => 'required',
            'server_name' => 'required',
        ];
        $validator = \Validator::make($request->all(), $rules);
        if (!$validator->fails()) {
            $handler                  = new GameServerList();
            $handler->game_code       = $request->get('game_code');
            $handler->server_id       = $request->get('server_id');
            $handler->server_name     = $request->get('server_name');
            $handler->server_type     = $request->get('server_type');
            $handler->server_open_at  = $request->get('server_open_at') ? strtotime(
                $request->get
                (
                    'server_open_at'
                )
            ) : 0;
            $handler->server_close_at = $request->get('server_close_at') ? strtotime(
                $request->get
                (
                    'server_close_at'
                )
            ) : 0;
            $handler->server_lang     = $request->get('server_lang');
            $handler->server_region   = $request->get('server_region');
            $handler->server_address  = $request->get('server_address');
            $handler->status          = $request->get('status');

            $handler->created_at = time();
            if (!$handler->whereGameCode($request->get('game_code'))
                         ->whereServerId($request->get('server_id'))
                         ->whereServerType($request->get('server_type'))
                         ->first()
            ) {
                $handler->save();

                return JsonResponse::create(['msg' => 'success'], 200);
            }
            else {
                return JsonResponse::create(['msg' => '服务器ID已经存在'], 422);
            }
        }
        else {
            return JsonResponse::create(['msg' => '缺少必填参数'], 422);
        }
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
            'admin.games.server_info',
            [
                'data' => GameServerList::whereId((int)$id)->first()->toArray(),
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
        return view(
            'admin.games.server_edit',
            [
                'data' => GameServerList::whereId((int)$id)->first(),
            ]
        );
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
        $rules     = [
            'game_code'   => 'required',
            'server_id'   => 'required',
            'server_name' => 'required',
        ];
        $validator = \Validator::make($request->all(), $rules);
        if (!$validator->fails()) {
            $handler     = GameServerList::whereId($id)->first();
            $currentData = GameServerList::whereGameCode($request->get('game_code'))
                                         ->whereServerId($request->get('server_id'))
                                         ->whereServerType($request->get('server_type'))
                                         ->first();
            if (!$currentData || $currentData->id == $id) {
                $handler->game_code       = $request->get('game_code');
                $handler->server_id       = $request->get('server_id');
                $handler->server_name     = $request->get('server_name');
                $handler->server_type     = $request->get('server_type');
                $handler->server_open_at  = $request->get('server_open_at') ? strtotime(
                    $request->get
                    (
                        'server_open_at'
                    )
                ) : 0;
                $handler->server_close_at = $request->get('server_close_at') ? strtotime(
                    $request->get
                    (
                        'server_close_at'
                    )
                ) : 0;
                $handler->server_lang     = $request->get('server_lang');
                $handler->server_region   = $request->get('server_region');
                $handler->server_address  = $request->get('server_address');
                $handler->status          = $request->get('status');

                $handler->updated_at = time();
                $handler->save();

                return JsonResponse::create(['msg' => 'success'], 200);
            }
            else {
                return JsonResponse::create(['msg' => '服务器ID已经存在'], 422);
            }
        }
        else {
            return JsonResponse::create(['msg' => '缺少必填参数'], 422);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public
    function destroy($id)
    {
        if (empty($id)) {
            return JsonResponse::create(['error' => '无效参数'], 422);
        }
        $result = GameServerList::whereId((int)$id)->first();
        if (empty($result)) {
            return JsonResponse::create(['error' => '无效ID标识'], 422);
        }
        if ($result->delete()) {
            return JsonResponse::create(['success' => '删除成功']);
        }
        else {
            return JsonResponse::create(['error' => '删除失败'], 422);
        }
    }

    /**
     * 处理分页
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public
    function page()
    {

        //search
        $game_code = Input::get('game_code');
        $server_id = Input::get('server_id');
        $status    = Input::get('status');

        //get data
        $handler = new GameServerList();
        $columns = \Schema::getColumnListing($handler->getTable());
        $result  = $handler
            ->when(
                $status,
                function ($query) use ($status) {
                    if ($status) {
                        return $query->whereStatus($status);
                    }
                    else {
                        return $query;
                    }
                }
            )
            ->when(
                $game_code,
                function ($query) use ($game_code) {
                    if ($game_code) {
                        return $query->whereGameCode($game_code);
                    }
                    else {
                        return $query;
                    }
                }
            )
            ->when(
                $server_id,
                function ($query) use ($server_id) {
                    if ($server_id) {
                        return $query->whereServerId($server_id);
                    }
                    else {
                        return $query;
                    }
                }
            )
            ->orderBy('created_at', 'desc')
            ->paginate(
                Input::get('pageSize'),
                $columns,
                'page',
                Input::get('pageNumber')
            );
        foreach ($result->items() as $items) {

            switch ($items->status) {
                case 'Y':
                    $items->status = '<span class="label label-primary">已启用</span>';
                    break;
                case 'T':
                    $items->status = '<span class="label label-info">测试中</span>';
                    break;
                case 'N':
                    $items->status = '<span class="label label-danger">未启用</span>';
                    break;
            }
            $items->server_close_at = $items->server_close_at == '0' ? '-' : date('Y-m-d H:i', $items->server_close_at);
            $items->server_open_at  = $items->server_open_at == '0' ? '-' : date('Y-m-d H:i', $items->server_open_at);
            $items->updated_at      = $items->updated_at == '0' ? '-' : date('Y-m-d H:i', $items->updated_at);
            $items->operation       = '
                <a class="btn btn-success btn-xs btn-outline" href="javascript:info(' . $items->id . ')" >
                    <i class="fa fa-search" ></i >
                </a >
                <a class="btn btn-info btn-xs btn-outline" href="javascript:edit(' . $items->id . ')" >
                    <i class="fa fa-edit" ></i >
                </a >
                <a class="btn btn-danger btn-xs btn-outline" href="javascript:del(' . $items->id . ')" >
                    <i class="fa fa-trash" ></i >
                </a >
            ';
        }

        return $result;
    }
}
