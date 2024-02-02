<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function home(){
        return view('user.homepage');
    }

    public function about_us() {
        return view('user.about_us');
    }

    public function Product() {
        return view('user.Product');
    }

    public function DIY() {
        return view('user.DIY');
    }
    public function userProfile() {
        if (session('isLoggedin')) {
            return view('user.userProfile');
        } else {
            return redirect()->to('/home');
        }
    }
    
}
