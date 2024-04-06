<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Sold;
use App\Models\Processing;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

use Illuminate\Http\Request;

class userProfileController extends Controller
{
    // show the to pay products of user 
   public function toPay() {
    // get the user id 
    $userId = session('id');
    // get the product from processing based on user id 
        $product = Processing::
                              where('userId', $userId)
                            ->where('productStatus', 1)
                            ->get();
    // iterate through all the description table to limit to 7 wrods assign to displayDescription variable 
        foreach($product as $item) {
            $item->displayDescription = Str::words($item->description, 7);
        }
        // count all the products based on status 
        $toPayCount = $product->count();
        $toShipCount = Processing::where('userId',$userId)->where('productStatus', 2)->count(); 
        $toRecieveCount = Processing::where('userId',$userId)->where('productStatus', 3)->count();
        $feedBackCount = Processing::where('userId',$userId)->where('productStatus',4)->count();
        // return variables in view 
        return view('user.userProfile.myPurchase', 
        compact('product',
        'toPayCount',
        'toShipCount',
        'toRecieveCount',
        'feedBackCount'));
   }

    //filter the products 
   public function productStatus($status) {
    $userId = session('id');
    $product = Processing::where('userId', $userId)
                            ->where('productStatus', $status)
                            ->get();
    foreach($product as $item) {
        $item->displayDescription = Str::words($item->description, 6);
    }

    $toPayCount = Processing::where('userId',$userId)->where('productStatus', 1)->count();
    $toShipCount = Processing::where('userId',$userId)->where('productStatus',2)->count();
    $toRecieveCount = Processing::where('userId',$userId)->where('productStatus', 3)->count();
    $feedBackCount = Processing::where('userId',$userId)->where('productStatus',4)->count();
    return view('user.userProfile.myPurchase', 
    compact('product',
    'toPayCount',
    'toShipCount',
    'toRecieveCount',
    'feedBackCount'));
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
    public function orderRecieved(Request $request) {
        // validate the text boxes
        $validated = $request->validate([
            "productId" => "required",
            "userId" => "required",
            "amount" => "required",
            "quantity" => "required"
        ]);
        // get the id of the product 
        $productId = $validated["productId"];
        $product = Processing::findOrFail($productId);
        // update the product status from toRecieve(3) to toReview(4)
        $product->update([
            "productStatus" => 4
        ]);

        // when the user recieved the order insert the product into sold table 
        Sold::create([
            "productId" => $validated["productId"],
            "userId" => $validated["userId"],
            "amount" => $validated["amount"],
            "quantity" => $validated["quantity"]
        ]);
        
        return redirect()->back()->with('success', 'Order Moved to Feedback');
    }

}
