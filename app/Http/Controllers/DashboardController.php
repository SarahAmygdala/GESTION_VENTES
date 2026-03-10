<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Sale;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_sales_today' => Sale::whereDate('created_at', today())->sum('total'),
            'sales_count_today' => Sale::whereDate('created_at', today())->count(),
            'low_stock_count'   => Product::where('stock', '<=', DB::raw('min_stock'))->count(),
            'total_clients'     => Client::count(),
        ];

        // Sales for the last 7 days
        $sales_chart = Sale::select(
            DB::raw('DATE(created_at) as date'),
            DB::raw('SUM(total) as total')
        )
            ->where('created_at', '>=', now()->subDays(6))
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        $low_stock_products = Product::with('category')
            ->where('stock', '<=', DB::raw('min_stock'))
            ->orderBy('stock', 'asc')
            ->limit(5)
            ->get();

        return view('dashboard', compact('stats', 'sales_chart', 'low_stock_products'));
    }

    public function reports()
    {
        return view('reports.index');
    }

    public function settings()
    {
        return view('settings.index');
    }
}
