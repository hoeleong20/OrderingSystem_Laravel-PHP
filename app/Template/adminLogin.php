<?php

// Author: Ting Jian Hao

namespace App\Template;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class adminLogin extends loginTemplate{
    public function userTypeAuthentication(Request $request)   
    {

    // Retrieve credentials from the request
    $credentials = $request->only('email', 'password');
    
    // Attempt to log in with the given credentials
    if (Auth::attempt($credentials)) {
        // Check if the user type matches the expected type
        if (Auth::user()->usertype == 'admin') {
            // Correct userType, proceed with login
            $request->session()->regenerate();
            return redirect()->intended(route('admin.adminDashboard'));
        }
        else{
            Auth::logout();
            return back()->withErrors([
               'email' => 'Invalid login for this section. Please access the appropriate login page.',
            ])->onlyInput('email');
        }
        
    }
    }
}