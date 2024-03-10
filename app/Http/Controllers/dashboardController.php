<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\OnHand;
use App\Models\Processing;
use App\Models\CancelReturn;
use Carbon\Carbon;
class dashboardController extends Controller
{

    public function dashboard() {
        // count the users group by months 
        $data = User::select('id', 'created_at')->get()->groupBy(function($data){
            return Carbon::parse($data->created_at)->format('M');
        });

        $months = [];
        $monthCount = [];
        foreach($data as $month => $values){
            $months[] = $month;
            $monthCount[]=count($values);
        }
       
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
        return view('admin.dashboard', ['userCount' => $userCount, 
                                        'blockedUserCount' => $blockedUserCount,
                                        'onhandCount' => $onhandCount,
                                        'onProcessCount' => $onProcessCount,
                                        'oncancelReturnCount' => $oncancelReturnCount,
                                        'data' => $data,
                                        'months' => $months,
                                        'monthCount' => $monthCount,
                                        'wrongProduct' => $wrongProduct,
                                        'differentColors' => $differentColors,
                                        'wrongDesign' => $wrongDesign,
                                        'reason1' => $reason1,
                                        'reason2' => $reason2,
                                        'reason3' => $reason3,
                                        'reason4' => $reason4]);
    }
    
  
}
