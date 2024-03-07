<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Products;
use App\Models\Processing;
use App\Models\Variations;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Route;


class adminOnProcessController extends Controller
{
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

    // function for fitlering products 

    public function filterProcessing(Request $request) {
        $processingData = Processing::query();
        
        if($request->filled(['variation_id'])) {
            $processingData->where('variation_id', $request->input('variation_id'));
        }

        if($request->filled(['gender'])) {
            $processingData->where('gender', $request->input('gender'));
        }

        if($request->filled(['size'])) {
            $processingData->where('size', $request->input('size'));
        }

        if($request->filled(['id'])) {
            $processingData->where('id', $request->input('id'));
        }

        if($request->filled(['price'])) {
            $processingData->where('price', $request->input('price'));
        }

        if($request->filled(['productStatus'])) {
            $processingData->where('productStatus', $request->input('productStatus'));
        }
        $filterOnProcess = $processingData->get();
        return view('admin.products.processingPartial', ['filterOnProcess' => $filterOnProcess])->render();
    }


    // Show to the processing url with the storeProcess data that holds the data from the on_process table 
    public function proccessing(){
        $filterOnProcess = Processing::all();
        return view('admin.products.proccessing', compact('filterOnProcess'));
    }

    public function removeProduct($id) {
        $product = Processing::findOrFail($id); 
        $product->delete();
  
        
  
        return redirect()->back()->with('removedSucess', 'Product Successfuly Removed');
     }

     

     public function editProcessingProduct(Request $request, $id){

        $request->validate([
            "variation_id" => "required",
            "gender" => "required",
            "size" => "required",
            "description" => "required|nullable",
            "price" => "required|numeric",
            "quantity" => "required|numeric",
           
        ]);

        $product = Processing::findOrFail($id);

        $product->update([
            "variation_id" => $request->variation_id,
            "gender" =>  $request->gender,
            "size" =>  $request->size,
            "description" => $request->description,
            "price" => $request->price,
            "quantity" => $request->quantity,
            
        ]);

        
        
        return redirect()->back()->with('updatingSuccess', 'Updating Successfull');
     }
}
