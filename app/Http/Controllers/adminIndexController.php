<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\adminLogin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\feedback;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\Rule;


class adminIndexController extends Controller
{
    // display login
    public function login() {
        return view('admin.login');
    }
    public function registerAccount() {
        return view('admin.registration');
    }
    public function managePassword() {
        return view('admin.managePassword');
    }
    public function submitRegistration(Request $request) {
        $validated = $request->validate([
            'fname'  => "required|string",
            'mname' => "required|string",
            'lname' => "required|string",
            'age' => "required|numeric",
            'email' => ['required', 'email', Rule::unique('admin_login', 'email')],
            'username' => ['required',  Rule::unique('admin_login', 'username')],
            "password" => ['required','confirmed', 
            Password::min(8)
               ->letters()
               ->mixedCase()
               ->numbers()
               ->symbols()
               ->uncompromised()],
        ]);

        $validated['password'] = bcrypt($validated['password']);
        $validated['profile'] = 'adminIcon.png';
        adminLogin::create($validated);
        
        return redirect()->back()->with(['success' => 'Registered Successfully']);

    }
    // changing password 
    public function changePassword(Request $request) {
        $validated = $request->validate([
            'oldPassword' => 'required',
            'confirmPassword' => 'required|same:newPassword',
            "newPassword" => ['required',
            Password::min(8)
                ->letters()
                ->mixedCase()
                ->numbers()
                ->symbols()
                ->uncompromised()]
        ]);
        $admin = Auth::guard('admin')->user();

        

        if(!Hash::check($request->oldPassword, $admin->password)) {
            return back()->withErrors(['oldPassword' => "Password Incorrect"]);
        }

        $admin->password = Hash::make($request->newPassword);
        $admin->save();

        return redirect()->back()->with(['success' => 'Password Changed Successfully']);

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
        auth()->guard('admin')->logout();

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
