<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    //
    
    public function __construct( )
    {

    }
    public function index()
    {
        //
       
        $func = "admin_view";
        $data['breadcrumb'] = '
        <li class="breadcrumb-item"><a href="#">/</a></li>
        <li class="breadcrumb-item active" aria-current="page"> Bảng điều khiển</li>';
        $data['active_menu']='dashboard';
        return view ('index');
   
        // echo 'i am admin';
    }
}
