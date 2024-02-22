<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class adminProductsController extends Controller
{
    public function onHand(){
        return view('admin.products.onHand');
    }
    public function proccessing(){
        return view('admin.products.proccessing');
    }
    public function finished(){
        return view('admin.products.finished');
    }
}
