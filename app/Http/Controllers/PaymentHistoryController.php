<?php

namespace App\Http\Controllers;
use App\Models\payment_history; 
use App\Models\orders; 
use App\Models\Sales; 
use Illuminate\Http\Request;

class PaymentHistoryController extends Controller
{
    public function display() {
        $data = payment_history::paginate('20');
        $ordersId = orders::select('id')->where('paid','not_paid')->get(); 
        return view('admin.payments', compact('data','ordersId'));
    }

    public function refresh() {
        $data = payment_history::paginate('20');
        $ordersId = orders::select('id')->where('paid','not_paid')->get(); 
        return view('admin.results.paymentResult', compact('data','ordersId'));
    }
   

        
    public function store(Request $request) {
        $validated = $request->validate([
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
            Sales::create([
                'ordersId' => $validated['orders_id'],
                'amount' => $validated['amount'],
                'userId' => $request->userId
            ]);

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

        if(!empty($min)  || !empty($max)) {
            $result = payment_history::query(); 
            $result->whereBetween('amount', [$min, $max]); 
            $data = $result->get(); 
        }
        else {
            $data = payment_history::paginate('20');
        }
    
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
    public function removePaymentsRecords(Request $request) {
       if(!empty($request->toRemove)) {
            $toDelete = explode(',', $request->toRemove); 
            $toDelete = array_map('trim', $toDelete); 
            $toDelete = array_map('intVal', $toDelete); 

            $deletion = payment_history::whereIn('id', $toDelete)->get(); 
           

            $ordersId = $deletion->pluck('orders_id')->unique(); 
            $orderId = orders::whereIn('id', $ordersId)->get(); 

            foreach($orderId  as $orderedID){
                $orderedID->update([
                    'paid' => 'not_paid'
                ]);
                Sales::where('ordersId', $orderedID)->delete(); 
            }

            payment_history::whereIn('id', $toDelete)->delete(); 

            return redirect()->back()->with(['success' => 'Deletion Completed']); 
       }
        return redirect()->back()->with(['fail' => 'No Selected Item ']); 
    }

    public function removeRecord(Request $request) {
        $toDeleteRecord = $request->toDelete;

        $idToDelete = payment_history::where('id', $toDeleteRecord)->first();
        $orderID = $idToDelete->pluck('orders_id')->unique(); 
        $toUpdateOrder = orders::where('id', $orderID)->first(); 

        $toUpdateOrder->update([
            'paid' => 'not_paid'
        ]); 

        Sales::where('ordersId', $orderID)->delete(); 
        $idToDelete->delete();
        return redirect()->back()->with(['success' => 'Deletion Completed']); 
    }

    public function ordersIdAmount(Request $request) {
        $ordersId = $request->input('ids'); 
        $amount = []; 
        $amount = orders::select('total','userId')->where('id', $ordersId)->first(); 
        $amount = [
            'total' => $amount->total,
            'userId' => $amount->userId
        ];
        return response()->json($amount); 
    }
     
}
