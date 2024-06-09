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
use App\Models\cart;


class adminOnHandsController extends Controller
{
    public function storeOnhand(Request $request)
    {
        // validate the user input 
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
        // check if value is present
        
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

    // display all the data from the on_hand table, store in variable storehand and use it to the blade 
    public function onHand(){
        OnHand::where('quantity', 0)->delete();
        $filterOnHand = OnHand::paginate(20);
        return view('admin.products.onHand', compact('filterOnHand'));
    }


    // remove a product function 
    public function removeProduct($id) {
        $product = OnHand::findOrFail($id); 
        $product->delete();
        // redirect bnack with a string access by calling the removedSuccess in session
        return redirect()->back()->with('removedSucess', 'Product Successfuly Removed');
     }


    //  edit product function 
     public function editProduct(Request $request, $id){
        // validate the user inputs before editing 
        $request->validate([
            "variation_id" => "required",
            "gender" => "required",
            "size" => "required",
            "description" => "required|nullable",
            "price" => "required|numeric",
            "quantity" => "required|numeric",
        ]);
        // find the product id in onhand table 
        $product = OnHand::findOrFail($id);
        // update the product 
        $product->update([
            "variation_id" => $request->variation_id,
            "gender" =>  $request->gender,
            "size" =>  $request->size,
            "description" => $request->description,
            "price" => $request->price,
            "quantity" => $request->quantity,
            
        ]);
        // redirect back 
        return redirect()->back()->with('updatingSuccess', 'Updating Successfull');
     }

    //  move a product to another table 
    public function moveProduct(Request $request, $id)
     {
        // find the product id in onhan table 
        $product = OnHand::findOrFail($id);
        // get the move option value 
        $moveTo = $request->input('moveProduct');
        // check the moveTo to input value
        $validated = $request->validate([
            'userId' => 'required|numeric|exists:customers,id',
        ]);
        switch($moveTo) {
            case 1: 
                $total = $product->price * $product->quantity;
                  // move to processing table 
                Processing::create([
                    'userId' => $validated['userId'],
                    'status' => $product->status,
                    'image_path' => $product->image_path,
                    'gender' => $product->gender,
                    'variation_id' => $product->variation_id,
                    'size' => $product->size,
                    'description' => $product->description,
                    'price' => $product->price,
                    'quantity' => $product->quantity,
                    'productStatus' => 1,
                    'total' => $total
                ]);
                // delete from the onhand table 
                $product->delete();
                // redirect to the cancel return tab 
                return redirect()->back()->with('moveSuccess', 'Product Successfully moved to processing table');

            case 2:
                // validate the id must be numeric 
             
                // move to cancel return table
                $total = $product->price * $product->quantity;

                  CancelReturn::create([
                    'userId' => $validated['userId'],
                    'image_path' => $product->image_path,
                    'variation_id' => $product->variation_id,
                    'description' => $product->description,
                    'reason' => $request['reason'],
                     'gender' => $product->gender,  
                     'size' => $product->size,
                     'price' => $product->price,
                    'quantity' => $product->quantity,
                    'total' => $total
                ]);
                // delete from the onhand table 
                $product->delete();
                // redirect to the cancel return tab 
                return redirect()->back()->with('moveSuccess', 'Successfully moved to cancel return table ');
            // redirect back if no selected value 
            default: 
                return redirect()->back();
        }   
    }

    // move multiple products 
    public function moveMultiple(Request $request) {
        $productToMove = explode(',',$request->toMove);
        $productToMove = array_map('trim',$productToMove);
        $productToMove = array_map('intVal',$productToMove);
        $productMoveTo = $request->moveTo; 
        $userId = $request->userId;
        $validated = $request->validate([
            'userId' =>  "required|exists:Customers,id"
        ]);
        // always check if the array is empty 
        if($productToMove != 0 ) {
            switch($productMoveTo) {
                // move to processing table 
                case 1: 
                        foreach($productToMove as $product) {
                            $onHandProduct = OnHand::where('id', $product)->first(); 
                            Processing::create([
                                'image_path' => $onHandProduct['image_path'],
                                'userId' => $validated['userId'],
                                'variation_id'=> $onHandProduct['variation_id'],
                                'description' =>  $onHandProduct['description'],
                                'gender' =>  $onHandProduct['gender'],
                                'size' =>  $onHandProduct['size'],
                                'price' =>  $onHandProduct['price'],
                                'productStatus' =>1,
                                'quantity' =>  $onHandProduct['quantity'],
                                'total' => $onHandProduct['price']
                            ]);
                            $onHandProduct->delete();
                        }
                        return redirect()->back()->with(['success' => 'Moved to Processing Successfully']);
                    break;
                // move to cancel return table 
                case 2: 
                        foreach($productToMove as $product) {
                            $onHandProduct = OnHand::where('id', $product)->first(); 
                            Processing::create([
                                'image_path' => $onHandProduct->image_path,
                                'userId' => $validated['userId'],
                                'variation_id'=> $onHandProduct['variation_id'],
                                'description' =>  $onHandProduct['description'],
                                'gender' =>  $onHandProduct['gender'],
                                'size' =>  $onHandProduct['size'],
                                'price' =>  $onHandProduct['price'],
                                'productStatus' =>1,
                                'quantity' =>  $onHandProduct['quantity'],
                                'total' => $onHandProduct['price']
                            ]);
                            $onHandProduct->delete();
                        }
                    return redirect()->back()->with(['success' => 'Moved to Cancel Successfully']);
                    break;
                default:
                    return redirect()->back()->with(['fail' => 'No Selected Table']);
                    break;
            }
    }
        else {
            return redirect()->back()->with(['fail' => 'No Selected Item']);
        }
            
    }
    // sort products 
    public function sortProducts(Request $request) {
        $sortProducts = $request->input('sortProductBy');
        $orderBy = $request->input('orderProductBy');

        $productData = OnHand::query();
        $productData->orderBy($sortProducts, $orderBy);

        $productData = $productData->paginate(10);
        return view('admin.products.sort.onhandProducts', compact('productData'));
    }

    // delete all using checkbox 
    public function removeAllProduct(Request $request) {
        if($request->toRemove != 0){
            $idToDelete = explode(',', $request->toRemove); // separate using , 
            $idToDelete = array_map('trim', $idToDelete); // remove white spaces 
            $idToDelete = array_map('intVal', $idToDelete); // convert to int 
            // delete first from cart as the cart reference this 
            $deletFromCart = Cart::whereIn('productId', $idToDelete);
            $deletFromCart->delete();
            // and then delete from the onhand  table 
            $listToDelete = OnHand::whereIn('id', $idToDelete); // find all from OnHand table 
            $listToDelete->delete(); // delete 
        }
        else {
            return redirect()->back()->with(['fail' => 'No Selected Item']);
        }
       return redirect()->back()->with(['success' => 'Successfully Deleted']);
    }
}
