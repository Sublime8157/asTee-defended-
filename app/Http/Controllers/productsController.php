<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Products;
use App\Models\Variations;

class productsController extends Controller
{
 

   public function filterProducts(Request $request){
         // Create a variable that holds the products model with variation, gender and size table 
         $data = Products::query();

         if($request->filled(['variations'])) {
            $data->where('variation', $request->input('variations'));
         }

         if($request->filled(['sizes'])) {
            $data->where('size', $request->input('sizes'));
         }

         if($request->filled(['gender'])) {
            $data->where('gender', $request->input('gender'));
         }
   
         $filteredData = $data->get();
   
        

       
         return view('user.product', ['filteredData' => $filteredData]);

       
   }
   public function displayOnHandsProducts(){
         $filteredData = Products::all();  
         
        return view('user.Product', compact('filteredData'));
   }
}
