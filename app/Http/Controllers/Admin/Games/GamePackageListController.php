<?php

namespace App\Http\Controllers\Admin\Games;

use App\Models\GameList;
use App\Models\GamePackageList;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use libraries\CommonFunc;
use Symfony\Component\HttpFoundation\JsonResponse;

class GamePackageListController extends Controller
{
    public $filter = ['game_code', 'country', 'channel_code', 'amount', 'currency',
                      'game_coins', 'game_coins_rewards', 'product_id', 'status',
                      'product_type', 'updated_at', 'status', 'id'];

    /**
     * UserController constructor.
     */
    public function __construct()
    {
        $this->middleware('admin');

        //共享数据
        view()->share([
                          'headers'    => GamePackageList::getColumns(),
                          'countries'  => CommonFunc::getCountriesCode(),
                          'currencies' => CommonFunc::getCurrenciesCode(),
                          'games'      => GameList::getGameNames(),
                          'channels'   => ['kongregate' => 'Kongregate']
                      ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $columns = GamePackageList::getColumns();
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

        return view('admin.games.package', [
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
        return view('admin.games.package_add');
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
        $rules     = array(
            'game_code'    => 'required',
            'country'      => 'required',
            'channel_code' => 'required',
            'product_id'   => 'required',
            'amount'       => 'required',
            'currency'     => 'required',
            'game_coins'   => 'required',
        );
        $validator = \Validator::make($request->all(), $rules);
        if (!$validator->fails())
        {
            $handler                   = new GamePackageList();
            $handler->game_code        = $request->get('game_code');
            $handler->country          = $request->get('country');
            $handler->channel_code     = $request->get('channel_code');
            $handler->channel_sub_code = $request->get('channel_sub_code');
            $handler->product_id       = $request->get('product_id');

            $handler->amount        = $request->get('amount');
            $handler->currency      = $request->get('currency');
            $handler->currency_show = $request->get('currency');
            $handler->game_coins    = $request->get('game_coins');

            $handler->product_name        = $request->get('product_name');
            $handler->product_description = $request->get('product_description');
            $handler->product_type        = $request->get('product_type') ?: 'normal';
            $handler->product_logo        = $request->get('product_logo');
            $handler->status              = $request->get('status');
            $handler->game_coins_rewards  = $request->get('game_coins_rewards');
            $handler->amount_usd          = $request->get('amount_usd');

            $handler->created_at = time();
            if (!$handler->whereGameCode($request->get('game_code'))
                         ->whereCountry($request->get('country'))
                         ->whereChannelCode($request->get('channel_code'))
                         ->whereChannelSubCode($request->get('channel_sub_code'))
                         ->whereProductId($request->get('product_id'))
                         ->first()
            )
            {
                $handler->save();

                return JsonResponse::create(['msg' => 'success'], 200);
            }
            else
            {
                return JsonResponse::create(['msg' => '产品ID已经存在'], 422);
            }
        }
        else
        {
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
        return view('admin.games.package_info', [
            'data' => GamePackageList::whereId((int)$id)->first()->toArray(),
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
        return view('admin.games.package_edit', [
            'data' => GamePackageList::whereId((int)$id)->first(),
        ]);
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
        $rules     = array(
            'game_code'    => 'required',
            'country'      => 'required',
            'channel_code' => 'required',
            'product_id'   => 'required',
            'amount'       => 'required',
            'currency'     => 'required',
            'game_coins'   => 'required',
        );
        $validator = \Validator::make($request->all(), $rules);
        if (!$validator->fails())
        {
            $handler     = GamePackageList::whereId($id)->first();
            $currentData = GamePackageList::whereGameCode($request->get('game_code'))
                                   ->whereCountry($request->get('country'))
                                   ->whereChannelCode($request->get('channel_code'))
                                   ->whereChannelSubCode($request->get('channel_sub_code'))
                                   ->whereProductId($request->get('product_id'))
                                   ->first();
            if (!$currentData || $currentData->id == $id)
            {
                $handler->game_code        = $request->get('game_code');
                $handler->country          = $request->get('country');
                $handler->channel_code     = $request->get('channel_code');
                $handler->channel_sub_code = $request->get('channel_sub_code');
                $handler->product_id       = $request->get('product_id');

                $handler->amount        = $request->get('amount');
                $handler->currency      = $request->get('currency');
                $handler->currency_show = $request->get('currency');
                $handler->game_coins    = $request->get('game_coins');

                $handler->product_name        = $request->get('product_name');
                $handler->product_description = $request->get('product_description');
                $handler->product_type        = $request->get('product_type') ?: 'normal';
                $handler->product_logo        = $request->get('product_logo');
                $handler->status              = $request->get('status');
                $handler->game_coins_rewards  = $request->get('game_coins_rewards');
                $handler->amount_usd          = $request->get('amount_usd');

                $handler->updated_at = time();
                $handler->save();

                return JsonResponse::create(['msg' => 'success'], 200);
            }
            else
            {
                return JsonResponse::create(['msg' => '产品ID已经存在'], 422);
            }
        }
        else
        {
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
        if (empty($id))
        {
            return JsonResponse::create(['error' => '无效参数'], 422);
        }
        $result = GamePackageList::whereId((int)$id)->first();
        if (empty($result))
        {
            return JsonResponse::create(['error' => '无效ID标识'], 422);
        }
        if ($result->delete())
        {
            return JsonResponse::create(['success' => '删除成功']);
        }
        else
        {
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
        $game_code    = Input::get('game_code');
        $channel_code = Input::get('channel_code');
        $id           = Input::get('id');
        $status       = Input::get('status');

        //get data
        $handler = new GamePackageList();
        $columns = \Schema::getColumnListing($handler->getTable());
        $result  = $handler
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
            ->when($game_code, function ($query) use ($game_code)
            {
                if ($game_code)
                {
                    return $query->whereGameCode($game_code);
                }
                else
                {
                    return $query;
                }
            })
            ->when($channel_code, function ($query) use ($channel_code)
            {
                if ($channel_code)
                {
                    return $query->whereChannelCode($channel_code);
                }
                else
                {
                    return $query;
                }
            })
            ->when($id, function ($query) use ($id)
            {
                if ($id)
                {
                    return $query->whereId($id);
                }
                else
                {
                    return $query;
                }
            })
            ->orderBy('created_at', 'desc')
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
                    $items->status = '<span class="label label-primary">已启用</span>';
                    break;
                case 'N':
                    $items->status = '<span class="label label-danger">未启用</span>';
                    break;
            }
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
