<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Crypt;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }


    public function verifyBankAccount(Request $request)
{

    $request->validate([
        'account_number' => 'digits:9|numeric',  
    ]);

    $accountNumber = $request->input('account_number');

    // Send account number to the external Java API
    $response = Http::post('http://localhost:8081/bank/verify', [
        'account_number' => $accountNumber,
    ]);

    if ($response->successful() && $response->json('exists') === true) {
        // Save the account number if validation is successful
        $user = Auth::user();
        
        $user->update([
            'account_number' => Crypt::encryptString($accountNumber)
        ]);

        return redirect()->back()->with('status', 'payment-updated');
    }

    return redirect()->back()->with('status', 'invalid-account-number');
}

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
