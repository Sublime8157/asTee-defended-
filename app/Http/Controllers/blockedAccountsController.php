<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Traits\FilterUser; 
class blockedAccountsController extends Controller
{

    use FilterUser; 
    // sort blocked users 
    public function sortBlockUsers(Request $request) {
        return $this->sortUserTrait($request, '2', 'sortBlockUserBy', 'orderBlockUserBy'); 
    }

    // unblock a user 
    public function unblock($id) {
        return $this->blockUnblockTrait($id, '1', 'User successfully unblocked');
    }

    // search users by id. name or gmail 
    public function searchBlockedUsers(Request $request) {
      return $this->searchUserTrait($request, '2', 'searchAllBlockedUsers');
    }


    // display blocked user by default 
    public function display(){
      return $this->displayUserTrait('2','whereNotNull', 'admin.accounts.blocked');
    }
}
