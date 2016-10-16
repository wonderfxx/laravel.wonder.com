<?php

namespace App\Http\Controllers\Admin\Games;

use App\Models\GameList;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Symfony\Component\HttpFoundation\JsonResponse;

class GamesListController extends Controller
{
    public $filter = [
        'game_code',
        'game_name',
        'game_coins_name',
        'game_type',
        'proportion_usd',
        'proportion_local',
        'proportion_local_currency',
        'game_status',
        'proportion_cp',
        'proportion_cp_currency',
        'kongregate_api_gid',
        'updated_at',
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
                'headers'     => GameList::getColumns(),
                'games'       => GameList::getGameNames(),
                'game_types'  => [
                    '0'      => '请选择游戏类型',
                    'mobile' => '手游',
                    'web'    => '页游',
                    'client' => '端游',
                    'other'  => '其它',
                ],
                'game_status' => [
                    '0' => '请选择游戏状态',
                    'Y' => '已上线',
                    'N' => '已下线',
                    'T' => '测试中',
                ],
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

        $columns = GameList::getColumns();
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
            'admin.games.index',
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
        return view('admin.games.index_add');
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
            'game_code' => 'required',
            'game_name' => 'required',
        ];
        $validator = \Validator::make($request->all(), $rules);
        if (!$validator->fails()) {
            $handler                            = new GameList();
            $handler->game_code                 = $request->get('game_code');
            $handler->game_name                 = $request->get('game_name');
            $handler->game_status               = $request->get('game_status');
            $handler->game_coins_name           = $request->get('game_coins_name');
            $handler->game_type                 = $request->get('game_type');
            $handler->game_logo                 = $request->get('game_logo');
            $handler->proportion_usd            = $request->get('proportion_usd');
            $handler->proportion_local          = $request->get('proportion_local');
            $handler->proportion_local_currency = $request->get('proportion_local_currency');
            $handler->proportion_cp             = $request->get('proportion_cp');
            $handler->proportion_cp_currency    = $request->get('proportion_cp_currency');
            $handler->recharge_api              = $request->get('recharge_api');
            $handler->charge_back_api           = $request->get('charge_back_api');
            $handler->server_list_api           = $request->get('server_list_api');
            $handler->kongregate_api_gid        = $request->get('kongregate_api_gid');
            $handler->kongregate_api_key        = $request->get('kongregate_api_key');
            $handler->kongregate_guest_key      = $request->get('kongregate_guest_key');

//            $handler->user_role_api             = $request->get('user_role_api');

            $handler->created_at = time();
            if (!$handler->whereGameCode($request->get('game_code'))
                         ->first()
            ) {
                $handler->save();

                return JsonResponse::create(['msg' => 'success'], 200);
            }
            else {
                return JsonResponse::create(['msg' => '游戏已经存在'], 422);
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
            'admin.games.index_info',
            [
                'data' => GameList::whereId((int)$id)->first()->toArray(),
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
            'admin.games.index_edit',
            [
                'data' => GameList::whereId((int)$id)->first(),
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
            'game_code' => 'required',
            'game_name' => 'required',
        ];
        $validator = \Validator::make($request->all(), $rules);
        if (!$validator->fails()) {

            $handler     = GameList::whereId($id)->first();
            $currentData = GameList::whereGameCode($request->get('game_code'))
                                   ->first();
            if (!$currentData || $currentData->id == $id) {
                $handler->game_code                 = $request->get('game_code');
                $handler->game_name                 = $request->get('game_name');
                $handler->game_status               = $request->get('game_status');
                $handler->game_coins_name           = $request->get('game_coins_name');
                $handler->game_type                 = $request->get('game_type');
                $handler->game_logo                 = $request->get('game_logo');
                $handler->proportion_usd            = $request->get('proportion_usd');
                $handler->proportion_local          = $request->get('proportion_local');
                $handler->proportion_local_currency = $request->get('proportion_local_currency');
                $handler->proportion_cp             = $request->get('proportion_cp');
                $handler->proportion_cp_currency    = $request->get('proportion_cp_currency');
                $handler->recharge_api              = $request->get('recharge_api');
                $handler->charge_back_api           = $request->get('charge_back_api');
                $handler->server_list_api           = $request->get('server_list_api');
                $handler->user_role_api             = $request->get('user_role_api');
                $handler->kongregate_api_gid        = $request->get('kongregate_api_gid');
                $handler->kongregate_api_key        = $request->get('kongregate_api_key');
                $handler->kongregate_guest_key      = $request->get('kongregate_guest_key');
                $handler->updated_at                = time();
                $handler->save();

                return JsonResponse::create(['msg' => 'success'], 200);
            }
            else {
                return JsonResponse::create(['msg' => '游戏已经存在'], 422);
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
    public function destroy($id)
    {
        if (empty($id)) {
            return JsonResponse::create(['error' => '无效参数'], 422);
        }
        $result = GameList::whereId((int)$id)->first();
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
    public function page()
    {

        //search
        $game_code   = Input::get('game_code');
        $game_status = Input::get('game_status');
        $game_type   = Input::get('game_type');

        //get data
        $handler = new GameList();
        $columns = \Schema::getColumnListing($handler->getTable());
        $result  = $handler
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
                $game_status,
                function ($query) use ($game_status) {
                    if ($game_status) {
                        return $query->whereGameStatus($game_status);
                    }
                    else {
                        return $query;
                    }
                }
            )
            ->when(
                $game_type,
                function ($query) use ($game_type) {
                    if ($game_type) {
                        return $query->whereGameType($game_type);
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
            switch ($items->game_status) {
                case 'Y':
                    $items->game_status = '<span class="label label-primary">已上线</span>';
                    break;
                case 'N':
                    $items->game_status = '<span class="label label-danger">已下线</span>';
                    break;
                case 'T':
                    $items->game_status = '<span class="label label-warning">测试中</span>';
                    break;
            }
            switch ($items->game_type) {
                case 'web':
                    $items->game_type = '<span class="label label-primary">页游</span>';
                    break;
                case 'client':
                    $items->game_type = '<span class="label label-primary">端游</span>';
                    break;
                case 'mobile':
                    $items->game_type = '<span class="label label-primary">手游</span>';
                    break;
                case 'other':
                    $items->game_type = '<span class="label label-primary">其它</span>';
                    break;
            }

            $items->created_at = $items->created_at == '0' ? '-' : date('Y-m-d H:i', $items->created_at);
            $items->updated_at = $items->updated_at == '0' ? '-' : date('Y-m-d H:i', $items->updated_at);
            $items->operation  = '
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
