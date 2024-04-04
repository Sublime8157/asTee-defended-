<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;

class accountsController extends Controller
{
    
    public function searchUsers(Request $request) {
        // get the value of input field with name attribute of searchById
        $searchById = $request->input('searchAll');
        // use the query() when you will build a data before displaying 
        $userData = User::query();

        // check if the input field for search id is not empty if it is not empty run the search 
        if ($searchById) {
            $userData = $userData->where(function($query) use ($searchById) {
                $query->where('fname', 'LIKE', "%{$searchById}%")
                      ->orWhere('email', 'LIKE', "%{$searchById}%")
                      ->orWhere('id', $searchById);
            })->where('userStatus', '=', '1');
        }
        

        // assign the builded data to userData variable 
        $userData->where('userStatus', '=', '1');
        $userData = $userData->get();


        // display the result in idSearchResult a result in ajax 
        return view('admin.accounts.searchActives.idSearchResult', compact('userData'));
    }
    
    // sorting function
    public function sortUsers(Request $request) {
        // get the sortBy input 
        $sortUsers = $request->input('sortBy');
        // get the orderBy input 
        $orderBy = strtolower($request->input('orderBy'));

        // starts a building query 
        $userData = User::query();
        // order the users data based on the value of sort users with orderby
        $userData->orderBy($sortUsers, $orderBy);
        // get the result 
        $userData->where('userStatus', '=', '1');
        $userData = $userData->get();

        
        return view('admin.accounts.searchActives.idSearchResult', compact('userData'));
    }

    
    // display users that is only active 
    public function displayUsers() {
        $userData = User::query();
        $userData->where('userStatus', '=', '1');

        
       
        $userData = $userData->paginate(10);
        return view('admin.accounts.active', compact('userData'));
    }

    // block a user 
    public function block($id) {
        $user = User::findOrFail($id);
        $user->update([
            'userStatus' => 2,
        ]);

        return redirect()->back()->with('blocked', 'User successfully blocked');
    }

    // the $id was from the action pass from the html to routes and ends here 
    // remove a suer 
    public function destroy($id)
        {
            $user = User::findOrFail($id);
            $user->delete();

            
            return redirect()->back()->with('success', 'User deleted successfully');
        }

}
