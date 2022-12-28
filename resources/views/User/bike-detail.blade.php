@extends('layouts.user-layout')
@section('style')
    <style>
        img {
            width: 100%;
        }
    </style>
@endsection
@section('content')
    <div class="container pb-5">
        <div class="row">
            <div class="col-12">
                <h5 class="my-5"><i class="fas fa-arrow-left back-btn"></i> Bike Detail</h5>
                <div class="row">
                    <div class="col-md-3">
                        <img src="{{ asset($bike->photo) }}" alt="">
                    </div>
                    <div class="col-md-9">
                        <h5>{{ $bike->name }} <span class="text-danger">({{ $bike->qty }})</span> </h5>
                        <p class="fw-bold">{{ $bike->brand->name }}</p>
                        <p><span class="text-danger fw-bold">{{ number_format($bike->price) }}</span> MMK per day.</p>
                        <p>{!! $bike->desc !!}</p>
                        <div>
                            <div class="btn-group">
                                <a href="" class="btn btn-sm btn-outline-secondary add-to-cart-btn"
                                    data-id="{{ $bike->id }}" data-price="{{ $bike->price }}"
                                    data-name="{{ $bike->name }}" data-photo="{{ $bike->photo }}">
                                    Add To Cart
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        $(document).ready(function() {
            // add to cart
            function addToCart(data) {
                var cart = JSON.parse(localStorage.getItem('cart'));
                var flag = true;

                if (cart) {
                    var has_product = cart.findIndex(i => i.id == data['id']);

                    if (has_product >= 0) {
                        cart[has_product].qty++;
                    } else {
                        cart.push(data);
                    }
                    localStorage.setItem('cart', JSON.stringify(cart));
                } else {
                    localStorage.setItem('cart', JSON.stringify([data]))
                }
            }

            $('.add-to-cart-btn').click(function(e) {
                e.preventDefault();
                var id = $(this).data('id')
                var photo = $(this).data('photo')
                var name = $(this).data('name')
                var price = $(this).data('price');

                var data = {
                    'id': id,
                    'name': name,
                    'photo': photo,
                    'price': price,
                    'qty': 1
                };
                addToCart(data);
                cartCount()
            });

            // count
            function cartCount() {

                var cart = JSON.parse(localStorage.getItem('cart'));
                if (cart && cart.length > 0) {
                    var sum = cart.reduce((a, b) => {
                        return a + b.qty
                    }, 0)
                    $('.cart-count').text(sum);
                } else {
                    $('.cart-count').text(0);
                }
            }
        });
    </script>
@endsection
