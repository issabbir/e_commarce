@extends('layouts.front')

@section('content')
<div class="container py-5">
    <div class="row" id="cart-container">
        @if(count($cart) > 0)
            <!-- Cart Items -->
            <div class="col-md-8">
                <div class="bg-white p-4 rounded-4 shadow-sm border mb-4">
                    <h4 class="fw-bold mb-4">Shopping Cart (<span id="cart-items-count">{{ count($cart) }}</span> Items)</h4>
                    
                    <div class="table-responsive">
                        <table class="table align-middle">
                            <thead class="text-muted small text-uppercase">
                                <tr>
                                    <th>Product</th>
                                    <th>Price</th>
                                    <th>Quantity</th>
                                    <th class="text-end">Subtotal</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody id="cart-body">
                                @php $total = 0; @endphp
                                @foreach($cart as $id => $details)
                                    @php $total += $details['price'] * $details['quantity']; @endphp
                                    <tr id="cart-item-{{ $id }}">
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <img src="{{ $details['image'] }}" class="rounded-3 border" width="60" alt="">
                                                <div class="ms-3">
                                                    <h6 class="mb-0 fw-bold text-truncate" style="max-width: 250px;">{{ $details['name'] }}</h6>
                                                    <span class="text-muted small">ID: #{{ $id }}</span>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="fw-bold">৳{{ number_format($details['price'], 2) }}</td>
                                        <td>
                                            <div class="input-group input-group-sm" style="width: 100px;">
                                                <input type="number" class="form-control text-center fw-bold qty-input" data-id="{{ $id }}" value="{{ $details['quantity'] }}" min="1">
                                            </div>
                                        </td>
                                        <td class="text-end fw-bold text-primary-theme subtotal-row-{{ $id }}">৳{{ number_format($details['price'] * $details['quantity'], 2) }}</td>
                                        <td class="text-end">
                                            <button class="btn btn-link text-danger p-0 delete-item" data-id="{{ $id }}"><i class="bi bi-trash3 fs-5"></i></button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Order Summary -->
            <div class="col-md-4">
                <div class="bg-white p-4 rounded-4 shadow-sm border sticky-top" style="top: 100px;">
                    <h5 class="fw-bold mb-4">Order Summary</h5>
                    <div class="d-flex justify-content-between mb-3 text-muted">
                        <span>Items Total</span>
                        <span class="grand-total">৳{{ number_format($total, 2) }}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-3 text-muted">
                        <span>Shipping Fee</span>
                        <span class="text-success">Free</span>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between mb-4">
                        <span class="fw-bold fs-5">Total</span>
                        <span class="fw-bold fs-5 text-primary-theme grand-total">৳{{ number_format($total, 2) }}</span>
                    </div>
                    <a href="{{ route('checkout') }}" class="btn btn-primary-theme w-100 rounded-pill py-3 fw-bold shadow-sm mb-3">Proceed to Checkout</a>
                    <a href="/" class="btn btn-outline-dark w-100 rounded-pill py-3 fw-bold">Continue Shopping</a>
                </div>
            </div>
        @else
            <!-- Empty Cart -->
            <div class="col-12 text-center py-5">
                <i class="bi bi-cart-x display-1 text-muted opacity-25"></i>
                <h4 class="mt-3 text-muted">Your cart is empty</h4>
                <a href="/" class="btn btn-primary-theme rounded-pill px-5 mt-3">Start Shopping</a>
            </div>
        @endif
    </div>
</div>

<script>
    function updateCartCountUI(count) {
        const badge = document.getElementById('cart-badge');
        const itemsCount = document.getElementById('cart-items-count');
        if (badge) badge.innerText = count;
        if (itemsCount) itemsCount.innerText = count;
    }

    function checkEmptyCart(count) {
        if (count === 0) {
            document.getElementById('cart-container').innerHTML = `
                <div class="col-12 text-center py-5">
                    <i class="bi bi-cart-x display-1 text-muted opacity-25"></i>
                    <h4 class="mt-3 text-muted">Your cart is empty</h4>
                    <a href="/" class="btn btn-primary-theme rounded-pill px-5 mt-3">Start Shopping</a>
                </div>
            `;
        }
    }

    // Handle Delete
    document.querySelectorAll('.delete-item').forEach(btn => {
        btn.addEventListener('click', function() {
            const id = this.getAttribute('data-id');
            if(confirm('Remove this item from cart?')) {
                fetch('/cart/remove', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({id: id})
                })
                .then(response => response.json())
                .then(data => {
                    if(data.status === 'success') {
                        const row = document.getElementById(`cart-item-${id}`);
                        if (row) row.remove();
                        
                        // Update grand totals
                        document.querySelectorAll('.grand-total').forEach(el => {
                            el.innerText = '৳' + data.total;
                        });

                        updateCartCountUI(data.cart_count);
                        checkEmptyCart(data.cart_count);
                        showToast('Item removed from cart!');
                    }
                });
            }
        });
    });

    // Handle Quantity Update
    document.querySelectorAll('.qty-input').forEach(input => {
        input.addEventListener('change', function() {
            const id = this.getAttribute('data-id');
            const qty = this.value;

            if (qty < 1) {
                this.value = 1;
                return;
            }

            fetch('/cart/update', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({id: id, quantity: qty})
            })
            .then(response => response.json())
            .then(data => {
                if(data.status === 'success') {
                    // Update subtotal for this row
                    document.querySelector(`.subtotal-row-${id}`).innerText = '৳' + data.subtotal;
                    // Update grand totals
                    document.querySelectorAll('.grand-total').forEach(el => {
                        el.innerText = '৳' + data.total;
                    });
                    showToast('Cart updated!');
                }
            });
        });
    });
</script>
@endsection
