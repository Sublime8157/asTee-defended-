<?php

namespace App\Http\Controllers;

use App\Traits\FilterUser;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class PendingAccountsController extends Controller
{
    use FilterUser;

    /** Signed up but never confirmed their email address. */
    private function scope(): callable
    {
        return fn (Builder $query) => $query->whereNull('email_verified_at');
    }

    public function displayUsers()
    {
        return $this->displayUserTrait($this->scope(), 'admin.accounts.pending');
    }

    public function searchPendingUsers(Request $request)
    {
        return $this->searchUserTrait($request, $this->scope(), 'searchPendingUsers');
    }

    public function sortPendingUsers(Request $request)
    {
        return $this->sortUserTrait($request, $this->scope(), 'sortPendingUsersBy', 'orderPendingUsersBy');
    }
}
