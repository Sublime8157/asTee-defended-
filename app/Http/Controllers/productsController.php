<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Products;
use App\Models\Variations;

class productsController extends Controller
{
 

   public function displayOnHandsProducts(){
         // Create a variable that holds the products model with variation, gender and size table 
        $data = Products::all();  
         
        return view('user.Product', compact('data'));
   }
}
