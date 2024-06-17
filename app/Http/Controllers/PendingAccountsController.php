<?php

namespace App\Http\Controllers;
namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use App\Traits\FilterUser; 

class PendingAccountsController extends Controller
{
    use FilterUser; 
    
   // display users that is only active 
   public function displayUsers() {
      return $this->displayUserTrait('3', 'whereNull', 'admin.accounts.pending'); 
   }

    // sort blocked users 
    public function sortPendingUsers(Request $request) {
     return $this->sortUserTrait($request, '3', 'sortPendingUsersBy', 'orderPendingUsersBy');
    }

    
    public function searchPendingUsers(Request $request) {
       return $this->searchUserTrait($request, '3', 'searchPendingUsers'); 
    }

    
    
}
