<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class adminAccountsController extends Controller
{
    

    

    public function pending(){
        return view('admin.accounts.pending');
    }
}
