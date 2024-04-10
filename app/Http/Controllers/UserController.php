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
use Illuminate\Support\Facades\Log;
use App\Models\feedback;
use App\Models\customers;

class UserController extends Controller
{
    // Function for showing the homepage
    public function home(){
    
       $feedback  = feedback::query()
                   ->selectRaw('customers.profile, customers.fname, DATE(feedback.created_at) as created_date, feedback.*')
                   ->join('customers','customers.id','=','feedback.userId')
                   ->where('featured',2)
                   ->latest('created_at')
                   ->take(3)
                   ->get();
       
       return view('user.homepage', compact('feedback'));
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
            return view('user.userProfile.myaccount', ['user' => $user]);
       }
       else {
            return redirect()->to('\home');
       }
    }
    public function userPurchase() {
        return view('user.userProfile.myPurchase');
     }
     public function userPassword() {
        return view('user.userProfile.myPassword');
     }



// store added product 
    public function store(Request $request) {
        // validate the user and product id 
        $validate = $request->validate([
            "userId" => 'required|exists:customers,id',
            "prodId" => 'required|exists:product_on_hand,id',
        ]);
        // check if it was already in the cart 
        $cartItem = Cart::where('userId', '=', $validate['userId'])->
                            where('productId', '=', $validate['prodId'])->count();
        // if it not yet in the cart add
        if($cartItem <= 0 ) {
            $cart = Cart::create([
                'userId' =>$validate['userId'],
                'productId' =>$validate['prodId'],
                'quantity' => 1
            ]);
        }
        // return back
        else {
            return redirect()->back()->with(['success' => 'Item was already in the cart']);
        }
        return redirect()->back()->with(['success' => 'Added to cart']);
    }


// display the user added to cart
    public function cart($userId) {
        // find the user id from cart assign to userCart
        $userCart = Cart::where('userId', $userId)->get();
        $products = [];
        $prodQty = [];

        // assign to cartItem all the userCart result
        foreach($userCart as $cartItem) {
            // find the productId column of Cart from OnHand  
            $product = OnHand::find($cartItem->productId);       
            $quantity = OnHand::where('id', $cartItem->productId)
                                ->value('quantity');
            $prodQty[$cartItem->productId] = $quantity;

            if($product){             
                // store to products array 
                $products[] = $product;   
            }
        }
     return view('user.userCart', compact('userCart','products','prodQty','userId'));
    }
    
    // remove a list of items  
    public function removeAll(Request $request) {
        $items = explode(',', $request->toRemove); // convert the strings into array recieved from toRemove input field
        $items = array_map('trim', $items); // Remove whitespace from each element
        $items = array_map('intval', $items); // Convert each element to an integer
       
        $listOfItems = Cart::whereIn('productId', $items); // use whereIn to remove a set of an array 
        $deleted = $listOfItems->delete();
        // Log the number of deleted items to verify the deletion
    
        return redirect()->back();
    }
    // remove single item 
    public function remove($id) {
        $removeItem = Cart::where('productId', $id);
        $removeItem->delete();

        return redirect()->back();
    }

    public function checkout(Request $request) {
        $data = $request->all();
    
        // Decode the JSON string into an array of objects
        $quantities = json_decode($data['quantity'], true);
        
        // get the items name from request expecting an array from it 
        $prodIdString = $data['items'];
        // separe the value using , 
        $prodId = explode(',', $prodIdString);
        $products = [];
        // iterate to each of the result from array 
        foreach($prodId as $prodItem) {
            // retrieve each of its data from OnHand
            $product = OnHand::find($prodItem);
            // if it is not empty 
            if($product) {
                // assign the value retrieve to array 
                $products[] = $product;
            }
        }
        $userInfo = User::all()->where('id', $data['userId']);
        if(count($products) <= 0) {
            return redirect()->back()->with(['error' => 'No selected product']);
        }   
        foreach($products as $prod) {
                $prod->displayDescription = Str::words($prod->description, 10);
        }
        return view('user.checkout', ["products" => $products, 
                                        "data" => $data, 
                                        "quantities" => $quantities,
                                        "userInfo" => $userInfo]);
    }
    
    
}
    

