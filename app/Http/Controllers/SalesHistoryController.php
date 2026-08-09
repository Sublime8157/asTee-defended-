<?php

namespace App\Http\Controllers;

use App\Models\Order;

class SalesHistoryController extends Controller
{
    /** A sale is an order with money against it — the `sales` table is gone. */
    public function display()
    {
        return view('admin.sales', [
            'sales' => Order::paid()->with(['user', 'payments'])->latest('paid_at')->paginate(20),
        ]);
    }
}
