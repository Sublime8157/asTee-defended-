<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Traits\FilterUser;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class accountsController extends Controller
{
    use FilterUser;

    /** Verified customers who are not blocked. */
    private function scope(): callable
    {
        return fn (Builder $query) => $query->whereNull('blocked_at')->whereNotNull('email_verified_at');
    }

    public function displayUsers()
    {
        return $this->displayUserTrait($this->scope(), 'admin.accounts.active');
    }

    public function searchUsers(Request $request)
    {
        return $this->searchUserTrait($request, $this->scope(), 'searchAll');
    }

    public function sortUsers(Request $request)
    {
        return $this->sortUserTrait($request, $this->scope(), 'sortBy', 'orderBy');
    }

    public function block(int $id)
    {
        return $this->blockUnblockTrait($id, now()->toDateTimeString(), 'User successfully blocked');
    }

    public function destroy(int $id)
    {
        return $this->destroyTrait($id);
    }

    /** Approve the uploaded government ID. */
    public function verifyID(int $id)
    {
        User::findOrFail($id)->update(['id_verified_at' => now()]);

        return redirect()->back()->with('success', 'User has been verified');
    }
}
