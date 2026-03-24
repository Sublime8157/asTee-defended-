<?php 
namespace App\Traits; 
use Illuminate\Http\Request;
use App\Models\User; 
use App\Models\cart;
use App\Models\orders;
use App\Models\Processing;
use App\Models\feedback;
use App\Models\CancelReturn;


trait FilterUser {
    public function searchUserTrait(Request $request, $userStatus, $searchInput){
            // get the value of input field with name attribute of searchById
            $searchById = $request->input($searchInput);
            // use the query() when you will build a data before displaying 
            $userData = User::query();
    
            // check if the input field for search id is not empty if it is not empty run the search 
            // take note that the $query callback function use to group all the where 
            if ($searchById) {
                $userData = $userData->where(function($query) use ($searchById) {
                    $query->where('fname', 'LIKE', "%{$searchById}%")
                          ->orWhere('email', 'LIKE', "%{$searchById}%")
                          ->orWhere('id', $searchById);
                });
            }
            
    
            // assign the builded data to userData variable 
            $userData->where('userStatus',  $userStatus);
            $userData = $userData->get();
    
    
            // display the result in idSearchResult a result in ajax 
            return view('admin.accounts.searchActives.idSearchResult', compact('userData'));
    }

    public function sortUserTrait(Request $request, $userStatus, $sortUsersBy, $orderUsersBy) {
           // get the sortBy input 
           $sortUsers = $request->input($sortUsersBy);
           // get the orderBy input 
           $orderBy = strtolower($request->input($orderUsersBy));
   
           // starts a building query 
           $userData = User::query();
           // order the users data based on the value of sort users with orderby
           $userData->orderBy($sortUsers, $orderBy);
           // get the result 
           $userData->where('userStatus', $userStatus);
           $userData = $userData->get();
           return view('admin.accounts.searchActives.idSearchResult', compact('userData'));
    }

    public function displayUserTrait($userStatus, $verified, $view) {
        $userData = User::query();
        $userData->where('userStatus', '=', $userStatus)
                ->$verified('email_verified_at');
        $userData = $userData->paginate(10);
        return view($view, compact('userData'));
    }

    public function blockUnblockTrait($id, $userStatus, $result) {
        $user = User::findOrFail($id);
        $user->update([
            'userStatus' => $userStatus,
        ]);

        return redirect()->back()->with('blocked', $result);
    }

    public function destroyTrait($id) {
         // remove from orders
         $cart = cart::where('userId', $id);
         $cart->delete();

         // remove from orders
         $orders = orders::where('userId', $id);
         $orders->delete();
         //remove from processsing 
         $processing = Processing::where('userId', $id);            
         $processing->delete();
         // remove from feedback
         $feedback = feedback::where('userId', $id);
         $feedback->delete();
         // remove from cancel return 
         $cancelReturn = CancelReturn::where('userId', $id);
         $cancelReturn->delete();
         // and finally remove from user 
         $user = User::findOrFail($id);
         $user->delete();

         
         return redirect()->back()->with('success', 'User deleted successfully');
    }
}


?>