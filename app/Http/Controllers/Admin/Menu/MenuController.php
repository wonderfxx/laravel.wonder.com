<?php

namespace App\Http\Controllers\Admin\Menu;

use App\Http\Controllers\Controller;
use App\Models\AdmMenuList;
use App\Models\AdmUser;
use Collective\Html\HtmlBuilder;

class MenuController extends Controller
{

    public function index()
    {
//       $result = AdmUser::findOrFail();

        $result = AdmMenuList::all();

        return view('admin.menu.index',['data'=>$result]);
    }


}