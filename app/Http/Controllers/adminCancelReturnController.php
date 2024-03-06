<?php

namespace App\Http\Controllers;

    
use Illuminate\Http\Request;
use App\Models\Products;
use App\Models\Variations;
use Illuminate\Support\Facades\Validator;
use App\Models\Use;
use App\Models\CancelReturn;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Route;

class adminCancelReturnController extends Controller
{
    


    // cancel/return products here 
    public function storeCancelReturn(Request $request) {
        $validated = $request->validate([
            // To lessen the errors we should practice naming the inputs fields similar to the model 
            // Validate te user input 
            "status" => "required",
            "gender" => "required",
            "userId" => "required|numeric",
            "variation_id" => "required",
            "size" => "required",
            "description" => "required",
            "reason" => "required",
            "price" => "required|numeric",
            "quantity" => "required|numeric",
            "productStatus" => "required",
            "image_path" => "required|image|mimes:jpeg,png,jpg,gif,svg|max:2048",
        ]);
        // Insert the image file name in database and store the actual image in public/storage/images       
        $imageName = $request->file('image_path')->getClientOriginalName();
        $request->file('image_path')->storeAs('public/images', $imageName);
        $validated['image_path'] =  $imageName;

        // insert the data in products table 
        Products::create([
            'status' => $validated['status'],
            'gender' => $validated['gender'],
            'variation_id' => $validated['variation_id'],
            'size' => $validated['size'],
            'description' => $validated['description'],
            'price' => $validated['price'],
            'quantity' => $validated['quantity'],
            'productStatus' => $validated['productStatus'],
            'image_path' => $validated['image_path'],
        ]);

        // insert the data in on_process_product table 
        $storeCancelReturn = CancelReturn::create([
            'userId' => $validated['userId'],
            'image_path' => $validated['image_path'],   
            'variation_id' => $validated['variation_id'],
            'description' => $validated['description'],
            'reason' => $validated['reason'],
            'gender' => $validated['gender'],            
            'size' => $validated['size'],           
            'price' => $validated['price'],
            'quantity' => $validated['quantity'],
           
        ]);
        
        return redirect()->to('/products/cancelReturn');       


    }

    public function filterCancelReturn(Request $request) {
        $productReturnCancel = CancelReturn::query();
        
        if($request->filled(['variation_id'])) {
            $productReturnCancel->where('variation_id', $request->input('variation_id'));
        }

        if($request->filled(['gender'])) {
            $productReturnCancel->where('gender', $request->input('gender'));
        }

        if($request->filled(['size'])) {
            $productReturnCancel->where('size', $request->input('size'));
        }

        if($request->filled(['id'])) {
            $productReturnCancel->where('id', $request->input('id'));
        }

        if($request->filled(['price'])) {
            $productReturnCancel->where('price', $request->input('price'));
        }
        $filterReturnCancel = $productReturnCancel->get();
        return view('admin.products.CancelReturnPartial', ['filterReturnCancel' => $filterReturnCancel])->render();


    }
    public function cancel_return(){
        $filterReturnCancel = CancelReturn::all();
        return view('admin.products.cancelReturn', compact('filterReturnCancel'));
    }
    // controller for filter products 


    public function removeProduct($id) {
        $product = CancelReturn::findOrFail($id);
        $product->delete();


        return redirect()->back()->with('removeSucess', 'You successfully remove the product');
    
    }
    
}
