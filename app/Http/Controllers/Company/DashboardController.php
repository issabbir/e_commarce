<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Order;

class DashboardController extends Controller
{
    public function index()
    {
        $productsCount = Product::count();
        $ordersCount = Order::count();
        $orders = Order::with('items')->latest()->take(5)->get();
        return view('company.dashboard', compact('productsCount', 'ordersCount', 'orders'));
    }
}
