<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Processing;
use Illuminate\Support\Str;

use Illuminate\Http\Request;

class userProfileController extends Controller
{
    // show the to pay products of user 
   public function toPay() {
    $userId = session('id');
        $product = Processing::
                              where('userId', $userId)
                            ->where('productStatus', 1)
                            ->get();

        foreach($product as $item) {
            $item->displayDescription = Str::words($item->description, 7);
        }
        $toPayCount = $product->count();
        $toShipCount = Processing::where('userId',$userId)->where('productStatus', 2)->count(); 
        $toRecieveCount = Processing::where('userId',$userId)->where('productStatus', 3)->count();
        $feedBackCount = Processing::where('userId',$userId)->where('productStatus',4)->count();

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
        $item->displayDescription = Str::words($item->description, 7);
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
}
