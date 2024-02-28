<?php

namespace App\Http\Controllers;

    
use Illuminate\Http\Request;
use App\Models\Products;
use App\Models\Variations;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\Onhand;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Route;

class adminProductsController extends Controller
{
    // function for onhand tab in admin panel 

    public function storeOnhand(Request $request)
    {
        $validated = $request->validate([
            // To lessen the errors we should practice naming the inputs fields similar to the model 
            "status" => "required",
            "gender" => "required",
            "variation_id" => "required",
            "size" => "required",
            "description" => "required",
            "price" => "required",
            "quantity" => "required",
            "productStatus" => "required",
        ]);

        $storeOnHand = Products::create($validated);
        
        return redirect()->to('products/onHand');        
    }



    public function onHand(){
        $onHandProducts = Products::where('status', '=', 1)->get();
        return view('admin.products.onHand', compact('onHandProducts'));
    }

  
    


    // 

    public function proccessing(){
        $onProcessProducts = Products::where('status', '=', 2)->get();

        return view('admin.products.proccessing', compact('onProcessProducts'));
    }


    public function finished(){
        $finishedProducts = Products::where('status', '=', 3)->get();

        return view('admin.products.finished', compact('finishedProducts'));
    }

   
}
