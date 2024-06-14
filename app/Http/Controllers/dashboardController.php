<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Sales;
use Illuminate\Http\Request;
use App\Models\OnHand;
use App\Models\Processing;
use App\Models\CancelReturn;
use App\Models\payment_history;
use Carbon\Carbon;
class dashboardController extends Controller
{

    public function dashboard() {
        
        // retrieve the column id and created_at from the User model and group by based on the created_at and format using carbon 
        // the $data instance the created_at from the model 
        $data = User::select('id', 'created_at')->get()->groupBy(function($data){
            return Carbon::parse($data->created_at)->format('M');
        });
        // declare a array 
        $months = [];
        $monthCount = [];

        // iterate trough data variable so retrieved data we will assign the $month key to the formatted created at and the $values to the counted id 
       
        foreach($data as $month => $values){
            $months[] = $month;
            $monthCount[]=count($values);
        }
       
       // Collect all the data with column id, created_at, quantity, and amount from the Sales model
        $soldData = Sales::select('id', 'created_at', 'quantity', 'amount')->get();

        // Group the data based on month and assign it to $salesByMonth
        $salesByMonth = $soldData->groupBy(function($data) {
            return Carbon::parse($data->created_at)->format('Y-M');
        });

        $weekStart = Carbon::today()->startOfWeek(); 
        $weekEnd = Carbon::today()->endOfWeek(); 
        $yearToday = Carbon::today()->year; 

        
        

        // sales today 
        $salesToday = Sales::whereDate('created_at', Carbon::today())->get(); // get the date using carbon 
        $totalSalesToday = $salesToday->sum(function($sales){ // create a callback function assign to $sales, $sales will holds all the records from $salesToday  
           return  $sales->amount * $sales->quantity; 
        });
     
        // sales this month  
        $salesThisWeek = Sales::whereBetween('created_at',[ $weekStart, $weekEnd])->get(); // get the date using carbon 
        $totalSalesThisWeek = $salesThisWeek->sum(function($sales){ // create a callback function assign to $sales, $sales will holds all the records from $salesToday  
           return  $sales->amount * $sales->quantity; 
        });

        // sales this year 
        $salesThisYear = Sales::whereYear('created_at', $yearToday)->get(); // get the date using carbon 
        $totalSalesThisYear = $salesThisYear->sum(function($sales){ // create a callback function assign to $sales, $sales will holds all the records from $salesToday  
           return  $sales->amount * $sales->quantity; 
        });

        

        // Declare arrays
        $soldMonths = [];
        $totalAmount = [];

        // For each $salesByMonth, assign to an array with key and value ($month is the key and $sales is the value)
        foreach ($salesByMonth as $month => $sales) {
            // Assign the month to $soldMonths
            $soldMonths[] = $month;
            // Calculate the total amount for the month
            $totalAmount[] = $sales->sum(function($item) {
                return $item->amount;
            });
        }

        // Check if the arrays are correct
       


        // count the return products based on the reason 
        $counts = CancelReturn::selectRaw('reason, count(*) as count')
        ->whereIn('reason', [1, 2, 3, 4, 5, 6, 7]) // Add more reasons if needed
        ->groupBy('reason')
        ->get()
        ->pluck('count', 'reason');
    
        $wrongProduct = $counts->get(1, 0);
        $differentColors = $counts->get(2, 0);
        $wrongDesign = $counts->get(3, 0);
        $reason1 = $counts->get(4, 0);
        $reason2 = $counts->get(5, 0);
        $reason3 = $counts->get(6, 0);
        $reason4 = $counts->get(7, 0);
        // Add more variables for other reasons as needed
        
       

        $userCount = User::where('userStatus', '=', '1')->count();
        $blockedUserCount = User::where('userStatus', '=', '2')->count();
        $onhandCount = OnHand::count();
        $onProcessCount = Processing::count();
        $oncancelReturnCount = CancelReturn::count();


        $sales = Sales::select('amount','quantity')->get();
        $totalSales = $sales->sum(function($totaledSales){
            return $totaledSales->amount * $totaledSales->quantity; 
        });

        return view('admin.dashboard', compact('userCount','blockedUserCount','onhandCount','onProcessCount','oncancelReturnCount','data','months','monthCount','wrongProduct','differentColors','wrongDesign','reason1','reason2','reason3','reason4','soldMonths','totalAmount','totalSales','totalSalesToday','totalSalesThisWeek','totalSalesThisYear'));
    }

    public function filterSales(Request $request) {
        $filterFrom = $request->input('dateFrom'); 
        $filterTo = $request->input('dateTo');
    
        $data = []; 
    
        if (!empty($filterFrom) && !empty($filterTo)) { // check if it not empty 
            $result = Sales::select('created_at', 'amount', 'quantity') // select columns 
                            ->whereBetween('created_at', [$filterFrom, $filterTo]) // select the user filtered 
                            ->get();  
    
            $salesByMonth = $result->groupBy(function($date) {
                return Carbon::parse($date->created_at)->format('Y-M'); // group the result by month 
            });
    
            $totalSales = $salesByMonth->map(function($row) { // map to the result assign to $row the sum of computing the amount and quantity 
                return $row->sum(function($item) { 
                    return $item->amount * $item->quantity;
                });
            });
    
            $data = [
                'dates' => $salesByMonth->keys()->toArray(), // let the dates be the key 
                'sales' => $totalSales->values()->toArray() // let the values become the value of keys 
            ];
        }
    
        return response()->json($data); // return the response as a json 
    }
    
    
    
  
}
