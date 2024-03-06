<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\User;
use App\Http\Controllers\Hash;
use App\Http\Controllers\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;


class LoginSignupController extends Controller
{
   // Show the login form 
   
   public  function LoginSignup() {

    return view('login\registration.login');

   }
   
// Store the data into the database 
   public function store(Request $request){
      $validated = $request->validate([
         "fname" => 'required',
         "lname" => 'required',
         "mname" => 'required',
         "age" => 'required',
         "userStatus" => 'required',
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

      $validated['password'] = bcrypt($validated['password']);
      
      $user = User::create($validated);
      return $user;
     
      auth()->login($user);
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

      return redirect('/home');
   }


}
