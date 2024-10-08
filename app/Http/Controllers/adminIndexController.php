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
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\AdminVerificationEmail;

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
     
        Mail::to('manage_accounts@astee.store')->send(new AdminVerificationEmail($validated['email']));
        return redirect()->back()->with(['success' => 'The verification was sent to the admin, please verify that this registration was aware of admin, thank you.']);

    }
    // changing password 
    public function changePassword(Request $request) {
        // validated the user inputs 
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
        // authenticate the user so we can retrieve its data using admin guard 
        $admin = Auth::guard('admin')->user();

        
        // check the user input and its password if they are the same 
        if(!Hash::check($request->oldPassword, $admin->password)) {
            return back()->withErrors(['oldPassword' => "Password Incorrect"]);
        }

        // hash the input 
        $admin->password = Hash::make($request->newPassword);
        // change the password 
        $admin->save();

        return redirect()->back()->with(['success' => 'Password Changed Successfully']);

    }
    // login process 
    public function adminLogin(Request $request){   
        $validated = $request->validate([
        'username' => 'required',
        'password' => 'required'
        ]);
        // register the admin in config.php when using separate logins for admins 
        // auth() specify user in default so you must register the other table in auth
        if (auth()->guard('admin')->attempt($validated)) {
            $admin = auth()->guard('admin')->user();
              // Authentication successful
            if($admin->email_verified_at > 0) {
                $request->session()->put('adminLoggedIn', true);
                $request->session()->regenerate();
                return redirect('/dashboard');
            }
            else{
                return back()->withErrors(['fail' => 'This user has not been verified yet, please contact your administrator']);
            }
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
        $feedbacks = DB::table('customers')
                    ->join('feedback', 'customers.id', '=', 'feedback.userId')
                    ->join('products', 'products.id', '=', 'feedback.productId')
                    ->select('customers.username', 'customers.profile','feedback.*','products.price','products.quantity','products.image_path')
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
