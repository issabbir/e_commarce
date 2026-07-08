<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Company;

class DashboardController extends Controller
{
    public function index()
    {
        $companies = Company::all();
        return view('admin.dashboard', compact('companies'));
    }
}
