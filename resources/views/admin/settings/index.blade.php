@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="card shadow-sm border-0 mt-5">
                <div class="card-header bg-white pb-0 border-0">
                    <h4 class="card-title fw-bold">Site Settings</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('superadmin.settings.update') }}" method="POST" class="ajax-form">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Site Name</label>
                            <input type="text" name="site_name" class="form-control" value="{{ $settings['site_name'] ?? '' }}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Primary Color</label>
                            <input type="color" name="primary_color" class="form-control form-control-color w-100" value="{{ $settings['primary_color'] ?? '#f85606' }}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Contact Email</label>
                            <input type="email" name="contact_email" class="form-control" value="{{ $settings['contact_email'] ?? '' }}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Phone Number</label>
                            <input type="text" name="phone_number" class="form-control" value="{{ $settings['phone_number'] ?? '' }}">
                        </div>
                        
                        <div class="text-end">
                            <button type="submit" class="btn btn-primary px-4 rounded-pill">Save Settings</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
