@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <h2 class="mb-4">Super Admin Dashboard</h2>
    <div class="row">
        <div class="col-md-12">
            <div class="card p-4">
                <h4>All Companies</h4>
                <table class="table mt-3">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Domain</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($companies as $company)
                        <tr>
                            <td>{{ $company->id }}</td>
                            <td>{{ $company->name }}</td>
                            <td>{{ $company->email }}</td>
                            <td>{{ $company->domain }}</td>
                            <td><span class="badge bg-success">Active</span></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
