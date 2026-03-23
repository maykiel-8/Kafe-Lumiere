<?php
// app/Http/Controllers/Admin/ReportController.php
namespace App\Http\Controllers\Admin;
 
use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\SalesReportExport;
 
class ReportController extends Controller
{
    public function index()
    {
        $year         = now()->year;
        $totalRevenue = Transaction::where('status', 'completed')
            ->whereYear('created_at', $year)->sum('total');
        $totalOrders  = Transaction::where('status', 'completed')
            ->whereYear('created_at', $year)->count();
        $avgOrder     = $totalOrders ? round($totalRevenue / $totalOrders, 2) : 0;
 
        return view('admin.reports.index', compact('totalRevenue', 'totalOrders', 'avgOrder', 'year'));
    }
 
    /**
     * JSON endpoint for Chart.js — supports date range filter
     */
    public function salesData(Request $request)
    {
        $request->validate([
            'from'  => ['nullable', 'date'],
            'to'    => ['nullable', 'date'],
            'group' => ['nullable', 'in:day,week,month'],
        ]);
 
        $from  = $request->from  ?? now()->startOfYear()->toDateString();
        $to    = $request->to    ?? now()->toDateString();
        $group = $request->group ?? 'month';
 
        // Yearly monthly bar chart
        $salesByMonth = Transaction::where('status', 'completed')
            ->whereBetween('created_at', [$from, $to])
            ->select(
                DB::raw('MONTH(created_at) as month'),
                DB::raw('YEAR(created_at) as year'),
                DB::raw('SUM(total) as revenue'),
                DB::raw('COUNT(*) as orders')
            )
            ->groupBy('year', 'month')
            ->orderBy('year')->orderBy('month')
            ->get();
 
        // Pie chart — sales % per product
        $salesByProduct = OrderItem::whereHas('transaction', fn($q) => $q->where('status', 'completed')
                ->whereBetween('created_at', [$from, $to]))
            ->select('product_name', DB::raw('SUM(subtotal) as revenue'))
            ->groupBy('product_name')
            ->orderByDesc('revenue')
            ->limit(8)
            ->get();
 
        // Category pie
        $salesByCategory = OrderItem::whereHas('transaction', fn($q) => $q->where('status', 'completed')
                ->whereBetween('created_at', [$from, $to]))
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->join('categories', 'products.category_id', '=', 'categories.id')
            ->select('categories.name as category', DB::raw('SUM(order_items.subtotal) as revenue'))
            ->groupBy('categories.name')
            ->get();
 
        return response()->json([
            'salesByMonth'    => $salesByMonth,
            'salesByProduct'  => $salesByProduct,
            'salesByCategory' => $salesByCategory,
        ]);
    }
 
    public function export(Request $request)
    {
        $from = $request->from ?? now()->startOfYear()->toDateString();
        $to   = $request->to   ?? now()->toDateString();
        return Excel::download(new SalesReportExport($from, $to), 'sales-report-' . now()->format('Y-m-d') . '.xlsx');
    }
}
