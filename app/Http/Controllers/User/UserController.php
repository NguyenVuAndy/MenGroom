<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Sanpham;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;

class UserController extends Controller
{
    function index()
    {
        $sanphams = Sanpham::with('loaisp', 'thuonghieu')->where('trangthaihienthi', 1)->orderBy('id', 'desc')->limit(8)->get();
        return Inertia::render('User/Index', [
            'sanphams' => $sanphams,
            'canLogin' => app('router')->has('login'),
            'canRegister' => app('router')->has('register'),
            'laravelVersion' => Application::VERSION,
            'phpVersion' => PHP_VERSION,
        ]);
    }
}
