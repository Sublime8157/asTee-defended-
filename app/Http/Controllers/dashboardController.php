<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\OnHand;
use App\Models\Processing;
use App\Models\CancelReturn;
class dashboardController extends Controller
{
    public function dashboard() {

        $userCount = User::where('userStatus', '=', '1')->count();
        $blockedUserCount = User::where('userStatus', '=', '2')->count();
        $onhandCount = OnHand::count();
        $onProcessCount = Processing::count();
        $oncancelReturnCount = CancelReturn::count();
        return view('admin.dashboard', ['userCount' => $userCount, 
                                        'blockedUserCount' => $blockedUserCount,
                                        'onhandCount' => $onhandCount,
                                        'onProcessCount' => $onProcessCount,
                                        'oncancelReturnCount' => $oncancelReturnCount]);
    }
}
