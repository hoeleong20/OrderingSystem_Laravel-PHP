<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;

use app\Models\User;

class HomeController extends Controller
{
    public function index()
    {
        if(Auth::id())
        {
            $usertype=Auth::user()->usertype;

            if($usertype=='user')
            {
                return view('welcome');
            }
            else
            {
                return view('admin.adminhome');
            }
        }
    }

}
