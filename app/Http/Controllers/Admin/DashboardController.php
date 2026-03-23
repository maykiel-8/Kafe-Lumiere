<?php
// app/Http/Controllers/Admin/DashboardController.php
namespace App\Http\Controllers\Admin;
 
use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\Product;
use App\Models\User;
use App\Models\Review;
use Illuminate\Support\Facades\DB;
 
class DashboardController extends Controller
{
    public function index()
    {
        $today = today();
 
        $todaySales    = Transaction::where('status', 'completed')->whereDate('created_at', $today)->sum('total');
        $todayOrders   = Transaction::where('status', 'completed')->whereDate('created_at', $today)->count();
        $monthRevenue  = Transaction::where('status', 'completed')->whereMonth('created_at', now()->month)->sum('total');
        $activeProducts= Product::where('is_available', true)->count();
        $totalUsers    = User::count();
        $pendingOrders = Transaction::where('status', 'pending')->count();
 
        // Recent 5 transactions
        $recentTransactions = Transaction::with('cashier')->latest()->take(5)->get();
 
        // Top 5 products by revenue this month
        $topProducts = DB::table('order_items')
            ->join('transactions', 'order_items.transaction_id', '=', 'transactions.id')
            ->where('transactions.status', 'completed')
            ->whereMonth('transactions.created_at', now()->month)
            ->select('order_items.product_name', DB::raw('SUM(order_items.subtotal) as revenue'), DB::raw('SUM(order_items.quantity) as qty'))
            ->groupBy('order_items.product_name')
            ->orderByDesc('revenue')
            ->take(5)
            ->get();
 
        return view('admin.dashboard', compact(
            'todaySales', 'todayOrders', 'monthRevenue', 'activeProducts',
            'totalUsers', 'pendingOrders', 'recentTransactions', 'topProducts'
        ));
    }
}
