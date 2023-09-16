<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function dashboard()
    {

        // dd(Auth::user()->role);
        // dd("hello");
        if (auth()->user()->roles == 2 || auth()->user()->roles == 1) {
            return view('pages.dashboard.admin');
        } else if (auth()->user()->roles == 3) {
            return view('pages.dashboard.user');
        }
    }
}
