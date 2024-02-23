<?php

namespace App\Http\Controllers;

    
use Illuminate\Http\Request;
use App\Models\Products;
use App\Models\Variations;

class adminProductsController extends Controller
{
    public function onHand(){
        $onHandProducts = Products::all();

        return view('admin.products.onHand', compact('onHandProducts'));
    }
    public function proccessing(){
        return view('admin.products.proccessing');
    }
    public function finished(){
        return view('admin.products.finished');
    }
}
