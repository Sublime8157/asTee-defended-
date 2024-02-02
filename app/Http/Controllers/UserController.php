<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;

class UserController extends Controller
{
    // Function for showing the homepage
    public function home(){
        return view('user.homepage');
    }
    // Function for about us UI
    public function about_us() {
        return view('user.about_us');
    }
    // Show the product tab 
    public function Product() {
        return view('user.Product');
    }
    // Show the DIY tab 
    public function DIY() {
        return view('user.DIY');
    }
    // If the user logged show the users profile redirect to the homepage when not logged in
    public function userProfile() {
       if(Auth::check()) {
            $user = Auth::user(); 
            return view('user.userProfile', ['user' => $user]);
       }
       else {
            return rediirect()->to('\home');
       }
    }
    // Retrieve the users data 
 
}
