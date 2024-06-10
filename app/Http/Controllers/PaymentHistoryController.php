<?php

namespace App\Http\Controllers;
use App\Models\payment_history; 
use App\Models\orders; 
use Illuminate\Http\Request;

class PaymentHistoryController extends Controller
{
    public function display() {
        $data = payment_history::paginate('20');

        return view('admin.payments', compact('data'));
    }

    public function store(Request $request) {
        $validated = $request->validate([
            'customers_id' => 'required|exists:customers,id|integer',
            'orders_id' => 'required|exists:orders,id|integer',
            'bank' => 'required',
            'amount' => 'required|integer',
            'proof' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);
        // update the order to paid 
        $orderID = orders::find($validated['orders_id']); 

        if($orderID->paid == 'paid') {
            return response()->json(['status' => 'fail', 'message' => 'The order number has already been paid']);
        }
        else{
            $orderID->update([
                'paid' => 'paid'
            ]); 
            // insert to payment history table 
            $filename = $validated['proof']->getClientOriginalName(); // get the actual file name 
            $request->file('proof')->storeAs('public/images', $filename);  // store to public/images 
            $validated['proof'] = $filename; 
            payment_history::create($validated);    
            return response()->json(['status' => 'success', 'message' => 'Successfully Inserted']); 
        }
    }

    public function sort(Request $request) {
        $sortBy = $request->input('sortBy'); 
        $orderBy = $request->input('orderBy'); 

        $result = payment_history::query(); 
        $result->orderBy($sortBy, $orderBy);
        
        $data = $result->get(); 
        return view('admin.results.paymentResult', compact('data'));   
    }

    public function filterDate(Request $request) {
        $startDate = $request->input('startDate');
        $endDate = $request->input('endDate');

       if(!empty($startDate) || !empty($endDate)) {
            $result = payment_history::query(); 
            $result->whereBetween('created_at', [$startDate, $endDate]);
            $data = $result->get(); 
       }
       else {
        $data = payment_history::paginate('20');
       }
       
        return view('admin.results.paymentResult', compact('data'));   
    }
    public function filterBanks(Request $request) {
        $bank = $request->input('bank'); 

        $result = payment_history::query(); 
        $result->where('bank', $bank);
        $data = $result->get(); 

        
        return view('admin.results.paymentResult', compact('data'));   
    }

    public function filterPrice(Request $request) {
        $min = $request->input('min');
        $max = $request->input('max');

        $result = payment_history::query(); 
        $result->whereBetween('amount', [$min, $max]); 
        $data = $result->get(); 


        return view('admin.results.paymentResult', compact('data')); 
    }
    public function searchById(Request $request) {
        $searchId = $request->input('searchBar'); 

        $result = payment_history::query(); 
        $result->where('id', 'LIKE', "%{$searchId}%")
                ->orwhere('orders_id', 'LIKE', "%{$searchId}%")
                ->orwhere('customers_id', 'LIKE', "%{$searchId}%"); 
        $data = $result->get(); 


        return view('admin.results.paymentResult', compact('data')); 

    }
}
