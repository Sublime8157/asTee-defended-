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


class adminOnHandsController extends Controller
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

    // Function for filtering products in on hand 
    public function filterOnHandProducts(Request $request) {
        $storeOnHand = OnHand::query();
        
        if($request->filled(['variation_id'])) {
            $storeOnHand->where('variation_id', $request->input('variation_id'));
        }

        if($request->filled(['gender'])) {
            $storeOnHand->where('gender', $request->input('gender'));
        }

        if($request->filled(['size'])) {
            $storeOnHand->where('size', $request->input('size'));
        }

        if($request->filled(['id'])) {
            $storeOnHand->where('id', $request->input('id'));
        }

        if($request->filled(['price'])) {
            $storeOnHand->where('price', $request->input('price'));
        }
        $filterOnHand = $storeOnHand->get();
        return view('admin.products.onHandPartial', ['filterOnHand' => $filterOnHand])->render();
    }

    public function onHand(){
        // display all the data from the on_hand table store in variable storehand and use it to the blade 
        $filterOnHand = OnHand::all();


        return view('admin.products.onHand', compact('filterOnHand'));
    }



    public function removeProduct($id) {
        $product = OnHand::findOrFail($id); 
        $product->delete();
  
        
  
        return redirect()->back()->with('removedSucess', 'Product Successfuly Removed');
     }

     public function editProduct(Request $request, $id){

        $request->validate([
            "variation_id" => "required",
            "gender" => "required",
            "size" => "required",
            "description" => "required|nullable",
            "price" => "required|numeric",
            "quantity" => "required|numeric",
           
        ]);

        $product = OnHand::findOrFail($id);

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
