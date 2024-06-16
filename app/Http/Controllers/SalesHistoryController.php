<?php

namespace App\Http\Controllers;
use App\Models\Sales; 
use Illuminate\Http\Request;

class SalesHistoryController extends Controller
{
    public function display(Request $request) {
        $data = Sales::paginate('20'); 


        return view('admin.sales', compact('data'));
    }
}
