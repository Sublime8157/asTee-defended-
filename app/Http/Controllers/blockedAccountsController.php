<?php

namespace App\Http\Controllers;

use App\Traits\FilterUser;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class blockedAccountsController extends Controller
{
    use FilterUser;

    private function scope(): callable
    {
        return fn (Builder $query) => $query->whereNotNull('blocked_at');
    }

    public function display()
    {
        return $this->displayUserTrait($this->scope(), 'admin.accounts.blocked');
    }

    public function searchBlockedUsers(Request $request)
    {
        return $this->searchUserTrait($request, $this->scope(), 'searchAllBlockedUsers');
    }

    public function sortBlockUsers(Request $request)
    {
        return $this->sortUserTrait($request, $this->scope(), 'sortBlockUserBy', 'orderBlockUserBy');
    }

    public function unblock(int $id)
    {
        return $this->blockUnblockTrait($id, null, 'User successfully unblocked');
    }
}
