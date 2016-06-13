<?php

namespace App\Http\Controllers\Admin\Menu;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class ParentController extends Controller
{
    //

    public function index(){
        return view('admin.menu.parent');
    }
}
