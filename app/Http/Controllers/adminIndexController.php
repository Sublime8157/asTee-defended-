<?php

namespace App\Http\Controllers;
use App\Models\adminLogin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
class adminIndexController extends Controller
{
    // display login
    public function login() {

        return view('admin.login');
    }

    // login process 
    public function adminLogin(Request $request){   
        $validated = $request->validate([
           'username' => 'required',
           'password' => 'required','current_password'
        ]);

        if(auth()->attempt($validated)) {
            $user = auth()->user();

            $request->session()->put('adminLoggedIn', true);
            $request->session()->regenerate();

            return redirect('/dashboard');
        }
        return back()->withErrors(['username' => 'Invalid Credentials'])->withInput();
    }
    // logout process 

    public function adminLogout(Request $request) {
        auth()->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/loginAdmin');
    }
  
    public function feedbacks() {
        return view('admin.feedbacks');
    }
}
