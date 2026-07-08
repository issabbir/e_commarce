@extends('layouts.front')

@section('content')
<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4 border-bottom pb-3">
        <h3 class="fw-bold m-0"><i class="bi bi-lightning-fill text-warning me-2"></i>All Flash Deals</h3>
        <p class="text-muted mb-0">Hurry up! Grab them before they're gone</p>
    </div>
    
    <div class="row row-cols-2 row-cols-md-4 row-cols-lg-6 g-3">
         @foreach($products as $product)
            <div class="col">
                <a href="{{ route('product.show', $product->id) }}" class="product-card shadow-sm border-0 h-100 d-block text-decoration-none">
                     <div class="position-absolute m-2" style="z-index: 10;">
                        <span class="badge bg-danger rounded-pill px-3 shadow-sm">-{{ rand(30, 80) }}%</span>
                    </div>
                    <div class="product-img-wrapper" style="position: relative; overflow: hidden; border-radius: 8px 8px 0 0;">
                        @if($product->image)
                            <img src="{{ $product->image }}" class="product-img w-100 object-fit-cover" alt="{{ $product->name }}" style="height: 200px; transition: transform 0.3s ease;">
                        @else
                            <div class="d-flex align-items-center justify-content-center w-100" style="height: 200px; background: linear-gradient(45deg, #{{ substr(md5($product->id), 0, 6) }}, #{{ substr(md5($product->name), 0, 6) }}); transition: transform 0.3s ease;">
                                <span class="text-white fs-1 fw-bold">{{ substr($product->name, 0, 1) }}</span>
                            </div>
                        @endif
                    </div>
                    <div class="p-3 text-center bg-white rounded-bottom">
                        <div class="product-title mb-2 text-dark text-truncate">{{ $product->name }}</div>
                        <div class="product-price text-primary-theme fw-bold fs-5 mb-1">৳{{ number_format($product->price * 0.5, 2) }}</div>
                        <div class="text-muted small text-decoration-line-through">৳{{ number_format($product->price, 2) }}</div>
                        
                        <div class="progress mt-3" style="height: 6px;">
                            @php 
                                $soldQty = $product->order_items_sum_quantity ?? 0;
                                $totalStock = $product->stock + $soldQty;
                                $percent = $totalStock > 0 ? min(round(($soldQty / $totalStock) * 100), 100) : 0;
                            @endphp
                            <div class="progress-bar bg-warning progress-bar-striped progress-bar-animated" role="progressbar" style="width: {{ $percent }}%" aria-valuenow="{{ $percent }}" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                        <div class="text-muted small mt-1 text-start"><i class="bi bi-fire text-danger"></i> {{ $soldQty }} Sold</div>
                    </div>
                </a>
            </div>
         @endforeach
    </div>

    <!-- Pagination -->
    <div class="d-flex justify-content-center mt-5">
        {{ $products->links() }}
    </div>
</div>

<style>
    .product-card {
        transition: all 0.3s ease;
        border-radius: 8px;
    }
    .product-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important;
    }
    .product-card:hover .product-img-wrapper img,
    .product-card:hover .product-img-wrapper > div {
        transform: scale(1.05);
    }
</style>
@endsection
