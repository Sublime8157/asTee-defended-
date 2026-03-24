<?php 

namespace App\Traits;
use Illuminate\Http\Request;


trait Filter {

    public function sortTrait(Request $request, $model, $view) {
        $sortBy = $request->input('sortBy'); 
        $orderBy = $request->input('orderBy'); 

        $result = $model::query(); 
        $result->orderBy($sortBy, $orderBy);
        
        $data = $result->get(); 
        return view($view, compact('data'));   
    }

    public function displayTrait($model, $view, $model2) {
        $data = $model::paginate('20');
        $ordersId = $model2::select('id')->where('paid','not_paid')->get(); 
        return view($view, compact('data','ordersId'));
    }
    public function filterDateTrait(Request $request, $model, $view) {
        $startDate = $request->input('startDate');
        $endDate = $request->input('endDate');

       if(!empty($startDate) || !empty($endDate)) {
            $result = $model::query(); 
            $result->whereBetween('created_at', [$startDate, $endDate]);
            $data = $result->get(); 
       }
       else {
        $data = payment_history::paginate('20');
       }
       
        return view($view, compact('data'));   
    }

}


?>