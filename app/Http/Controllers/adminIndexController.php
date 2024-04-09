<?php

namespace App\Http\Controllers;
use App\Models\adminLogin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\feedback;

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
        // register the admin in config.php when using separate logins for admins 
        // auth() specify user in default so you must register the other table in auth
        if (auth()->guard('admin')->attempt($validated)) {
            // Authentication successful

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
        $feedbacks = feedback::query()
                    ->orderBy('id','desc')
                    ->get();
        return view('admin.feedbacks', compact('feedbacks'));
    }

    public function toFeature($id) {
        $reviewId = feedback::findOrFail($id);
        $reviewId->update([
            'featured' => 2
        ]);

        return redirect()->back();

    }
}
