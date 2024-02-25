<?php

namespace App\Http\Controllers;

    
use Illuminate\Http\Request;
use App\Models\Products;
use App\Models\Variations;

class adminProductsController extends Controller
{
    public function onHand(){
        $onHandProducts = Products::where('status', '=', 1)->get();

        return view('admin.products.onHand', compact('onHandProducts'));
    }


    public function proccessing(){
        $onProcessProducts = Products::where('status', '=', 2)->get();

        return view('admin.products.proccessing', compact('onProcessProducts'));
    }


    public function finished(){
        $finishedProducts = Products::where('status', '=', 3)->get();

        return view('admin.products.finished', compact('finishedProducts'));
    }

   
}
