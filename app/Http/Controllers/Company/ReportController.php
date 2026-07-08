<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Order;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportController extends Controller
{
    public function download($type)
    {
        $data = [];
        $view = '';
        if ($type == 'sales') {
            $data['orders'] = Order::where('status', 'completed')->get();
            $view = 'reports.sales';
        } elseif ($type == 'inventory') {
            $data['products'] = Product::all();
            $view = 'reports.inventory';
        } elseif ($type == 'orders') {
            $data['orders'] = Order::all();
            $view = 'reports.orders';
        } elseif ($type == 'users') {
            $data['users'] = User::role('User')->get();
            $view = 'reports.users';
        } else {
            abort(404);
        }

        $pdf = Pdf::loadView($view, $data);
        return $pdf->download($type.'_report.pdf');
    }
}
