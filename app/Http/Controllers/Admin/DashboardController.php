<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
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

        /* Xử lý lấy data cho Bar chart */
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

        // Xử lý để thêm các ngày không có đơn hàng vào mảng
        $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $currentMonth, $currentYear);
        for ($day = 1; $day <= $daysInMonth; $day++) {
            if (!array_key_exists($day, $barCharData)) {
                $barCharData[$day] = 0;
            }
        }

        ksort($barCharData);

        /* Xử lý lấy data cho Pie Chart */
        $statusCounts = Order::select('status', DB::raw('COUNT(*) as count'))
                            ->groupBy('status')
                            ->get()
                            ->pluck('count', 'status')
                            ->toArray();

        // Status mapping
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
}
