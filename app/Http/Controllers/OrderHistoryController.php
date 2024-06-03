<?php

namespace App\Http\Controllers;
use App\Models\orders;
use Illuminate\Http\Request;

class OrderHistoryController extends Controller
{
    public function showOrderList() {
        $data = orders::paginate('20');
        return view('admin.orders', compact('data'));
    }

    public function filterOrders(Request $request) {
        $searchInput = $request->input('searchOrders'); 
        $result = orders::query(); 
        if($searchInput) {
            $result = $result->where(function($query) use ($searchInput){
                        $query->where('address', 'LIKE', "%{$searchInput}%")
                                ->orWhere('productId', 'LIKE', "%{$searchInput}%")
                                ->orWhere('contact', 'LIKE', "%{$searchInput}%")
                                ->orwhere('id', 'LIKE', "%{$searchInput}%")
                                ->orWhere('userId', 'LIKE', "%{$searchInput}%");
                                
            });
        }
        $data = $result->get();
        return view('admin.orderSearchResult', compact('data'));
    }

    public function sortOrders(Request $request) {
        $sortBy = $request->input('sortBy');
        $orderBy = $request->input('orderBy');

        $result = orders::query();
        $result->orderBy($sortBy, $orderBy);
        $data = $result->get();

        return view('admin.orderSearchResult', compact('data'));
    }
    public function filterDate(Request $request) {
        $startDate = $request->input('startDate');
        $endDate = $request->input('endDate');

        $filter = orders::query();

        
            $filter->whereBetween('created_at', [$startDate, $endDate]);
        

        $data = $filter->get();

        return view('admin.orderSearchResult', compact('data'));
    }
}
