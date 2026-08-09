<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Traits\SortsQueries;
use Illuminate\Http\Request;

class OrderHistoryController extends Controller
{
    use SortsQueries;

    private const SORTABLE = ['id', 'user_id', 'total', 'paid_at', 'created_at'];

    public function showOrderList()
    {
        return view('admin.orders', [
            'orders' => Order::with(['user', 'items'])->latest()->paginate(20),
        ]);
    }

    public function filterOrders(Request $request)
    {
        $search = $request->input('searchOrders');

        $orders = Order::with(['user', 'items'])
            ->when($search, fn ($query) => $query->where(function ($q) use ($search) {
                $q->where('address', 'LIKE', "%{$search}%")
                    ->orWhere('contact', 'LIKE', "%{$search}%")
                    ->orWhere('id', 'LIKE', "%{$search}%")
                    ->orWhere('user_id', 'LIKE', "%{$search}%")
                    // Was a LIKE against the JSON productId blob.
                    ->orWhereHas('items', fn ($i) => $i->where('description', 'LIKE', "%{$search}%"));
            }))
            ->get();

        return view('admin.orderSearchResult', compact('orders'));
    }

    public function sortOrders(Request $request)
    {
        $orders = $this->applySort(Order::with(['user', 'items']), $request, self::SORTABLE)->get();

        return view('admin.orderSearchResult', compact('orders'));
    }

    public function filterDate(Request $request)
    {
        $validated = $request->validate([
            'startDate' => ['nullable', 'date'],
            'endDate' => ['nullable', 'date', 'after_or_equal:startDate'],
        ]);

        $query = Order::with(['user', 'items']);

        if (! empty($validated['startDate']) && ! empty($validated['endDate'])) {
            $query->whereBetween('created_at', [$validated['startDate'], $validated['endDate']]);
        }

        return view('admin.orderSearchResult', ['orders' => $query->get()]);
    }
}
