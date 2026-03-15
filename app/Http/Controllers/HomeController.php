<?php

namespace App\Http\Controllers;





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
