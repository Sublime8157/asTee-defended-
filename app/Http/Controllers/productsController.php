<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\OnHand;
use App\Models\Variations;
use Illuminate\Support\Str;


class productsController extends Controller
{
 

   public function filterProducts(Request $request){
      // Create a variable that holds the products model with variation, gender, and size table 
      $data = OnHand::query();
      
      if($request->filled('variation_id')) {
          $data->where('variation_id', $request->input('variation_id'));
      }
  
      if($request->filled('size')) {
          $data->where('size', $request->input('size'));
      }
  
      if($request->filled('gender')) {
          $data->where('gender', $request->input('gender'));
      }
      
      $filteredData = $data->get();
  
      // Truncate description for each product
      foreach ($filteredData as $product) {
          $product->displayDescription = Str::words($product->description, 10);
      }
  
      return view('user.productResult', ['filteredData' => $filteredData]);
  }
//   display on hands product
   public function displayOnHandsProducts(){
    // get the  session username and id   
        $user = [
            'username' =>  session('username'),
            'id' => session('id'),
        ];
         $data = OnHand::all();  
        
         foreach($data as $product) {
            $product->displayDescription = Str::words($product->description, 10);
         }
         
        return view('user.Product', compact('data','user'));
   }
   
   public function details(Request $request, $id) {
        $user = [
            'id' => session('id'),
        ];
      $product = OnHand::findorFail($id);

      $productDetails = OnHand::where('id', '=', $id);
      
      $productDet = $productDetails->get();
      return view('user.productDetails', compact('productDet', 'user'));
   }

   
   
}
