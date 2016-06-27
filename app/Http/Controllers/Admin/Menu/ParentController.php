<?php

namespace App\Http\Controllers\Admin\Menu;

use App\Models\AdmMenuParentList;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Symfony\Component\HttpFoundation\JsonResponse;

class ParentController extends Controller
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

    public function index()
    {
        return view('admin.menu.parent', [
            'headers' => json_encode(array_values(AdmMenuParentList::getColumns()))
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
        return view('admin.menu.add_parent',
                    [
                        'headerInfo'  => AdmMenuParentList::getColumns(),
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
        //
        $rules     = array(
            'menu_name'   => 'required',
            'menu_order'  => 'required|numeric',
            'menu_icon'   => 'required',
            'menu_status' => 'required'
        );
        $validator = \Validator::make($request->all(), $rules);
        if (!$validator->fails())
        {
            $handler              = new AdmMenuParentList();
            $handler->menu_name   = $request->get('menu_name');
            $handler->menu_order  = $request->get('menu_order');
            $handler->menu_status = $request->get('menu_status');
            $handler->menu_icon   = $request->get('menu_icon');
            $handler->updated_at  = time();
            $handler->save();

            return \Redirect::to('adm/parent');
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
        return view('admin.menu.edit_parent', [
            'data'       => AdmMenuParentList::whereId((int)$id)->first(),
            'headerInfo' => AdmMenuParentList::getColumns(),
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
            'menu_name'   => 'required',
            'menu_order'  => 'required|numeric',
            'menu_icon'   => 'required',
            'menu_status' => 'required'
        );
        $validator = \Validator::make($request->all(), $rules);
        if (!$validator->fails())
        {
            $handler = AdmMenuParentList::whereId($id)->first();
            if ($handler)
            {
                $handler->menu_name   = $request->get('menu_name');
                $handler->menu_order  = $request->get('menu_order');
                $handler->menu_status = $request->get('menu_status');
                $handler->menu_icon   = $request->get('menu_icon');
                $handler->updated_at  = time();
                $handler->save();

                return \Redirect::to('adm/parent');
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
        $result = AdmMenuParentList::whereId((int)$id)->first();
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
        $menu_status = Input::get('menu_status') == '0' ? '' : (Input::get('menu_status') == 'Y' ? 'Y' : 'N');

        //get data
        $handler = new AdmMenuParentList();
        $columns = \Schema::getColumnListing($handler->getTable());
        $result  = $handler
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
            ->orderBy('menu_order')
            ->paginate(
                Input::get('pageSize'),
                $columns,
                'page',
                Input::get('pageNumber')
            );
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

            $items->updated_at = date('Y-m-d H:i', $items->updated_at);
            $items->created_at = $items->created_at == '0' ? '-' : date('Y-m-d H:i', $items->created_at);
            $items->operation  = '
                <a class="btn btn-info btn-xs btn-outline" data-toggle="modal" data-target="#myModal"
                    href="/adm/parent/' . $items->id . '/edit" >
                    <i class="fa fa-edit btn-edit" ></i >
                </a >
                <a class="btn btn-danger btn-xs btn-outline" href="javascript:delMenu(' . $items->id . ')" >
                    <i class="fa fa-trash " ></i >
                </a >
            ';
        }

        return $result;
    }
}
