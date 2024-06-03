<?php

namespace App\Http\Controllers;
namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;


class PendingAccountsController extends Controller
{
    public function displayUsers() {
        $pendingUserData = User::query();
        $pendingUserData->whereNull('email_verified_at');
        $pendingUserData = $pendingUserData->paginate(10);
        return view('admin.accounts.pending', compact('pendingUserData'));
    }
    // sort blocked users 
    public function sortPendingUsers(Request $request) {
        // get the sortBy input 
        $sortUsers = $request->input('sortPendingUsersBy');
        // get the orderBy input 
        $orderBy = $request->input('orderPendingUsersBy');
        // starts a building query 
        $userData = User::query();
        // order the users data based on the value of sort users with orderby
        $userData->orderBy($sortUsers, $orderBy);
        // get the result 
        $userData->whereNull('email_verified_at');
        $userData = $userData->get();
        return view('admin.accounts.searchActives.blockedAccountsResult', compact('userData'));
    }

    
    public function searchPendingUsers(Request $request) {
        // get the value of input field with name attribute of searchById
        $searchById = $request->input('searchPendingUsers');
        // use the query() when you will build a data before displaying 
        $userData = User::query();
        // check if the input field for search id is not empty if it is not empty run the search 
        if ($searchById) {
            $userData = $userData->where(function($query) use ($searchById) {
                $query->where('fname', 'LIKE', "%{$searchById}%")
                      ->orWhere('email', 'LIKE', "%{$searchById}%")
                      ->orWhere('id', $searchById);
            });
        }
        

        // assign the builded data to userData variable 
        $userData->whereNull('email_verified_at');
        $userData = $userData->get();

        // display the result in idSearchResult a result in ajax 
        return view('admin.accounts.searchActives.blockedAccountsResult', compact('userData'));
    }
    
}
