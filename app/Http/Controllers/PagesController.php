<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Http\Controllers\AdminController;



class PagesController extends Controller
{
    public function details()
    {
        if (Auth::check()) {
            $username = Auth::user()->name;
            $email = Auth::user()->email;
            return view('user.details')->with('username', $username)->with('email', $email);
        }
        else{
            return redirect()->route('home');
        }
    }
}
