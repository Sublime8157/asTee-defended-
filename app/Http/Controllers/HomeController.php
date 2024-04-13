<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\feedback;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $feedback  = feedback::query()
                   ->selectRaw('customers.profile, customers.fname, DATE(feedback.created_at) as created_date, feedback.*')
                   ->join('customers','customers.id','=','feedback.userId')
                   ->where('featured',2)
                   ->latest('created_at')
                   ->take(3)
                   ->get();
       
        return view('user.homepage', compact('feedback'));
    }
}
