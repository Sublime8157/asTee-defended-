<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Sales;
use App\Models\orders;
use App\Models\Products;
use App\Models\Processing;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use App\Models\feedback;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Hash;


class userProfileController extends Controller
{

        
    // Update the users information
    public function updateUserInfo(Request $request){
        // Validate the users input with Laravel default validation
        $request->validate([
            'fname' => 'nullable|string',
            'mname' => 'nullable|string',
            'lname' => 'nullable|string',
            'age' => 'nullable|integer',
            'contact' => 'nullable',
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
            'contact' => $request->filled('contact') ? $request->contact : $user->contact,
            'username' => $request->filled('username') ? $request->username : $user->username,
            'address' => $request->filled('address') ? $request->address : $user->address,
        ]);
    
        return redirect()->back()->with(['success' => 'Updating Success!']);
    }

   //Update the user profile
   public function updateProfile(Request $request) {
        // validate the user uploaded image 
        $validated = $request->validate([
            "profile" => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);
        // get the original file name 
        $filename = $validated['profile']->getClientOriginalName();
        // upload the image to storage/public/images
        $validated['profile']->storeAs('public/images', $filename); 
        // get the user id  
        $id = session()->get('id');
        // find in customers(User) table 
        $userId = User::findOrFail($id);
        // update the user profile into the user uploaded image 
        $userId->update([
            'profile' => $filename
        ]);
        // return 
        return redirect()->back()->with('success', 'Profile Updated, Your Updated Profile Will Show On Your Next Login!');
    }

    // change password
    public function changePassword(Request $request) {
        $validated = $request->validate([
            "oldPassword" => 'required',
            "newPassword" => ["required", 
            Password::min(8)
                    ->letters()
                    ->mixedCase()
                    ->numbers()
                    ->uncompromised()
                    ->symbols()],
            "confirmPassword" => 'required|same:newPassword'
        ]);

        $user = Auth::user();

        if(!Hash::check($request->oldPassword, $user->password)) {
            return redirect()->back()->with(["Fail" => "Wrong Password!"]);
        }

        $user->password = $request->newPassword; 
        $user->save();

        return redirect()->back()->with(["success" => "Password Change Successfully!"]);
    }

     //Update the user profile
   public function uploadID(Request $request) {
    // validate the user uploaded image 
    $validated = $request->validate([
        "validID" => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
    ]);
    // get the original file name 
    $filename = $validated['validID']->getClientOriginalName();
    // upload the image to storage/public/images
    $validated['validID']->storeAs('public/images', $filename); 
    // get the user id  
    $id = session()->get('id');
    // find in customers(User) table 
    $userId = User::findOrFail($id);
    // update the user profile into the user uploaded image 
    $userId->update([
        'validID' => $filename
    ]);
    // return 
    return redirect()->back()->with('success', 'Thank you! for submitting your ID your account will be verified within 24h');
}
 
}
