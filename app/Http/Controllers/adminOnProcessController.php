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


class adminOnProcessController extends Controller
{
    // controller for inserting data into prodcut processing 
    public function storeProcessing(Request $request)
     {
        // validate the user input 
        $validated = $request->validate([
            // To lessen the errors we should practice naming the inputs fields similar to the model 
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
        // redirect to processing tab 
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
    // remove a product
    public function removeProduct($id) {
        $product = Processing::findOrFail($id); 
        $product->delete(); 
        // redirect back with removedSuccess string 
        return redirect()->back()->with('removedSucess', 'Product Successfuly Removed');
     }

    //  edit a product info
     public function editProcessingProduct(Request $request, $id){
        // validate the before editing or updating 
        $request->validate([
            "variation_id" => "required",
            "gender" => "required",
            "size" => "required",
            "description" => "required|nullable",
            "price" => "required|numeric",
            "quantity" => "required|numeric",
        ]);
        // find the product id in processing table 
        $product = Processing::findOrFail($id);
        // update the product 
        $product->update([
            "variation_id" => $request->variation_id,
            "gender" =>  $request->gender,
            "size" =>  $request->size,
            "description" => $request->description,
            "price" => $request->price,
            "quantity" => $request->quantity,
        ]);
        // redirect back with updatingSuccess, access in session
        return redirect()->back()->with('updatingSuccess', 'Updating Successfull');
     }

    //  move a product to another product
     public function moveProduct(Request $request, $id) {
        // find the product id 
        $product = processing::findOrFail($id);
        // get the move option value 
        $moveTo = $request->input('moveProduct');
        // check the move to inpout value  
        switch($moveTo) {
            // if option 1 is selected...
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
                // validate the id must be numeric 
                $validated = $request->validate([
                    'userId' => 'required|numeric',
                ]);
                // move to cancel return table
                  CancelReturn::create([
                    'userId' => 1,
                    'image_path' => $product->image_path,
                    'variation_id' => $product->variation_id,
                      'description' => $product->description,
                    'reason' => $request['reason'],
                     'gender' => $product->gender,  
                     'size' => $product->size,
                     'price' => $product->price,
                    'quantity' => $product->quantity,
                   
                ]);
                // delete from the onhand table 
                $product->delete();
                // redirect to the cancel return tab 
                return redirect()->back()->with('moveSuccess', 'Successfully moved to return or cancel table');
            // redirect back when no option is  selected 
            default: 
                return redirect()->back();
        }
    }
    // sort the products 
    public function sortProduct(Request $request) {
        $sortProducts = $request->input('sortProductBy');
        $orderBy = $request->input('orderProductBy');

        $productData = Processing::query();

        $productData->orderBy($sortProducts, $orderBy);

        $productData = $productData->get();

        return view('admin.products.sort.sortProducts', compact('productData'));
    }

    public function updateStatus(Request $request, $id){
        $product = Processing::findOrFail($id);

        $product->update([
            'productStatus' => $request->productStatus
        ]);

        return redirect()->back();


    }
}
