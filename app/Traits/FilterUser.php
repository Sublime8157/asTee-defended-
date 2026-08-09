<?php

namespace App\Traits;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

/**
 * Shared list behaviour for the three account screens (active, blocked,
 * pending), each of which is otherwise a ~30-line controller.
 *
 * The scope is now passed as a closure rather than as a `userStatus` integer.
 * The pending screen used to pass '3' — a status value that never existed in
 * the data — so the pending list was permanently empty.
 */
trait FilterUser
{
    use SortsQueries;

    private const SORTABLE = ['id', 'fname', 'lname', 'email', 'username', 'created_at'];

    public function searchUserTrait(Request $request, callable $scope, string $searchInput)
    {
        $search = $request->input($searchInput);

        $userData = User::query()
            ->tap($scope)
            ->when($search, fn (Builder $query) => $query->where(function (Builder $q) use ($search) {
                $q->where('fname', 'LIKE', "%{$search}%")
                    ->orWhere('lname', 'LIKE', "%{$search}%")
                    ->orWhere('email', 'LIKE', "%{$search}%")
                    ->orWhere('id', $search);
            }))
            ->get();

        return view('admin.accounts.searchActives.idSearchResult', compact('userData'));
    }

    public function sortUserTrait(Request $request, callable $scope, string $sortKey, string $orderKey)
    {
        $userData = $this->applySort(
            User::query()->tap($scope),
            $request,
            self::SORTABLE,
            $sortKey,
            $orderKey
        )->get();

        return view('admin.accounts.searchActives.idSearchResult', compact('userData'));
    }

    public function displayUserTrait(callable $scope, string $view)
    {
        return view($view, [
            'userData' => User::query()->tap($scope)->paginate(10),
        ]);
    }

    public function blockUnblockTrait(int $id, ?string $blockedAt, string $result)
    {
        User::findOrFail($id)->update(['blocked_at' => $blockedAt]);

        return redirect()->back()->with('blocked', $result);
    }

    /**
     * The old version deleted from carts, orders, processing, feedback and
     * cancel-return by hand, one query each, with no transaction — and missed
     * payments entirely. Every one of those is now an ON DELETE CASCADE.
     */
    public function destroyTrait(int $id)
    {
        User::findOrFail($id)->delete();

        return redirect()->back()->with('success', 'User deleted successfully');
    }
}
