<?php

namespace App\Http\Controllers;


// Author: Ting Jian Hao


class HomeController extends Controller
{
    public function index()
    {   
            return view('welcome');
    }

    public function adminIndex()
    {
        return view('admin.adminhome');
    }

}
