<?php

namespace App\Services;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class userLogin extends loginTemplate{
    public function userTypeAuthentication(Request $request)   
    {

    // Retrieve credentials from the request
    $credentials = $request->only('email', 'password');
    
    // Attempt to log in with the given credentials
    if (Auth::attempt($credentials)) {
        // Check if the user type matches the expected type
        if (Auth::user()->usertype == 'user') {
            // Correct userType, proceed with login
            $request->session()->regenerate();
            return redirect()->intended(route('home'));
        }
        else{
            Auth::logout();
            return back()->withErrors([
               // 'email' => trans('auth.failed'),
               'email' => 'Invalid login for this section. Please access the appropriate login page.',
            ])->onlyInput('email');
        }
        
    }
    }
}

