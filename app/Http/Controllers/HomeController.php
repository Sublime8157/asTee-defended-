<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\feedback;
use Illuminate\Support\Facades\DB;
class HomeController extends Controller

{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
            $feedback  = DB::table('customers')
            ->join('feedback','customers.id','=','feedback.userId')
            ->join('products','products.Id','=','feedback.productId')
            ->select('feedback.*','customers.username','customers.profile','products.image_path','products.price','products.quantity')
            ->where('featured',2)
            ->latest('created_at')
            ->take(3)
            ->get();

        return view('user.homepage', compact('feedback'));
    }
}
