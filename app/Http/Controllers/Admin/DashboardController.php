<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Dompdf\Dompdf;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\User;
use App\Models\Order;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index(Request $request)
    {

        $data = [
            'total_product' => Product::count(),
            'total_user' => User::count(),
            'total_order' => Order::count(),
        ];

        $data['total_income'] = Order::where('status', 4)->sum('total_price');

        $currentYear = date('Y');
        $currentMonth = date('m');

        $barCharData = Order::select(
                    DB::raw('DAY(created_at) as day'),
                    DB::raw('COUNT(*) as total_orders')
                )
                ->whereYear('created_at', $currentYear)
                ->whereMonth('created_at', $currentMonth)
                ->groupBy('day')
                ->get()
                ->pluck('total_orders', 'day') 
                ->toArray();
        
        $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $currentMonth, $currentYear);
        for ($day = 1; $day <= $daysInMonth; $day++) {
            if (!array_key_exists($day, $barCharData)) {
                $barCharData[$day] = 0;
            }
        }
        ksort($barCharData);

        
        $statusCounts = Order::select('status', DB::raw('COUNT(*) as count'))
                            ->groupBy('status')
                            ->get()
                            ->pluck('count', 'status')
                            ->toArray();

        $statusMapping = [
            0 => 'Cancel',
            1 => 'Return',
            2 => 'Pending',
            3 => 'In progress',
            4 => 'Delivered'
        ];

        $pieChartData = [];

        foreach ($statusMapping as $statusKey => $statusName) {
            $pieChartData[$statusName] = $statusCounts[$statusKey] ?? 0;
        }
        return view('admin.dashboard', compact('data','barCharData','pieChartData'));
    }

    public function downloadMonthlyReport(Request $request)
{
    $month = $request->input('month');
    $year = $request->input('year');

    $request->validate([
        'month' => 'required|integer|min:1|max:12',
        'year' => 'required|integer|min:2020|max:' . date('Y'),
    ]);

    $total_income = Order::whereMonth('created_at', $month)
                         ->whereYear('created_at', $year)
                         ->where('status', 4)
                         ->sum('total_price');

    $total_orders = Order::whereMonth('created_at', $month)
                         ->whereYear('created_at', $year)
                         ->count();

    $cancelled_orders = Order::whereMonth('created_at', $month)
                             ->whereYear('created_at', $year)
                             ->where('status', 0)
                             ->count();

    $returned_orders = Order::whereMonth('created_at', $month)
                            ->whereYear('created_at', $year)
                            ->where('status', 1)
                            ->count();

    $delivered_orders = Order::whereMonth('created_at', $month)
                             ->whereYear('created_at', $year)
                             ->where('status', 4)
                             ->count();

    $dompdf = new Dompdf();
    $dompdf->loadHtml(view('admin.reports.monthly_report', compact(
        'month', 'year', 'total_income', 'total_orders', 
        'cancelled_orders', 'returned_orders', 'delivered_orders'
    )));

    $dompdf->render();

    return $dompdf->stream('Monthly_report_' . $month . '_' . $year . '.pdf');
}
}
