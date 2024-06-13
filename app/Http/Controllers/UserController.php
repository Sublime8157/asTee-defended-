<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\OnHand;
use App\Models\Sales;
use App\Models\cart;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use App\Models\feedback;
use App\Models\customers;
use App\Models\Processing;
use App\Models\orders;
use Illuminate\Support\Facades\Mail;
use App\Mail\InvoicePaymentMail;
use App\Mail\NewOrderMadeMail;
class UserController extends Controller
{
    // Function for showing the homepage
    public function home(){
       $feedback  = DB::table('customers')
                   ->join('feedback','customers.id','=','feedback.userId')
                   ->join('products','products.Id','=','feedback.productId')
                   ->select('feedback.*','customers.username','customers.profile','products.image_path','products.price','products.quantity')
                   ->where('featured',2)
                   ->latest('created_at')
                   ->take(3)
                   ->get();

       return view('user.homepage', dd($feedback));
    }
    // Function for about us UI
    public function about_us() {
        return view('user.about_us');
    }
    // Show the product tab 
   
    // Show the DIY tab 
    public function DIY() {
        return view('user.DIY');
    }

    //  If the user logged in show the users profile and retrieve its data as an array and assign to user variable, 
    // you can then get the data by calling the user variable and the table name ex: $user->colum name
    // redirect to the homepage when not  logged in 
    public function userProfile() {
       if(Auth::check()) {
            $user = Auth::user(); 
            return view('user.userProfile.myaccount', ['user' => $user]);
       }
       else {
            return redirect()->to('\home');
       }
    }

    public function userPurchase() {
        return view('user.userProfile.myPurchase');
     }
     public function userPassword() {
        return view('user.userProfile.myPassword');
     }




     // store added product 
    public function store(Request $request) {
        // validate the user and product id 
        $validate = $request->validate([
            "userId" => 'required|exists:customers,id',
            "prodId" => 'required|exists:product_on_hand,id',
        ]);
        // check if it was already in the cart 
        $cartItem = cart::where('userId', '=', $validate['userId'])->
                            where('productId', '=', $validate['prodId'])->count();
        // if it not yet in the cart add
        if($cartItem <= 0 ) {
            $cart = cart::create([
                'userId' =>$validate['userId'],
                'productId' =>$validate['prodId'],
                'quantity' => 1
            ]);
        }
        // return back
        else {
            return redirect()->back()->with(['success' => 'Item was already in the cart']);
        }
        return redirect()->back()->with(['success' => 'Added to cart']);
    }


    // display the user added to cart
    public function cart($userId) {
        // find the user id from cart assign to userCart
        $userCart = cart::where('userId', $userId)->get();
        $products = [];
        $prodQty = [];

        // assign to cartItem all the userCart result
        foreach($userCart as $cartItem) {
            // find the productId column of Cart from OnHand  
            $product = OnHand::find($cartItem->productId);       
            $quantity = OnHand::where('id', $cartItem->productId)
                                ->value('quantity');
            $prodQty[$cartItem->productId] = $quantity;

            if($product){             
                // store to products array 
                $products[] = $product;   
            }
        }
     return view('user.userCart', compact('userCart','products','prodQty','userId'));
    }
    
    // remove a list of items  
    public function removeAll(Request $request) {
        $items = explode(',', $request->toRemove); // convert the strings into array recieved from toRemove input field
        $items = array_map('trim', $items); // Remove whitespace from each element
        $items = array_map('intval', $items); // Convert each element to an integer
       
        $listOfItems = cart::whereIn('productId', $items); // use whereIn to remove a set of an array 
        $deleted = $listOfItems->delete();
        // Log the number of deleted items to verify the deletion
    
        return redirect()->back();
    }
    // remove single item 
    public function remove($id) {
        $removeItem = cart::where('productId', $id);
        $removeItem->delete();

        return redirect()->back();
    }

    public function checkout(Request $request) {
        $data = $request->all();
    
        // Decode the JSON string into an array of objects
        $quantities = json_decode($data['quantity'], true);
        
        // get the items name from request expecting an array from it 
        $prodIdString = $data['items'];
        // separe the value using , 
        $prodId = explode(',', $prodIdString);
        $products = [];
        // iterate to each of the result from array 
        foreach($prodId as $prodItem) {
            // retrieve each of its data from OnHand
            $product = OnHand::find($prodItem);
            // if it is not empty 
            if($product) {
                // assign the value retrieve to array 
                $products[] = $product;
            }
        }
        $userInfo = User::find($data['userId']);
        if(count($products) <= 0) {
            return redirect()->back()->with(['error' => 'No selected product']);
        }   
        foreach($products as $prod) {
                $prod->displayDescription = Str::words($prod->description, 10);
        }
        return view('user.checkout', ["products" => $products, 
                                        "data" => $data, 
                                        "quantities" => $quantities,
                                        "userInfo" => $userInfo]);
    }
    
    public function confirmCheckout(Request $request) {
        $prodToInsert = $request->productId; //get the productId from request expecting a list 
        $validated = $request->validate([ // validate
            'address' => 'required',
            'contact' => 'required|min:10',
            'userId' => 'required|exists:customers,id',
            'description.*' => 'required', // use .* if you are expecting a list or an array 
            'variation_id.*' => 'required',
            'email' => 'required',
            'gender.*' => 'required',
            'size.*' => 'required',
            'price.*' => 'required|numeric',
            'quantity.*' => 'required|numeric',
            'subTotal' => 'required|numeric',
            'image_path.*' => 'required',
        ]);
        if(count($prodToInsert) != 0) { // count the result if it  was not 0 process
            foreach($validated['price'] as $index => $price){ // iterate through the array so we can insert each user selected 
                $price = (float)$price; // convert to float so the program will treat it as a number from a text 
                $quantity = (int)$validated['quantity'][$index]; // same on int 
                $total =  $price * $quantity; // compute 
                $processing = Processing::create([ //insert to process 
                    'image_path' => $request->image_path[$index], // get the index on each of the result of the index 
                    'userId' => $validated['userId'],
                    'variation_id' => $validated['variation_id'][$index],
                    'description' => $validated['description'][$index],
                    'gender'=> $validated['gender'][$index],
                    'size' => $validated['size'][$index],
                    'price'=> (float)$validated['price'][$index],
                    'productStatus' => 1,
                    'quantity' => $quantity,
                    'total' => $total 
                ]);
                
                // remove from the cart 
                $removeToCart = cart::whereIn('productId',$prodToInsert)->get();
                $removeToCart->each->delete();
                // remove from the onhand this should remove only the quantity if it was equals to 0 then continue removing 
                $qtyCount = OnHand::where('id', $prodToInsert[$index])->first(); // get the first result from onhand 
                if ($qtyCount && $qtyCount->quantity >= $quantity) { // if count and count from querie greater than or equal to the quantity in request 
                    OnHand::where('id', $prodToInsert[$index])->decrement('quantity', $quantity);  // decrement its qty 
                }
                else if($qtyCount && $qtyCount->quantity <= 1 ) { //if it was the last item remove from onhand after submitting 
                    OnHand::where('id',$prodToInsert[$index])->delete();
                }
                else {
                    // Handle the case where the quantity is not enough
                    return redirect()->route('checkout.process')->with('error', 'Insufficient quantity for product ' . $productId);
                }   
               
                $processingId[] = $processing->id;
                // Sales::create([
                //     'productId' => $processing->id,
                //     'userId' => $validated['userId'],
                //     "amount" => $total,
                //     'quantity' => 1
                // ]);

                $orders = orders::create([
                    'userId' => $validated['userId'],
                    'productId' => json_encode($processingId),
                    'address' => $validated['address'],
                    'contact' => $validated['contact'],
                    'mop' => $request->mop
                ]);
            }
          
           
        }
      
        $orderId = $orders->id;
        $invoiceData = [
            "userId" => $validated['userId'],
            "orderNo" => $orderId,
            "address" => $validated['address'],
            "contact" => $validated['contact'],
            "processing" =>  json_encode($processingId),
            "mop" => $request->mop,
            "total" =>   $request->total,
            "orderDate" => now()->format('Y-m-d')
        ];
        // email to the user his/her order 
        Mail::to($validated['email'])->send(new InvoicePaymentMail($invoiceData));
        // send email to admin that new order has been made 
        Mail::to('astee_orders@astee.store')->send(new NewOrderMadeMail($invoiceData));

        return redirect()->route('myPurchase',['userId' => $request->userId])->with('Success','Order has been made successfully, an order invoice has been sent to you emal please check your inbox or spam. Thank you!');
    }

   
}
    

