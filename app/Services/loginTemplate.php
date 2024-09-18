<?php

namespace App\Services;

use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;


abstract class loginTemplate
{
    public function store(LoginRequest $request): RedirectResponse
{
    $request->authenticate();
    
    $redirect = $this->userTypeAuthentication($request);

    $request->session()->regenerate();

    return $redirect;
}

abstract protected function userTypeAuthentication(Request $request);

}

