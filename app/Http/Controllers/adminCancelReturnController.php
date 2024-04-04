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
use App\Models\OnHand;
use App\Models\Processing;

class adminCancelReturnController extends Controller
{
    // cancel/return products here 
    public function storeCancelReturn(Request $request) {
    // Validate te user input 
        $validated = $request->validate([
            // To lessen the errors we should practice naming the inputs fields similar to the model 
            "status" => "required",
            "gender" => "required",
            "userId" => "required|numeric|exists:customers,id",
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
        

        // insert the data in on_process_product table 
        $storeCancelReturn = CancelReturn::create([
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
           
        ]);
        // reditect back to cancel return
        return redirect()->to('/products/cancelReturn');      
    }

    // filter all the product
    public function filterCancelReturn(Request $request) {
        $productReturnCancel = CancelReturn::query();
        
        if($request->filled(['variation_id'])) {
            $productReturnCancel->where('variation_id', $request->input('variation_id'));
        }
        if($request->filled(['userId'])) {
            $productReturnCancel->where('userId', $request->input('userId'));
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

    // show all of the product in cancel return 
    public function cancel_return(){
        $filterReturnCancel = CancelReturn::paginate(10);
        return view('admin.products.cancelReturn', compact('filterReturnCancel'));
    }
    
    // remove a product 
    public function removeProduct($id) {
        $product = CancelReturn::findOrFail($id);
        $product->delete();
        // redirect back with removeSuccess
        return redirect()->back()->with('removeSucess', 'You successfully remove the product');
    }

    // edit a product 
    public function editCancelReturn(Request $request, $id){
        // validate the user input
        $request->validate([
            "variation_id" => "required",
            "gender" => "required",
            "size" => "required",
            "description" => "required|nullable",
            "price" => "required|numeric",
            "quantity" => "required|numeric",
           
        ]);
        // find the product
        $product = CancelReturn::findOrFail($id);
        // update the product
        $product->update([
            "variation_id" => $request->variation_id,
            "gender" =>  $request->gender,
            "size" =>  $request->size,
            "description" => $request->description,
            "price" => $request->price,
            "quantity" => $request->quantity,
            
        ]);
        // redirect back with a message that is accessible using the updatingSuccess
        return redirect()->back()->with('updatingSuccess', 'Updating Successfull');
     }

    //  move a product
     public function moveProduct(Request $request, $id) {
        // find the product id 
        $product = CancelReturn::findOrFail($id);
        // get the move option value 
        $moveTo = $request->input('moveProduct');
        // check the move to input 
        switch($moveTo) {
            // if option 1 is selected 
            case 1: 
                  // move to processing table 
                OnHand::create([
                    'image_path' => $product->image_path,
                    'status' => $product->status,
                    'gender' => $product->gender,
                    'variation_id' => $product->variation_id,
                    'size' => $product->size,
                    'description' => $product->description,
                    'price' => $product->price,
                    'quantity' => $product->quantity,
                ]);
                // delete from the onhand table 
                $product->delete();
                // redirect to the cancel return tab 
                return redirect()->back()->with('moveSuccess', 'Product Successfully moved to On Hand table');
            
            // if option 2 is selected 
            case 2:
                // move to cancel return table
                Processing::create([
                    'image_path' => $product->image_path,
                    'status' => $product->status,
                    'gender' => $product->gender,
                    'variation_id' => $product->variation_id,
                    'size' => $product->size,
                    'description' => $product->description,
                    'price' => $product->price,
                    'quantity' => $product->quantity,
                    'productStatus' => 1,
                ]);
                // delete from the processing table 
                $product->delete();
                // redirect to the cancel return tab 
                return redirect()->back()->with('moveSuccess', 'Product Successfully moved to processing table');
            // redirect back when no option selected
            default: 
                return redirect()->back();
        }
    }

    public function sortProduct(Request $request) {
        $sortProductBy = $request->input('sortProductBy');
        $orderProductBy = $request->input('orderProductBy');

        $productData = CancelReturn::query();
        $productData->orderBy($sortProductBy, $orderProductBy);

        $productData = $productData->get();

        return view('admin.products.sort.sortProducts', compact('productData'));

    }
    
}
