<?php

namespace App\Http\Controllers;

use App\Enums\CancelReason;
use App\Enums\OrderStatus;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class dashboardController extends Controller
{
    public function dashboard()
    {
        // Was six separate ->get() calls that pulled the whole sales table into
        // PHP to sum a scalar, plus a seventh for the chart. Now one aggregate
        // row and two grouped queries.
        $totals = Order::paid()
            ->selectRaw('
                SUM(total) as all_time,
                SUM(CASE WHEN DATE(paid_at) = ? THEN total ELSE 0 END) as today,
                SUM(CASE WHEN paid_at BETWEEN ? AND ? THEN total ELSE 0 END) as this_week,
                SUM(CASE WHEN paid_at BETWEEN ? AND ? THEN total ELSE 0 END) as this_year
            ', [
                Carbon::today()->toDateString(),
                Carbon::today()->startOfWeek(), Carbon::today()->endOfWeek(),
                Carbon::today()->startOfYear(), Carbon::today()->endOfYear(),
            ])
            ->first();

        // The old chart grouped by format('M'), so January 2024 and January
        // 2025 landed in the same bar.
        $salesByMonth = $this->groupByMonth(Order::paid(), 'paid_at', 'SUM(total)');
        $signupsByMonth = $this->groupByMonth(User::query(), 'created_at', 'COUNT(*)');

        $cancelCounts = OrderItem::where('status', OrderStatus::Cancelled)
            ->selectRaw('cancel_reason, COUNT(*) as total')
            ->groupBy('cancel_reason')
            ->pluck('total', 'cancel_reason');

        return view('admin.dashboard', [
            'totalSales' => $totals->all_time ?? 0,
            'totalSalesToday' => $totals->today ?? 0,
            'totalSalesThisWeek' => $totals->this_week ?? 0,
            'totalSalesThisYear' => $totals->this_year ?? 0,

            'soldMonths' => $salesByMonth->keys(),
            'totalAmount' => $salesByMonth->values(),
            'months' => $signupsByMonth->keys(),
            'monthCount' => $signupsByMonth->values(),

            // Was seven hand-numbered variables, a fourth copy of the reason
            // list after the lookup table, the Types trait and the two views.
            'cancelReasons' => collect(CancelReason::cases())
                ->mapWithKeys(fn (CancelReason $r) => [$r->label() => $cancelCounts[$r->value] ?? 0]),

            'userCount' => User::active()->count(),
            'blockedUserCount' => User::blocked()->count(),
            'onhandCount' => Product::inStock()->count(),
            'onProcessCount' => OrderItem::whereIn('status', [
                OrderStatus::ToPay, OrderStatus::ToShip, OrderStatus::ToReceive, OrderStatus::ToReview,
            ])->count(),
            'oncancelReturnCount' => OrderItem::where('status', OrderStatus::Cancelled)->count(),
        ]);
    }

    public function filterSales(Request $request)
    {
        $validated = $request->validate([
            'dateFrom' => ['required', 'date'],
            'dateTo' => ['required', 'date', 'after_or_equal:dateFrom'],
        ]);

        // The old version summed amount × quantity, but `amount` on the sales
        // row was already the order total — every filtered figure was inflated
        // by the quantity.
        $sales = $this->groupByMonth(
            Order::paid()->whereBetween('paid_at', [$validated['dateFrom'], $validated['dateTo']]),
            'paid_at',
            'SUM(total)'
        );

        return response()->json([
            'dates' => $sales->keys(),
            'sales' => $sales->values(),
        ]);
    }

    /**
     * ponytail: DATE_FORMAT is MySQL/MariaDB syntax, which is what this app
     * deploys on (docker-compose pins MariaDB 10.11). Swap for a driver
     * switch if the dashboard ever needs to run on SQLite or Postgres.
     */
    private function groupByMonth($query, string $column, string $aggregate)
    {
        return $query
            ->selectRaw("DATE_FORMAT({$column}, '%Y-%m') as period, {$aggregate} as total")
            ->groupBy('period')
            ->orderBy('period')
            ->pluck('total', 'period');
    }
}
