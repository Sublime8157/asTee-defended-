<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Processing;
use App\Models\CancelReturn;
use App\Models\orders;
use App\Models\feedback;
use App\Models\cart;
use App\Traits\FilterUser;
class accountsController extends Controller
{
    use FilterUser; 
    public function searchUsers(Request $request){
        return $this->searchUserTrait($request, '1','searchAll'); 
    }


    // sorting function
    public function sortUsers(Request $request) {

        return $this->sortUserTrait($request, '1', 'sortBy', 'orderBy'); 
    }

    public function destroy($id){
        return $this->destroyTrait($id); 
    }
    
    // display users that is only active 
    public function displayUsers() {
      return $this->displayUserTrait('1', 'whereNotNull', 'admin.accounts.active'); 
    }

    // block a user 
    public function block($id) {
       return $this->blockUnblockTrait($id, '2', 'User successfully blocked'); 
    }

    public function verifyID($id) {
        $user = User::findOrFail($id);
        $user->update([
            'verification' => 'verified',
        ]);

        return redirect()->back()->with('success', 'User Has been Verified ');
    }

}
