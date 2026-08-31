<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        if (Auth::check()) {
            if (Auth::user()->hasRole('admin')) {
                return redirect()->route('sarana.index');
            } elseif (Auth::user()->hasRole('user')) {
                return redirect()->route('user.data.index');
            }
        }

        return view('landing.index');
    }
}
