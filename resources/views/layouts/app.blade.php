<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        body { font-family: 'Nunito', sans-serif; background-color: #f8f9fa; }
        .sidebar { background: #343a40; min-height: 100vh; color: white; padding-top: 20px;}
        .sidebar a { color: #cfd8dc; text-decoration: none; padding: 10px 20px; display: block; border-left: 3px solid transparent; }
        .sidebar a:hover { background: #495057; color: white; border-left: 3px solid #0d6efd; }
        .navbar { background: white; box-shadow: 0 2px 4px rgba(0,0,0,.04); }
        .card { border: none; box-shadow: 0 4px 6px rgba(0,0,0,.05); border-radius: 10px; }
    </style>
</head>
<body>
    <div class="d-flex">
        @auth
        <div class="sidebar col-md-2 d-none d-md-block">
            <h4 class="text-center mb-4">Dashboard</h4>
            
            @if(Auth::guard('superadmin')->check())
                <a href="{{ route('superadmin.dashboard') }}">Companies</a>
                <a href="{{ route('superadmin.settings') }}">Settings</a>
            @else
                <a href="{{ route('home') }}">Overview</a>
                <a href="{{ route('products.index') }}">Products</a>
                <a href="{{ route('categories.index') }}">Categories</a>
                <a href="{{ route('orders.index') }}">Orders</a>
            @endif
            
            <form id="logout-form" action="{{ Auth::guard('superadmin')->check() ? route('superadmin.logout') : route('logout') }}" method="POST" class="d-none ajax-form">
                @csrf
            </form>
            <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').dispatchEvent(new Event('submit', {cancelable: true, bubbles: true}));">Logout</a>
        </div>
        @endauth
        <div class="content flex-grow-1">
            <nav class="navbar navbar-expand-md navbar-light">
                <div class="container-fluid">
                    <span class="navbar-brand mb-0 h1">{{ config('app.name', 'Laravel') }}</span>
                </div>
            </nav>
            <main class="p-4">
                @yield('content')
            </main>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('submit', function(e) {
            if (e.target.classList.contains('ajax-form')) {
                e.preventDefault();
                let form = e.target;
                let formData = new FormData(form);
                let url = form.action;
                let method = form.method;

                fetch(url, {
                    method: method,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire('Success!', data.message, 'success').then(() => {
                            if(data.redirect) window.location.href = data.redirect;
                            else location.reload();
                        });
                    } else {
                        Swal.fire('Error!', data.message || 'Something went wrong', 'error');
                    }
                })
                .catch(error => {
                    // if redirect happens, fetch handles it transparently unless it's opaque
                    if(method.toUpperCase() === 'POST' && url.includes('logout')){
                        location.reload();
                    } else {
                        Swal.fire('Error!', 'Check console for details', 'error');
                        console.error(error);
                    }
                });
            }
        });
    </script>
</body>
</html>
