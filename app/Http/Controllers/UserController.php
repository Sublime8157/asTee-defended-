<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\OnHand;
use App\Models\Cart;
use Illuminate\Support\Str;

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

// store added product 
    public function store(Request $request) {
        $validate = $request->validate([
            "userId" => 'required|exists:customers,id',
            "prodId" => 'required|exists:product_on_hand,id',
        ]);
        $cart = Cart::create([
            'userId' =>$validate['userId'],
            'productId' =>$validate['prodId']
        ]);
        return redirect()->back()->with(['success' => 'Added to cart']);
    }
// display the user added to cart
    public function cart($userId) {
        // find the user id from cart assign to userCart
        $userCart = Cart::where('userId', '=', $userId)->get();
        $products = [];
        // assign to cartItem all the userCart result
        foreach($userCart as $cartItem) {
            // find the productId column of Cart from OnHand
        
            $product = OnHand::find($cartItem->productId);
            
            if($product){
               
                // store to products array 
                $products[] = $product;
                
            }
           
        }

   
       
        return view('user.userCart', compact('userCart','products'));
    }
}
    

