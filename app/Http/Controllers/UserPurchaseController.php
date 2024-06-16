<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Products;
use App\Models\Processing;
use App\Models\OnHand;
use App\Models\CancelReturn;
use App\Models\Variations;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Route;
use App\Models\orders;
use Illuminate\Support\Str;
use App\Models\Sales;
use App\Models\feedback;
use Illuminate\Support\Facades\DB;


class UserPurchaseController extends Controller
{

        
//     // show the to pay products of user 
public function toPay($status) {
    $productStatus = $status;
    $userId = session('id');

    $product = Processing::where('userId', $userId)
                            ->where('productStatus', 1)->get();
    $orderDetails = orders::select('mop','address','contact')
                            ->where('userId', $userId)->get();
    
    $orderDetails = $orderDetails->first();
    
    $product->transform(function ($item) use ($orderDetails) {
        $item->mop = $orderDetails->mop;
        $item->address = $orderDetails->address;
        return $item;
    });
    foreach ($product as $item) {
        $item->displayDescription = Str::words($item->description, 6);
    }

    $toPayCount = Processing::where('userId', $userId)->where('productStatus', 1)->count();
    $toShipCount = Processing::where('userId', $userId)->where('productStatus', 2)->count();
    $toRecieveCount = Processing::where('userId', $userId)->where('productStatus', 3)->count();
    $feedBackCount = Processing::where('userId', $userId)->where('productStatus', 4)->count();

    return view('user.userProfile.myPurchase', compact('orderDetails','product', 'toPayCount', 'toShipCount', 'toRecieveCount', 'feedBackCount'));
  
}

    //filter the products 
    public function productStatus($status) {
        $productStatus = $status;
        $userId = session('id');
        $product = Processing::where('userId', $userId)
                                ->where('productStatus', $productStatus)->get();
    
        $toPayCount = Processing::where('userId', $userId)->where('productStatus', 1)->count();
        $toShipCount = Processing::where('userId', $userId)->where('productStatus', 2)->count();
        $toRecieveCount  = Processing::where('userId', $userId)->where('productStatus', 3)->count();
        $feedBackCount = Processing::where('userId', $userId)->where('productStatus', 4)->count();
    
        $product->transform(function ($item) use ($userId) {
            $orderDetails = orders::select('mop', 'address', 'contact')
                                    ->where('userId', $userId)->first();
    
            $item->mop = $orderDetails->mop;
            $item->address = $orderDetails->address;
            $item->displayDescription = Str::words($item->description, 6);
    
            return $item;
        });
    
        return view('user.userProfile.myPurchase', compact('product', 'toPayCount', 'toShipCount', 'toRecieveCount', 'feedBackCount'));
    }
    
    

    

    // remove a product then submit to canel or return 
    public function submitToCancel(Request $request, $id) {
        $validated = $request->validate([
            'userId' => 'required|exists:customers,id',
            'image_path' => 'required',
            'variation_id' => 'required|numeric',
            'description' => 'required',
            'reason' => 'required',
            'gender' => 'required|numeric',
            'size' => 'required|numeric',
            'price' => 'required|numeric',
            'quantity' => 'required|numeric',
            'total' => 'required|numeric'
        ]);

        CancelReturn::create([
            'userId' => $validated['userId'],
            'image_path' => $validated['image_path'],
            'variation_id' => $validated['variation_id'],
            'description' => $validated['description'],
            'reason' => $validated['reason'],
            'specify' => $request->specify,
            'gender' => $validated['gender'],
            'size' => $validated['size'],
            'price' => $validated['price'],
            'quantity' => $validated['quantity'],
            'total' => $validated['total']
        ]);

        $idOrders = orders::where('productId',$id);
        $idOrders->delete();
        
        $idProcessing = Processing::findOrFail($id);
        $idProcessing->delete();

        return redirect()->back()->with('Success','Your Order was Cancelled Successfully');
    }
    // user recieving confirming order recieved 
    public function orderRecieved(Request $request) {
        // validate the text boxes
        $validated = $request->validate([
            "productId" => "required",
            "userId" => "required",
            "amount" => "required",
            "quantity" => "required",
        ]);
        // get the id of the product 
        $productId = $validated["productId"];
        $product = Processing::findOrFail($productId);
        // update the product status from toRecieve(3) to toReview(4)
        $product->update([
            "productStatus" => 4
        ]);        
        //insert to sold products
        return redirect()->back()->with('success', 'Order Moved to Feedback');
    }

    
    // submit the review 
    public function submitReview(Request $request) {
        // validate the inputs 
        $validated = $request->validate([
            "userId" => 'required|integer|exists:customers,id',
            "productId" => 'required',
            "starCountAll" => 'required|integer',
            "starCountQuality" => 'required|integer',
            "starCountService" => 'required|integer',
            "image_path" => 'required',
            "description" => 'required',
            "price" => 'required|integer',
            "quantity" => 'required|integer',
            "image" => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);
        $filename = ""; 
        if(!empty($validated['image'])){
            $filename = $validated['image']->getClientOriginalName();
            $validated['image']->storeAs('public/images', $filename); 
        }


        
        // insert into feedback table 
        // insert to table products all the after reviewing 
        $storeToProducts = Products::create([
            'userId' => $validated['userId'],
            'productId' => $validated['productId'],
            'image_path' => $validated['image_path'],
            'description' => $validated['description'],
            'price' => $validated['price'],
            'quantity' => $validated['quantity']
        ]);
        $storeToProducts->save();
        $productId = $storeToProducts->id; 
        feedback::create([
            "userId" => $validated['userId'],
            "productId" => $productId,
            "starCountAll" => $validated['starCountAll'],
            "starCountQuality" => $validated['starCountQuality'],
            "starCountService" => $validated['starCountService'],
            "specify" => $request->specify,
            "featured" => 1,
            "image" => $filename,
        ]);

        

        // remove from orders 
        $deleteFromOrders = orders::where('productId', $request->productId);
        $deleteFromOrders->delete();
        // remove from processing 
        $producToDelete = Processing::findOrFail($request->productId);
        $producToDelete->delete();
        return redirect()->back()->with('Success', 'Thank you for your feedback');
    }
    
}
