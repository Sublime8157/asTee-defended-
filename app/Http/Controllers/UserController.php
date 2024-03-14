<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\OnHand;

class UserController extends Controller
{
    // Function for showing the homepage
    public function home(){
        return view('user.homepage');
    }
    // Function for about us UI
    public function about_us() {
        return view('user.about_us');
    }
    // Show the product tab 
   
    // Show the DIY tab 
    public function DIY() {
        return view('user.DIY');
    }

    //  If the user logged in show the users profile and retrieve its data as an array and assign to user variable, 
    // you can then get the data by calling the user variable and the table name ex: $user->colum name
    // redirect to the homepage when not  logged in 

    public function userProfile() {
       if(Auth::check()) {
            $user = Auth::user(); 
            return view('user.userProfile', ['user' => $user]);
       }
       else {
            return redirect()->to('\home');
       }
    }
    
    // Update the users information
    public function updateProfile(Request $request){
    // Validate the users input with Laravel default validation
    $request->validate([
        'fname' => 'nullable|string',
        'mname' => 'nullable|string',
        'lname' => 'nullable|string',
        'age' => 'nullable|integer',
        'email' => ['nullable', 'email', Rule::unique('customers', 'email')],
        'username' => ['nullable', Rule::unique('customers', 'username')],
    ]);

    // Find the user assigned to the variable 'user'
    $user = User::find(auth()->id());

    // Update user information based on the filled fields in the request
    $user->update([
        'fname' => $request->filled('fname') ? $request->fname : $user->fname,
        'mname' => $request->filled('mname') ? $request->mname : $user->mname,
        'lname' => $request->filled('lname') ? $request->lname : $user->lname,
        'age' => $request->filled('age') ? $request->age : $user->age,
        'email' => $request->filled('email') ? $request->email : $user->email,
        'username' => $request->filled('username') ? $request->username : $user->username,
    ]);

    return redirect()->to('userProfile');
}
// get the product id and user id to display in cart url 
    public function cart($prodId, $userId) {
        // find the prodcut id 
        $product = OnHand::findOrFail($prodId);
        // find the user id 
        $user = User::findOrFail($userId);
        return view('user.userCart', ['product' => $product, 'user' => $user]);
    }

   

    }
 

