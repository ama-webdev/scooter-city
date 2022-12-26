@extends('layouts.user-layout')
@section('style')
    <style>
        .form-group {
            margin-bottom: 1rem;
        }

        label {
            margin-bottom: .5rem;
            font-size: .9rem;
        }

        .col-md-3 {
            border-right: 1px solid #ddd;
            padding-top: 1rem;
            height: calc(100vh - 56px);
            overflow: auto;
        }

        .col-md-9 {
            padding-top: 1rem;
            height: calc(100vh - 56px);
            overflow: auto;
        }

        .bikes {
            width: 100%;
            height: calc(100% - 40px);
            overflow-y: auto;
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 1rem;
            padding-bottom: 1rem;
            grid-auto-rows: min-content;
        }

        @media(max-width:1100px) {
            .bikes {
                grid-template-columns: repeat(3, 1fr);
            }
        }

        @media(max-width:900px) {
            .bikes {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        .bikes::-webkit-scrollbar {
            display: none;
        }

        .bikes .bike {
            border: 1px solid #ddd;
            padding: 1rem;
            overflow: hidden;
            border-radius: 3px;
        }

        .bike img {
            width: 100px;
            height: 100px;
            display: block;
            margin: 0 auto;
            transition: .3s;
        }

        .bike img:hover {
            transform: scale(1.1)
        }

        .bike .title {
            text-decoration: none;
            font-weight: 500;
            color: #333;
        }

        .bike .brand {
            margin: 0;
            padding: 0;
            font-size: .9rem;
        }

        .bike .price {
            margin: 0;
        }

        .bike .footer {
            padding-top: 1rem;
        }

        .add-to-cart-btn {
            border-left-color: transparent;
        }

        .btn-group a {
            font-size: .8rem;
            font-weight: 500;
        }
    </style>
@endsection
@section('content')
    @php
        $cat = app('request')->input('cat');
        $brand_id = app('request')->input('brand');
        $model = app('request')->input('model');
        $min_price = app('request')->input('min_price');
        $max_price = app('request')->input('max_price');
    @endphp
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-3 px-4">
                <h5 class="mb-3">Filters</h5>
                <div class="form-group">
                    <label for="">Model</label>
                    <input type="text" class="form-control form-control-sm" id="model" value="{{ $model ?? '' }}">
                </div>
                <div class="form-group">
                    <label for="">Categories</label>
                    <select class="form-select form-select-sm" id="cat">
                        <option value="">Select Category</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" @if ($category->id == $cat) selected @endif>
                                {{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="">Brands</label>
                    <select class="form-select form-select-sm" id="brand">
                        <option value="">Select Brand</option>
                        @foreach ($brands as $brand)
                            <option value="{{ $brand->id }}" @if ($brand->id == $brand_id) selected @endif>
                                {{ $brand->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="">Price (MMK)</label>
                    <div class="row">
                        <div class="col-6 pe-1">
                            <div class="input-group input-group-sm mb-3">
                                <span class="input-group-text" id="inputGroup-sizing-sm">Min</span>
                                <input type="number" class="form-control" aria-label="Sizing example input" id="min_price"
                                    aria-describedby="inputGroup-sizing-sm" value="{{ $min_price ?? '' }}">
                            </div>
                        </div>
                        <div class="col-6 ps-1">
                            <div class="input-group input-group-sm mb-3">
                                <span class="input-group-text" id="inputGroup-sizing-sm">Max</span>
                                <input type="number" class="form-control" aria-label="Sizing example input" id="max_price"
                                    aria-describedby="inputGroup-sizing-sm" value="{{ $max_price ?? '' }}">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <button class="btn btn-sm btn-primary d-block w-100 mb-3" id="search-btn">Search</button>
                    <button class="btn btn-sm btn-danger d-block w-100" id="clear-btn">Clear Filter</button>
                </div>
            </div>
            <div class="col-md-9">
                <h5 class="mb-3">Bikes</h5>
                <div class="bikes">
                    @foreach ($bikes as $bike)
                        <div class="bike">
                            <div class="header"></div>
                            <div class="body">
                                <a href="{{ route('user.bike-detail', $bike->id) }}">
                                    <img src="{{ $bike->photo }}" alt="">
                                </a>
                                <a href="{{ route('user.bike-detail', $bike->id) }}" class="title">{{ $bike->name }}
                                    <span class="text-danger">({{ $bike->qty }})
                                </a>
                                <p class="brand">{{ $bike->brand->name }}</p>
                                <p class="price"><span
                                        class="fw-bold text-danger">{{ number_format($bike->price) }}</span> MMK per
                                    day</p>
                            </div>
                            <div class="footer">
                                <div class="btn-group">
                                    <a href="{{ route('user.bike-detail', $bike->id) }}" class="btn btn-sm btn-danger">View
                                        Detail</a>
                                    <a href="" class="btn btn-sm btn-outline-secondary add-to-cart-btn"
                                        data-id="{{ $bike->id }}" data-price="{{ $bike->price }}"
                                        data-name="{{ $bike->name }}" data-photo="{{ $bike->photo }}">
                                        Add To Cart
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                {{ $bikes->appends($_GET)->links() }}
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        $(document).ready(function() {

            function filter() {
                var model = $('#model').val();
                var cat = $('#cat').val();
                var brand = $('#brand').val();
                var min_price = $('#min_price').val();
                var max_price = $('#max_price').val();

                history.pushState(null, '',
                    `?cat=${cat}&model=${model}&brand=${brand}&min_price=${min_price}&max_price=${max_price}`
                );
                window.location.reload();
            }
            $('#model').keyup(function(e) {
                if (e.which == 13) {
                    filter()
                }
            });
            $('#cat').change(function(e) {
                filter()
            });
            $('#brand').change(function(e) {
                filter()
            });
            $('#min_price').keyup(function(e) {
                if (e.which == 13) {
                    filter()
                }
            });
            $('#max_price').keyup(function(e) {
                if (e.which == 13) {
                    filter()
                }
            });
            $('#search-btn').click(function(e) {
                filter()
            });
            $('#clear-btn').click(function(e) {
                history.pushState(null, '', 'bikes');
                window.location.reload();
            });


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
