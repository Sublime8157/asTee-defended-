<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class adminAccountsController extends Controller
{
    public function active(){
        return view('admin.accounts.active');
    }

    public function denied(){
        return view('admin.accounts.denied');
    }

    public function pending(){
        return view('admin.accounts.pending');
    }
}
