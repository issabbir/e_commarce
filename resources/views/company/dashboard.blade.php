@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <h2 class="mb-4">Company Dashboard</h2>
    <div class="row">
        <div class="col-md-3">
            <div class="card p-4 text-center text-white" style="background: linear-gradient(45deg, #1d976c, #93f9b9);">
                <h4>Products</h4>
                <h2>{{ $productsCount }}</h2>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card p-4 text-center text-white" style="background: linear-gradient(45deg, #4A00E0, #8E2DE2);">
                <h4>Orders</h4>
                <h2>{{ $ordersCount }}</h2>
            </div>
        </div>
        <div class="col-md-3">
             <div class="card p-4 text-center">
                 <h4>Reports</h4>
                 <div class="d-flex flex-column gap-2 mt-2">
                     <a href="{{ route('reports.download', 'sales') }}" class="btn btn-sm btn-outline-primary" target="_blank">Sales (.pdf)</a>
                     <a href="{{ route('reports.download', 'inventory') }}" class="btn btn-sm btn-outline-primary" target="_blank">Inventory (.pdf)</a>
                 </div>
             </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-md-12">
            <div class="card p-4">
                <h4>Recent Orders</h4>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Order ID</th>
                            <th>Customer</th>
                            <th>Total</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($orders as $order)
                        <tr>
                            <td>#{{ $order->id }}</td>
                            <td>{{ $order->customer_name }}</td>
                            <td>${{ $order->total }}</td>
                            <td>{{ ucfirst($order->status) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
