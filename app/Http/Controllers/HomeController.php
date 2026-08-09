<?php

namespace App\Http\Controllers;

use App\Models\Review;

class HomeController extends Controller
{
    public function index()
    {
        // Was a three-table raw join keyed on `feedback.productId`, which
        // pointed at the throwaway row submitReview inserted rather than at the
        // reviewed purchase.
        $reviews = Review::featured()
            ->with(['user', 'orderItem'])
            ->latest()
            ->take(3)
            ->get();

        return view('user.homepage', compact('reviews'));
    }
}
