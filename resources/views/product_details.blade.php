@extends('layouts.front')

@section('content')
<div class="container py-4">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/" class="text-decoration-none text-muted">Home</a></li>
            <li class="breadcrumb-item"><a href="/?category={{ $product->category_id }}" class="text-decoration-none text-muted">{{ $product->category->name }}</a></li>
            @if($product->subcategory)
                <li class="breadcrumb-item"><a href="/?category={{ $product->category_id }}&search={{ urlencode($product->subcategory->name) }}" class="text-decoration-none text-muted">{{ $product->subcategory->name }}</a></li>
            @endif
            <li class="breadcrumb-item active" aria-current="page">{{ $product->name }}</li>
        </ol>
    </nav>

    <div class="row g-5">
        <!-- Product Image -->
        <div class="col-md-5">
            <div class="product-gallery bg-white p-3 rounded-4 shadow-sm border overflow-hidden">
                <img src="{{ $product->image }}" class="img-fluid rounded-3 w-100" alt="{{ $product->name }}" style="transition: transform 0.5s ease;" onmouseover="this.style.transform='scale(1.1)'" onmouseout="this.style.transform='scale(1)'">
            </div>
        </div>

        <!-- Product Info -->
        <div class="col-md-7">
            <div class="bg-white p-4 rounded-4 shadow-sm border h-100">
                <h1 class="fw-bold mb-2" style="color: #1c1e21;">{{ $product->name }}</h1>
                
                <div class="d-flex align-items-center mb-3">
                    <div class="text-warning me-2">
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-half"></i>
                    </div>
                    <span class="text-muted small">({{ $product->reviews->count() }} Reviews)</span>
                    <span class="mx-3 text-muted">|</span>
                    <span class="text-success fw-bold small"><i class="bi bi-check-circle-fill me-1"></i>In Stock</span>
                </div>

                <div class="mb-4">
                    <span class="display-5 fw-bold text-primary-theme">৳{{ number_format($product->price, 2) }}</span>
                    <span class="text-muted text-decoration-line-through ms-3 fs-5">৳{{ number_format($product->price * 1.2, 2) }}</span>
                    <span class="badge bg-danger ms-2 rounded-pill">-20% OFF</span>
                </div>

                <p class="text-muted mb-4 lead" style="font-size: 16px;">
                    {{ $product->description }}
                </p>

                <div class="mb-4">
                    <label class="form-label fw-bold small text-uppercase text-muted">Quantity</label>
                    <div class="input-group" style="width: 140px;">
                        <button class="btn btn-outline-secondary rounded-start-pill px-3" type="button" id="btn-minus">-</button>
                        <input type="text" id="qty-input" class="form-control text-center fw-bold border-secondary" value="1" readonly>
                        <button class="btn btn-outline-secondary rounded-end-pill px-3" type="button" id="btn-plus">+</button>
                    </div>
                </div>

                <div class="d-grid gap-3 d-md-flex">
                    <button class="btn btn-lg btn-primary-theme px-5 rounded-pill fw-bold" onclick="addToCart({{ $product->id }}, document.getElementById('qty-input').value)">
                        <i class="bi bi-cart-plus-fill me-2"></i>Add to Cart
                    </button>
                    
                <script>
                    document.getElementById('btn-plus').addEventListener('click', function() {
                        let qty = document.getElementById('qty-input');
                        qty.value = parseInt(qty.value) + 1;
                    });
                    document.getElementById('btn-minus').addEventListener('click', function() {
                        let qty = document.getElementById('qty-input');
                        if(parseInt(qty.value) > 1) {
                            qty.value = parseInt(qty.value) - 1;
                        }
                    });
                </script>
                    <button class="btn btn-lg btn-outline-dark px-5 rounded-pill fw-bold">
                        <i class="bi bi-heart me-2"></i>Add to Wishlist
                    </button>
                </div>

                <hr class="my-4">

                <div class="d-flex align-items-center">
                    <div class="me-4 text-center">
                        <i class="bi bi-shield-check fs-2 text-primary-theme"></i>
                        <p class="small text-muted mb-0">Authentic</p>
                    </div>
                    <div class="me-4 text-center">
                        <i class="bi bi-arrow-counterclockwise fs-2 text-primary-theme"></i>
                        <p class="small text-muted mb-0">14 Days Easy Return</p>
                    </div>
                    <div class="text-center">
                        <i class="bi bi-truck fs-2 text-primary-theme"></i>
                        <p class="small text-muted mb-0">Free Delivery</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Reviews Section -->
    <div class="row mt-5">
        <div class="col-12">
            <div class="bg-white p-5 rounded-4 shadow-sm border">
                <h3 class="fw-bold mb-4">Product Reviews</h3>
                
                <div class="row g-5">
                    <!-- Statistics -->
                    <div class="col-md-4">
                        <div class="text-center p-4 border rounded-4 bg-light">
                            <h1 class="display-3 fw-bold mb-0">4.5</h1>
                            <div class="text-warning fs-3 mb-2">
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-half"></i>
                            </div>
                            <p class="text-muted fw-bold">Average Ratings</p>
                        </div>

                        <!-- Review Form -->
                        <div class="mt-5">
                            <h5 class="fw-bold mb-3">Write a Review</h5>
                            @auth
                                <form action="{{ route('product.review', $product->id) }}" method="POST">
                                    @csrf
                                    <div class="mb-3">
                                        <label class="form-label small fw-bold text-muted">Rating</label>
                                        <select name="rating" class="form-select rounded-3">
                                            <option value="5">⭐⭐⭐⭐⭐ (5/5)</option>
                                            <option value="4">⭐⭐⭐⭐ (4/5)</option>
                                            <option value="3">⭐⭐⭐ (3/5)</option>
                                            <option value="2">⭐⭐ (2/5)</option>
                                            <option value="1">⭐ (1/5)</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label small fw-bold text-muted">Your Comment</label>
                                        <textarea name="comment" class="form-control rounded-3" rows="4" placeholder="Share your experience..."></textarea>
                                    </div>
                                    <button type="submit" class="btn btn-primary-theme text-white w-100 rounded-pill py-2 fw-bold shadow-sm">Submit Review</button>
                                </form>
                            @else
                                <div class="alert alert-info rounded-4 p-4 border-0">
                                    <h6 class="fw-bold"><i class="bi bi-info-circle-fill me-2"></i>Want to review?</h6>
                                    <p class="small mb-3">Please login to your account to share your feedback about this product.</p>
                                    <a href="{{ route('login') }}" class="btn btn-outline-primary btn-sm rounded-pill px-4">Login Now</a>
                                </div>
                            @endauth
                        </div>
                    </div>

                    <!-- Reviews List -->
                    <div class="col-md-8">
                        @forelse($product->reviews->sortByDesc('created_at') as $review)
                            <div class="row mb-4">
                                <div class="col-auto">
                                    <img src="https://ui-avatars.com/api/?name={{ urlencode($review->user->name) }}&background=random" class="rounded-circle" width="50" alt="">
                                </div>
                                <div class="col border-bottom pb-4">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <h6 class="fw-bold mb-0">{{ $review->user->name }}</h6>
                                        <span class="text-muted small">{{ $review->created_at->diffForHumans() }}</span>
                                    </div>
                                    <div class="text-warning mb-2" style="font-size: 12px;">
                                        @for($i=1; $i<=5; $i++)
                                            <i class="bi bi-star{{ $i <= $review->rating ? '-fill' : '' }}"></i>
                                        @endfor
                                    </div>
                                    <p class="text-muted mb-0 small">{{ $review->comment }}</p>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-5">
                                <i class="bi bi-chat-dots-fill display-1 text-muted opacity-25"></i>
                                <h5 class="mt-3 text-muted">No reviews yet.</h5>
                                <p class="small text-muted">Be the first to review this product!</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Related Products -->
    <div class="mt-5 pt-4">
        <h4 class="fw-bold mb-4">Related Products</h4>
        <div class="row row-cols-2 row-cols-md-4 row-cols-lg-6 g-3">
            @foreach($relatedProducts as $related)
                <div class="col">
                    <a href="{{ route('product.show', $related->id) }}" class="product-card h-100 shadow-sm border-0">
                        <div class="product-img-wrapper">
                            <img src="{{ $related->image }}" class="product-img" alt="{{ $related->name }}">
                        </div>
                        <div class="p-3">
                            <div class="product-title mb-2 text-dark">{{ $related->name }}</div>
                            <div class="product-price text-primary-theme">৳{{ number_format($related->price, 2) }}</div>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
