<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class blockedAccountsController extends Controller
{

    // sort blocked users 
    public function sortBlockUsers(Request $request) {
        // get the sortBy input 
        $sortUsers = $request->input('sortBlockUserBy');
        // get the orderBy input 
        $orderBy = $request->input('orderBlockUserBy');

        // starts a building query 
        $userData = User::query();
        // order the users data based on the value of sort users with orderby
        $userData->orderBy($sortUsers, $orderBy);
        // get the result 
        $userData->where('userStatus', '=', '2');
        $userData = $userData->get();

        
        return view('admin.accounts.searchActives.blockedAccountsResult', compact('userData'));
    }

    // unblock a user 
    public function unblock($id) {
        $user = User::findOrFail($id);
        $user->update([
            'userStatus' => 1,
        ]);

        return redirect()->back()->with('unblocked', 'User successfully unblocked');
    }


    // search users by id. name or gmail 


    public function searchBlockedUsers(Request $request) {
        // get the value of input field with name attribute of searchById
        $searchById = $request->input('searchAllBlockedUsers');
        // use the query() when you will build a data before displaying 
        $userData = User::query();

        // check if the input field for search id is not empty if it is not empty run the search 
        if ($searchById) {
            $userData = $userData->where(function($query) use ($searchById) {
                $query->where('fname', 'LIKE', "%{$searchById}%")
                      ->orWhere('email', 'LIKE', "%{$searchById}%")
                      ->orWhere('id', $searchById);
            })->where('userStatus', '=', '2');
        }
        

        // assign the builded data to userData variable 
        $userData->where('userStatus', '=', '2');
        $userData = $userData->get();

        // display the result in idSearchResult a result in ajax 
        return view('admin.accounts.searchActives.blockedAccountsResult', compact('userData'));
    }


    

    // display blocked user by default 
    public function display(){
        $userData = User::query();
        
        $userData->where('userStatus', '=', '2');
        $userData = $userData->paginate(10);



        return view('admin.accounts.blocked', compact('userData'));
    }
}
