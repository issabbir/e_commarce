@extends('layouts.front')

@section('content')
<div class="container">
    <!-- Hero Section with Carousel and Side Banners -->
    <div class="row mb-5 g-4">
        <!-- Categories -->
        <div class="col-lg-2 d-none d-lg-block">
            <div class="category-sidebar position-relative">
                <div class="px-4 py-2 border-bottom mb-2">
                    <h6 class="fw-bold m-0"><i class="bi bi-list me-2"></i>Categories</h6>
                </div>
                @forelse($categories as $category)
                    <div class="category-wrapper">
                        <a href="/?category={{ $category->id }}" class="category-item d-flex justify-content-between align-items-center">
                            <span>{{ $category->name }}</span>
                            <i class="bi bi-chevron-right text-muted" style="font-size: 10px;"></i>
                        </a>
                        <!-- Subcategory Flyout -->
                        <div class="category-flyout bg-white shadow rounded-4 border p-4">
                            <h6 class="fw-bold mb-3 text-primary-theme small text-uppercase">{{ $category->name }}</h6>
                            <div class="row row-cols-1 g-2">
                                @foreach($category->subcategories as $sub)
                                    <div class="col">
                                        <a href="/?category={{ $category->id }}&search={{ urlencode($sub->name) }}"
                                           class="text-decoration-none text-muted small category-sub-link d-block p-1">
                                            {{ $sub->name }}
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="p-3 text-muted small">No categories</div>
                @endforelse
            </div>
        </div>

        <style>
            .category-sidebar { position: relative; z-index: 1000; }
            .category-wrapper { position: relative; }
            .category-flyout { 
                position: absolute; 
                left: 100%; 
                top: 0; 
                width: 260px; 
                display: none; 
                z-index: 1001; 
                margin-left: 5px;
                animation: slideInTray 0.2s ease;
                min-height: 100%;
            }
            .category-wrapper:hover .category-flyout { display: block; }
            .category-wrapper:hover .category-item { background: #f8f9fa; color: var(--primary-color); border-left: 3px solid var(--primary-color); padding-left: 17px !important; }
            .category-item { border-left: 3px solid transparent; transition: all 0.2s; padding: 8px 20px; text-decoration: none; color: #4b4f56; font-size: 14px; }
            .category-sub-link:hover { color: var(--primary-color) !important; padding-left: 10px !important; transition: all 0.2s; }

            @keyframes slideInTray {
                from { opacity: 0; transform: translateX(10px); }
                to { opacity: 1; transform: translateX(0); }
            }
        </style>
        
        <!-- Main Carousel -->
        <div class="col-lg-7">
            <div id="heroCarousel" class="carousel slide shadow-sm" data-bs-ride="carousel">
                <div class="carousel-indicators">
                    <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="0" class="active"></button>
                    <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="1"></button>
                    <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="2"></button>
                </div>
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <div class="w-100 h-100 d-flex align-items-center justify-content-center" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                            <div class="text-center text-white p-5">
                                <h4 class="text-uppercase fw-light mb-2">Exclusive Deal</h4>
                                <h1 class="display-3 fw-bold mb-4">Summer Collection</h1>
                                <button class="btn btn-light btn-lg rounded-pill px-5 py-3 fw-bold">Shop Now</button>
                            </div>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <div class="w-100 h-100 d-flex align-items-center justify-content-center" style="background: linear-gradient(135deg, #ff9a9e 0%, #fecfef 99%, #fecfef 100%);">
                            <div class="text-center text-dark p-5">
                                <h4 class="text-uppercase fw-light mb-2">New Arrival</h4>
                                <h1 class="display-3 fw-bold mb-4">Smart Gadgets</h1>
                                <button class="btn btn-dark btn-lg rounded-pill px-4">Discover More</button>
                            </div>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <div class="w-100 h-100 d-flex align-items-center justify-content-center" style="background: linear-gradient(135deg, #a1c4fd 0%, #c2e9fb 100%);">
                            <div class="text-center text-dark p-5">
                                <h4 class="text-uppercase fw-light mb-2">Save More</h4>
                                <h1 class="display-3 fw-bold mb-4">Home Interior</h1>
                                <button class="btn btn-primary btn-lg rounded-pill px-4">Explore</button>
                            </div>
                        </div>
                    </div>
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon"></span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
                    <span class="carousel-control-next-icon"></span>
                </button>
            </div>
        </div>

        <!-- Side Banners -->
        <div class="col-lg-3 d-none d-lg-block">
            <div class="offer-banner-small mb-3 d-flex align-items-center justify-content-center" style="background: linear-gradient(to right, #4facfe 0%, #00f2fe 100%);">
                 <div class="text-center text-white px-3">
                    <h5 class="fw-bold mb-0">Flash Sale</h5>
                    <p class="small mb-0">Up to 70% Off</p>
                 </div>
            </div>
            <div class="offer-banner-small d-flex align-items-center justify-content-center" style="background: linear-gradient(to top, #f43f5e 0%, #fb7185 100%);">
                <div class="text-center text-white px-3">
                    <h5 class="fw-bold mb-0">Limited Vouchers</h5>
                    <p class="small mb-0">Get ৳10 Off Now</p>
                 </div>
            </div>
        </div>
    </div>

    <!-- Flash Deals Section -->
    <div class="mb-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="fw-bold m-0"><i class="bi bi-lightning-fill text-warning me-2"></i>Flash Deals</h4>
            <a href="{{ route('flash-deals') }}" class="text-primary-theme text-decoration-none fw-bold">View All <i class="bi bi-arrow-right"></i></a>
        </div>
        <div class="row row-cols-2 row-cols-md-4 row-cols-lg-6 g-3">
             @foreach($products->take(6) as $product)
                <div class="col">
                    <a href="{{ route('product.show', $product->id) }}" class="product-card">
                         <div class="position-absolute m-2" style="z-index: 10;">
                            <span class="badge bg-danger rounded-pill px-3">-{{ rand(30, 80) }}%</span>
                        </div>
                        <div class="product-img-wrapper">
                            <img src="{{ $product->image }}" class="product-img" alt="{{ $product->name }}">
                        </div>
                        <div class="p-3 text-center">
                            <div class="product-price text-primary-theme">৳{{ number_format($product->price * 0.5, 2) }}</div>
                            <div class="text-muted small text-decoration-line-through">৳{{ number_format($product->price, 2) }}</div>
                        </div>
                    </a>
                </div>
             @endforeach
        </div>
    </div>

    <!-- Just For You Section -->
    <div class="mb-3 d-flex justify-content-between align-items-center">
        <h4 class="fw-bold" style="color: #1c1e21;">Just For You</h4>
        <p class="text-muted small mb-0">Based on your interests</p>
    </div>

    <div class="row row-cols-2 row-cols-md-4 row-cols-lg-6 g-3">
        @forelse($products as $product)
            <div class="col">
                <a href="{{ route('product.show', $product->id) }}" class="product-card h-100 shadow-sm border-0">
                    <div class="position-absolute m-2" style="z-index: 10;">
                        <span class="badge bg-danger rounded-pill px-2">-{{ rand(10, 50) }}%</span>
                    </div>
                    <div class="product-img-wrapper">
                        @if($product->image)
                            <img src="{{ $product->image }}" class="product-img" alt="{{ $product->name }}">
                        @else
                            <div class="d-flex align-items-center justify-content-center h-100 product-img" style="background: linear-gradient(45deg, #{{ substr(md5($product->id), 0, 6) }}, #{{ substr(md5($product->name), 0, 6) }});">
                                <span class="text-white fs-4 fw-bold">{{ substr($product->name, 0, 1) }}</span>
                            </div>
                        @endif
                    </div>
                    <div class="p-3">
                        <div class="product-title mb-2 text-dark">{{ $product->name }}</div>
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="product-price text-primary-theme">৳{{ number_format($product->price, 2) }}</div>
                            <div class="text-muted small text-decoration-line-through">৳{{ number_format($product->price * 1.2, 2) }}</div>
                        </div>
                        <div class="text-warning small mt-2">
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-half"></i>
                            <span class="text-muted ms-1" style="font-size: 11px;">({{ rand(10, 500) }})</span>
                        </div>
                    </div>
                </a>
            </div>
        @empty
            <div class="col-12 py-5 text-center w-100">
                <i class="bi bi-shop display-1 text-muted opacity-50"></i>
                <h4 class="mt-3 text-muted">No products found</h4>
                <p>Register as a company and add some products.</p>
            </div>
        @endforelse
    </div>

    <div class="d-flex justify-content-center mt-5">
        {{ $products->links() }}
    </div>
</div>
@endsection
