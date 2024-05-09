<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\User;
use App\Http\Controllers\Hash;
use App\Http\Controllers\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;
use App\Models\Cart;
use Illuminate\Support\Facades\Mail;
use App\Mail\VerificationEmail;

class LoginSignupController extends Controller
{
   // Show the login form 
   
   public  function LoginSignup() {

    return view('login\registration.login');

   }
   
// Store the data into the database 
   public function store(Request $request){
      // validate the user inputs 
      $validated = $request->validate([
         "fname" => 'required',
         "lname" => 'required',
         "mname",
         "profile",
         'contact' => 'required|numeric',
         "birthday" => 'required|date',
         'address' => 'required',
         "userStatus" => 'required|numeric',
         "email" => ['required', 'email', Rule::unique('customers', 'email')],
         "username" => ['required', Rule::unique('customers', 'username')],
         "password" => ['required','confirmed', 
         Password::min(8)
            ->letters()
            ->mixedCase()
            ->numbers()
            ->symbols()
            ->uncompromised()
      ]
      ]);
      // bycrpt the user password or hash to protect the user password  
      $validated['password'] = bcrypt($validated['password']);
      $validated['profile'] = 'default.png';
      // inser the information when validating is success 
      $user = User::create($validated);
      
      // verify the email 
      Mail::to($user->email)->send(new VerificationEmail($user));
      
   }
   

   //Login Function 
   public function process(Request $request) {
      $validated = $request->validate([
         "username" => 'required',
         "password" => 'required','current_password'
      ]);
     
      if(auth()->attempt($validated)) {
         
         $user = auth()->user();        
         $request->session()->put('isLoggedin', true);
         $request->session()->put('username', $user->username);
         $request->session()->put('id', $user->id);
         $request->session()->put('profile', $user->profile);

         $request->session()->regenerate();
         
         return redirect('/home');
        
      }

      return back()->withErrors(['username' => 'Invalid Credentials'])->withInput();
     
   }


// Logout Function
   public function logout(Request $request) {
      auth()->logout();

      $request->session()->invalidate();
      $request->session()->regenerateToken();

      return redirect('/');
   }


}
