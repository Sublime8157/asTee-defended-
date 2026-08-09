<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\adminLogin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\feedback;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\DB;

class adminIndexController extends Controller
{
    // display login
    public function login() {
        return view('admin.login');
    }
    public function managePassword() {
        return view('admin.managePassword');
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
