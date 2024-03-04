<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;

class accountsController extends Controller
{
    
    public function displayUsers() {
        $userData = User::all();
        
        return view('admin.accounts.active', compact('userData'));
    }
}
