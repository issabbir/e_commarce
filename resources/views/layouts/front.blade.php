<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @php
        $settings = \App\Models\SiteSetting::pluck('value', 'key');
        $primaryColor = $settings['primary_color'] ?? '#f85606';
        $siteName = $settings['site_name'] ?? 'Daraz Clone';
        $cartCount = count(session()->get('cart', []));
    @endphp

    <title>{{ $siteName }}</title>

    <link rel="icon" type="image/png" href="/favicon.png">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    
    <style>
        :root {
            --primary-color: {{ $primaryColor }};
            --glass-bg: rgba(255, 255, 255, 0.85);
            --glass-border: rgba(255, 255, 255, 0.3);
            --card-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.07);
        }
        body { font-family: 'Roboto', sans-serif; background-color: #f0f2f5; color: #1c1e21; }
        .bg-primary-theme { background-color: var(--primary-color) !important; }
        .text-primary-theme { color: var(--primary-color) !important; }
        .btn-primary-theme { 
            background-color: var(--primary-color); 
            border-color: var(--primary-color);
            color: white;
            transition: all 0.3s;
        }
        .btn-primary-theme:hover { 
            background-color: #333 !important; 
            border-color: #333 !important; 
            color: white !important;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            transform: translateY(-2px);
        }
        
        /* Glassmorphism Header */
        .main-header { 
            background: var(--glass-bg);
            backdrop-filter: blur(8px);
            -webkit-backdrop-filter: blur(8px);
            border-bottom: 1px solid var(--glass-border);
            padding: 8px 0;
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        }
        
        .search-bar form { display: flex; width: 100%; }
        .search-input { 
            border-radius: 50px 0 0 50px; 
            background: #fff; 
            border: 1px solid #ddd; 
            padding: 10px 25px; 
            outline: none; 
            transition: all 0.3s;
            flex: 1;
        }
        .search-input:focus { box-shadow: 0 0 0 3px rgba({{ hexdec(substr($primaryColor, 1, 2)) }}, {{ hexdec(substr($primaryColor, 3, 2)) }}, {{ hexdec(substr($primaryColor, 5, 2)) }}, 0.1); border-color: var(--primary-color); }
        .search-btn { 
            background: var(--primary-color); 
            color: white; 
            border: none; 
            padding: 10px 30px; 
            border-radius: 0 50px 50px 0;
            transition: background 0.3s;
            white-space: nowrap;
        }
        .search-btn:hover { background: #333; }
        
        .search-bar { position: relative; }
        #search-suggestions {
            position: absolute;
            top: 100%;
            left: 0;
            width: calc(100% - 100px); /* Adjust based on search button width */
            background: white;
            border-radius: 0 0 12px 12px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
            z-index: 1000;
            display: none;
            border: 1px solid #eee;
            margin-top: -1px;
        }
        .suggestion-item {
            padding: 12px 25px;
            cursor: pointer;
            transition: background 0.2s;
            font-size: 14px;
            color: #1c1e21;
        }
        .suggestion-item:hover { background: #f0f2f5; color: var(--primary-color); }
        .suggestion-item i { margin-right: 12px; color: #8e8e8e; }
        
        /* Modern Sidebar */
        .category-sidebar { 
            background: white; 
            border-radius: 12px; 
            padding: 15px 0; 
            min-height: 300px; 
            border: 1px solid #eee;
            box-shadow: var(--card-shadow);
        }
        .category-item { padding: 10px 20px; font-size: 14px; color: #4b4f56; display: block; text-decoration: none; transition: color 0.2s, padding-left 0.2s; }
        .category-item:hover { color: var(--primary-color); padding-left: 25px; font-weight: 500; }
        
        /* Top small nav */
        .top-nav { font-size: 11px; background: #fafafb; padding: 10px 0; border-bottom: 1px solid #eef0f3; }
        .top-nav a { text-decoration: none; color: #65676b; margin-left: 20px; transition: color 0.2s; font-weight: 500; }
        .top-nav a:hover { color: var(--primary-color); }
        
        /* Product Card - Enhanced */
        .product-card { 
            background: white; 
            border-radius: 12px; 
            transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1); 
            text-decoration: none; 
            color: inherit; 
            display: block;
            border: 1px solid #f0f0f0;
            overflow: hidden;
            box-shadow: 0 2px 4px rgba(0,0,0,0.02);
        }
        .product-card:hover { 
            transform: translateY(-8px);
            box-shadow: 0 12px 24px rgba(0,0,0,0.1);
            border-color: #ddd;
        }
        .product-img-wrapper { height: 180px; width: 100%; overflow: hidden; position: relative; border-bottom: 1px solid #f5f5f5;}
        .product-img { height: 100%; width: 100%; object-fit: cover; transition: transform 0.6s ease; }
        .product-card:hover .product-img { transform: scale(1.1); }
        
        .product-title { font-size: 14px; font-weight: 500; color: #1c1e21; margin: 10px 0 5px 0; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; min-height: 40px;}
        .product-price { font-size: 18px; font-weight: 800; color: #1c1e21; }
        
        /* Banners */
        .carousel-item { border-radius: 12px; overflow: hidden; height: 350px; }
        .offer-banner-small { height: 165px; border-radius: 12px; transition: transform 0.3s; cursor: pointer; border: 1px solid #eee; overflow: hidden;}
        .offer-banner-small:hover { transform: scale(1.02); }
    </style>
</head>
<body>

    <!-- Top mini nav -->
    <div class="top-nav">
        <div class="container d-flex justify-content-end">
            <a href="#">SAVE MORE ON APP</a>
            <a href="#">SELL ON {{ strtoupper($siteName) }}</a>
            <a href="#">CUSTOMER CARE</a>
            <a href="#">TRACK MY ORDER</a>
            @auth
                <a href="{{ route('home') }}">My Dashboard</a>
                <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
            @else
                <a href="{{ route('login') }}">LOGIN</a>
                <a href="{{ route('register') }}">SIGN UP</a>
            @endauth
        </div>
    </div>

    <!-- Main Header -->
    <header class="main-header sticky-top">
        <div class="container">
            <div class="row align-items-center">
                <!-- Logo -->
                <div class="col-md-3 col-lg-3">
                    <a href="/" class="text-decoration-none d-flex align-items-center">
                        <img src="/logo-icon.png" alt="Nexora Icon" style="height: 50px; width: auto; margin-right: 12px;">
                        <span style="font-size: 38px; font-weight: 900; letter-spacing: -1.5px; background: linear-gradient(45deg, #f85606, #212121); -webkit-background-clip: text; -webkit-text-fill-color: transparent; font-family: 'Outfit', 'Roboto', sans-serif;">Nexora</span>
                    </a>
                </div>
                <!-- Search -->
                <div class="col-md-7 col-lg-7 search-bar">
                    <form action="/" id="search-form">
                        <input type="text" name="search" id="search-input" autocomplete="off" class="form-control search-input" placeholder="Search in {{ $siteName }}" value="{{ $search ?? '' }}">
                        <button type="submit" class="search-btn"><i class="bi bi-search"></i></button>
                    </form>
                    <div id="search-suggestions"></div>
                </div>

                <script>
                    const searchInput = document.getElementById('search-input');
                    const suggestionsBox = document.getElementById('search-suggestions');

                    searchInput.addEventListener('input', function() {
                        const query = this.value;
                        if (query.length < 2) {
                            suggestionsBox.style.display = 'none';
                            return;
                        }

                        fetch(`/api/search/suggestions?query=${encodeURIComponent(query)}`)
                            .then(response => response.json())
                            .then(data => {
                                suggestionsBox.innerHTML = '';
                                if (data.length > 0) {
                                    data.forEach(item => {
                                        const div = document.createElement('div');
                                        div.className = 'suggestion-item';
                                        div.innerHTML = `<i class="bi bi-search"></i>${item}`;
                                        div.onclick = function() {
                                            searchInput.value = item;
                                            document.getElementById('search-form').submit();
                                        };
                                        suggestionsBox.appendChild(div);
                                    });
                                    suggestionsBox.style.display = 'block';
                                } else {
                                    suggestionsBox.style.display = 'none';
                                }
                            });
                    });

                    document.addEventListener('click', function(e) {
                        if (e.target !== searchInput && e.target !== suggestionsBox) {
                            suggestionsBox.style.display = 'none';
                        }
                    });

                    function showToast(message) {
                        const toastElement = document.getElementById('liveToast');
                        const toastMessage = document.getElementById('toast-message');
                        toastMessage.innerText = message;
                        const toast = new bootstrap.Toast(toastElement);
                        toast.show();
                    }

                    function addToCart(productId, quantity = 1) {
                        fetch(`/cart/add/${productId}`, {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                                'Accept': 'application/json',
                                'Content-Type': 'application/json'
                            },
                            body: JSON.stringify({ quantity: parseInt(quantity) })
                        })
                        .then(response => response.json())
                        .then(data => {
                            if(data.status === 'success') {
                                document.getElementById('cart-badge').innerText = data.cart_count;
                                showToast(data.message);
                            }
                        });
                    }
                </script>
                <!-- Cart -->
                <div class="col-md-2 text-end">
                    <a href="{{ route('cart.index') }}" class="text-dark fs-4 position-relative">
                        <i class="bi bi-cart3"></i>
                        <span id="cart-badge" class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-primary-theme" style="font-size: 10px;">
                            {{ $cartCount }}
                        </span>
                    </a>
                </div>
            </div>
        </div>
    </header>

    <!-- Toast Container -->
    <div class="toast-container position-fixed bottom-0 end-0 p-3" style="z-index: 2000;">
        <div id="liveToast" class="toast align-items-center text-white bg-primary-theme border-0 rounded-4" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex p-2">
                <div class="toast-body fw-bold" id="toast-message">
                    Product added to cart!
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
    </div>

    <main class="py-4">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-white py-5 mt-5">
        <div class="container text-center text-muted">
            <p>&copy; {{ date('Y') }} {{ $siteName }}. All rights reserved.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
