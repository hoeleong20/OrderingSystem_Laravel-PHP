<?php




namespace App\Template;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;


class userLogin extends loginTemplate{
    public function userTypeAuthentication(Request $request)   
    {

    // Retrieve credentials from the request
    $credentials = $request->only('email', 'password');
    
    // Attempt to log in with the given credentials
    if (Auth::attempt($credentials)) {
      
        $user = Auth::user();

        if ($user->usertype == 'user') {
            // Correct userType, proceed with login
            $request->session()->regenerate();

            $request->user()->update([
                'last_login' => Carbon::now()->toDateTimeString(),
            ]);

            session()->put('customerID', $user->id);

            return redirect()->route('home');
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

