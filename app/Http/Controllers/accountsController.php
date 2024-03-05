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
        if($searchById) {
            $userData = $userData->where('fname', 'LIKE', "%{$searchById}%")
                                 ->orWhere('email', 'LIKE', "%{$searchById}%")
                                 ->orWhere('id', $searchById);
        }

        // assign the builded data to userData variable 
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
        $userData = $userData->get();

        
        return view('admin.accounts.searchActives.idSearchResult', compact('userData'));
    }

    

    public function displayUsers() {
        $userData = User::all();
        
        return view('admin.accounts.active', compact('userData'));
    }

    // the $id was from the action pass from the html to routes and ends here 
    public function destroy($id)
        {
            $user = User::findOrFail($id);
            $user->delete();

            
            return redirect()->back()->with('success', 'User deleted successfully');
        }

}
