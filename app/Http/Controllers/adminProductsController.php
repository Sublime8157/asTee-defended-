<?php

namespace App\Http\Controllers;

    
use Illuminate\Http\Request;
use App\Models\Products;
use App\Models\OnHand;
use App\Models\Processing;
use App\Models\Variations;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\CancelReturn;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Route;


class adminProductsController extends Controller
{
    // function for onhand tab in admin panel 

    public function storeOnhand(Request $request)
    {
        $validated = $request->validate([
            // To lessen the errors we should practice naming the inputs fields similar to the model 
            // Validate the user input 
            "status" => "required",
            "gender" => "required",
            "variation_id" => "required",
            "size" => "required",
            "description" => "required",
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
        // insert the data in on_hand_product table 
        $storeOnHand = OnHand::create([
            'image_path' => $validated['image_path'],
            'variation_id' => $validated['variation_id'],
            'description' => $validated['description'],
            'gender' => $validated['gender'],            
            'size' => $validated['size'],           
            'price' => $validated['price'],
            'quantity' => $validated['quantity'],
           
        ]);
        // Redirect to products/onHand url when success 
        return redirect()->to('products/onHand');        
    }
    public function onHand(){
        // display all the data from the on_hand table store in variable storehand and use it to the blade 
        $storeOnHand = OnHand::all();
        return view('admin.products.onHand', compact('storeOnHand'));
    }


    // controller for inserting data into prodcut processing 
    public function storeProcessing(Request $request) {
        $validated = $request->validate([
            // To lessen the errors we should practice naming the inputs fields similar to the model 
            // Validate te user input 
            "status" => "required",
            "gender" => "required",
            "variation_id" => "required",
            "size" => "required",
            "description" => "required",
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
        $storeProcess = Processing::create([
            'image_path' => $validated['image_path'],
            'variation_id' => $validated['variation_id'],
            'description' => $validated['description'],
            'gender' => $validated['gender'],            
            'size' => $validated['size'],           
            'productStatus' => $validated['productStatus'],
            'price' => $validated['price'],
            'quantity' => $validated['quantity'],
           
        ]);
        // 
        return redirect()->to('/products/proccessing');        
    }
    // Show to the processing url with the storeProcess data that holds the data from the on_process table 
    public function proccessing(){
        $storeProcess = Processing::all();
        return view('admin.products.proccessing', compact('storeProcess'));
    }


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
    public function cancel_return(){
        $cancelReturnProducts = CancelReturn::all();
        return view('admin.products.cancelReturn', compact('cancelReturnProducts'));
    }

   
}
