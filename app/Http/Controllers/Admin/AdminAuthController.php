<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;

class AdminAuthController extends Controller
{
    public function showLoginForm()
    {
        return Inertia::render('Admin/Auth/Login');
    }

    public function login(Request $request)
    {
        $thongtin = [
            'email' => $request->email,
            'password' => $request->pass_hash,
            'vaitro' => 'admin'
        ];
        if (Auth::attempt($thongtin)) {
            $request->session()->regenerate();
            return redirect()->route('admin.dashboard');
        }


        return redirect()->route('admin.login')->with('error', 'Sai thông tin đăng nhập.');
    }
}
