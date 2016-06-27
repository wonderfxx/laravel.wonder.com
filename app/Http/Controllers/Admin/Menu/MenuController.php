<?php

namespace App\Http\Controllers\Admin\Menu;

use App\Http\Controllers\Controller;
use App\Models\AdmMenuList;
use App\Models\AdmMenuParentList;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Symfony\Component\HttpFoundation\JsonResponse;

class MenuController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
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

        return view('admin.menu.index', [
            'data'    => AdmMenuParentList::all(),
            'headers' => json_encode(array_values(AdmMenuList::getColumns()))
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
        return view('admin.menu.add',
                    [
                        'headerInfo'  => AdmMenuList::getColumns(),
                        'parentNames' => (new AdmMenuParentList())->getParentNames()
                    ]);
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
        $rules     = array(
            'menu_name'      => 'required',
            'menu_parent_id' => 'required|numeric',
            'menu_address'   => 'required',
            'menu_order'     => 'required|numeric',
            'menu_status'    => 'required'
        );
        $validator = \Validator::make($request->all(), $rules);
        if (!$validator->fails())
        {
            $handler                 = new AdmMenuList();
            $handler->menu_name      = $request->get('menu_name');
            $handler->menu_parent_id = $request->get('menu_parent_id');
            $handler->menu_address   = $request->get('menu_address');
            $handler->menu_order     = $request->get('menu_order');
            $handler->menu_status    = $request->get('menu_status');
            $handler->created_at     = time();
            $handler->save();

            return \Redirect::to('adm/menu');
        }
        else
        {
            return JsonResponse::create(['error' => '无效参数'], 422);
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
        //

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
        return view('admin.menu.edit', [
            'data'        => AdmMenuList::whereId((int)$id)->first(),
            'headerInfo'  => AdmMenuList::getColumns(),
            'parentNames' => (new AdmMenuParentList())->getParentNames()
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
        //
        $rules     = array(
            'menu_name'      => 'required',
            'menu_parent_id' => 'required|numeric',
            'menu_address'   => 'required',
            'menu_order'     => 'required|numeric',
            'menu_status'    => 'required'
        );
        $validator = \Validator::make($request->all(), $rules);
        if (!$validator->fails())
        {
            $handler = AdmMenuList::whereId($id)->first();
            if ($handler)
            {
                $handler->menu_name      = $request->get('menu_name');
                $handler->menu_parent_id = $request->get('menu_parent_id');
                $handler->menu_address   = $request->get('menu_address');
                $handler->menu_order     = $request->get('menu_order');
                $handler->menu_status    = $request->get('menu_status');
                $handler->updated_at     = time();
                $handler->save();

                return \Redirect::to('adm/menu');
            }
            else
            {
                return JsonResponse::create(['error' => '无效ID标识'], 422);
            }
        }
        else
        {
            return $validator->messages();
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
        $result = AdmMenuList::whereId((int)$id)->first();
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
        $menu_status    = Input::get('menu_status') == '0' ? '' : (Input::get('menu_status') == 'Y' ? 'Y' : 'N');
        $menu_parent_id = Input::get('menu_parent_id') == '0' ? '' : (int)Input::get('menu_parent_id');

        //get data
        $handler     = new AdmMenuList();
        $columns     = \Schema::getColumnListing($handler->getTable());
        $result      = $handler
            ->when($menu_status, function ($query) use ($menu_status)
            {
                if ($menu_status)
                {
                    return $query->whereMenuStatus($menu_status);
                }
                else
                {
                    return $query;
                }
            })
            ->when($menu_parent_id, function ($query) use ($menu_parent_id)
            {
                if ($menu_parent_id)
                {
                    return $query->whereMenuParentId($menu_parent_id);
                }
                else
                {
                    return $query;
                }
            })
            ->orderBy('menu_order')
            ->paginate(
                Input::get('pageSize'),
                $columns,
                'page',
                Input::get('pageNumber')
            );
        $parentNames = (new AdmMenuParentList())->getParentNames();
        foreach ($result->items() as $items)
        {
            if ($items->menu_status == 'Y')
            {
                $items->menu_status = '<span class="label label-primary">已启用</span>';
            }
            else
            {
                $items->menu_status = '<span class="label label-danger">未启用</span>';
            }
            $items->operation      = '
                <a class="btn btn-info btn-xs btn-outline" data-toggle="modal" data-target="#myModal"
                    href="/adm/menu/' . $items->id . '/edit" >
                    <i class="fa fa-edit btn-edit" ></i >
                </a >
                <a class="btn btn-danger btn-xs btn-outline" href="javascript:delMenu(' . $items->id . ')" >
                    <i class="fa fa-trash " ></i >
                </a >
            ';
            $items->updated_at     = $items->updated_at == '0' ? '-' : date('Y-m-d H:i', $items->updated_at);
            $items->created_at     = $items->created_at == '0' ? '-' : date('Y-m-d H:i', $items->created_at);
            $items->menu_parent_id = $parentNames[$items->menu_parent_id];
        }

        return $result;
    }

}