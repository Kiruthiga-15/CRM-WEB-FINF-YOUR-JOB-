<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('user.login'); // Make sure this view exists
    }
}
