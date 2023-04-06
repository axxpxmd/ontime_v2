<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function index()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'username'  => ['required'],
            'password'  => ['required']
        ]);
        
        if (!auth()->attempt(['username' => $request->username, 'password' =>  $request->password])) {
            return redirect()->back()->with('error', 'Username / Password Salah.');
        }else{
            return redirect()->route('kehadiran');
        }

    }

    public function logout()
    {
        auth()->logout();
        return redirect()->route('login');
    }
}
