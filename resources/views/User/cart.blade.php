@extends('layouts.user-layout')
@section('style')
    <style>
        img {
            width: 50px;
            height: 50px;
        }

        td {
            height: 50px;
            vertical-align: middle;
        }

        tr:last-child {
            border-color: transparent;
        }

        .qty-group {
            display: flex;
            border: 1px solid #ddd;
            padding: 5px 0;
        }

        .qty-group input {
            text-align: center;
            background: none;
            outline: none;
            border: none;
            width: 50px;
        }

        .qty-group button {
            background: none;
            border: none;
            outline: none;
            padding: 0 10px;
            transition: .3s;
            color: #ddd;
        }

        .qty-group button:hover {
            color: #333;
        }

        .remove-btn {
            cursor: pointer;
        }
    </style>
@endsection
@section('content')
    <div class="container">
        <div class="row py-5">
            <div class="col-md-8">
                <h5 class="text-muted text-center mt-3 success"></h5>
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <h5>Your Cart</h5>
                        <div>
                            <span class="fw-bold cart-count">0</span> <span class="fw-normal">items</span>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Photo</th>
                                        <th>Name</th>
                                        <th>Price (MMK)</th>
                                        <th class="text-center">Qty</th>
                                        <th>Total (MMK)</th>
                                        <th>Remove</th>
                                    </tr>
                                </thead>
                                <tbody class="cart-table-body">

                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="d-flex justify-content-between align-items-center">
                            <a href="{{ route('user.bikes') }}" class="text-decoration-none"><i
                                    class="fas fa-arrow-left"></i> Back to rent</a>
                            <button class="btn btn-danger btn-sm clear-cart"><i class="fas fa-times"></i> Clear
                                Cart</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <h5>Summary</h5>
                        <h5 class="grand_total"></h5>
                    </div>
                    <div class="card-body">
                        <ul class="cart-error"></ul>
                        <form action="">
                            @csrf
                            <div class="form-group mb-3">
                                <label for="">End Date (<span id="duration"></span> days)</label>
                                <input type="date" name="end_date" class="form-control end_date">
                            </div>
                            <div class="form-group mb-3">
                                <label for="">Nrc No</label>
                                <input type="text" name="nrc" class="form-control nrc"></input>
                            </div>
                            <div class="form-group mb-3">
                                <label for="">Address</label>
                                <textarea name="address" class="form-control address"></textarea>
                            </div>
                            <div class="form-group mb-3">
                                <label for="">Remark (optional)</label>
                                <textarea name="remark" class="form-control remark"></textarea>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-sm btn-primary order-btn ">Order
                                    <span class="spinner-border d-none spinner-border-sm order-loading" role="status"
                                        aria-hidden="true"></span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        $(document).ready(function() {
            showCart()

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

            function showCart() {
                var cart = JSON.parse(localStorage.getItem('cart'));
                var total = 0;
                var html = ``;
                var empty = `
                    <tr>
                        <td colspan="6" class="text-center">No Data</td>
                    </tr>
                `;

                if (cart && cart.length > 0) {
                    $.each(cart, function(i, v) {
                        total += v.qty * v.price;
                        html += `
                        <tr>
                            <td><img src="${v.photo}" alt=""></td>
                            <td>${v.name}</td>
                            <td>${v.price}</td>
                            <td>
                                <div class="qty-group">
                                    <button class="minus-btn" data-row_id="${i}"><i class="fas fa-minus"></i></button>
                                    <input type="text" class="" disabled value="${v.qty}">
                                    <button class="plus-btn" data-row_id="${i}"><i class="fas fa-plus"></i></button>
                                </div>
                            </td>
                            <td>${v.qty * v.price}</td>
                            <td class="text-center">
                                <i class="fas fa-trash text-danger remove-btn" data-row_id="${i}" ></i>
                            </td>
                        </tr>
                        `;
                    })
                    html += `
                    <tr class="fw-bold">
                        <td colspan="4">Total ( per day )</td>
                        <td id="grand_total">${total}</td>
                    </tr>
                    `;
                    $('.cart-table-body').html(html);
                    var end_date = $(".end_date").val();
                    if (!end_date) {
                        end_date = new Date()
                    }
                    grand_total(end_date)
                } else {
                    $('.cart-table-body').html(empty);
                    $(".order-btn").addClass('d-none');
                }
            }

            function removeItem(id) {
                var result = confirm('Are You Sure?');
                if (result) {
                    var cart = JSON.parse(localStorage.getItem('cart'))
                    cart.splice(id, 1);
                    localStorage.setItem('cart', JSON.stringify(cart));
                    showCart();
                    cartCount()
                }
            }

            function changeQty(id, event) {
                var cart = JSON.parse(localStorage.getItem('cart'))
                if (event == 'plus') {
                    cart[id].qty += 1;
                } else {
                    if (cart[id].qty == 1) {
                        var result = confirm('Are you sure ?');
                        if (result) {
                            cart.splice(id, 1);
                        }
                    } else {
                        cart[id].qty -= 1;
                    }
                }
                localStorage.setItem('cart', JSON.stringify(cart));
                showCart();
                cartCount()
            }

            function order(data, remark, end_date, nrc, address) {
                var data = {
                    'cart': JSON.stringify(data),
                    'remark': remark,
                    'end_date': end_date,
                    'nrc': nrc,
                    'address': address,
                }
                $.ajax({
                    type: "post",
                    url: "/order",
                    data: data,
                    dataType: "json",
                    beforeSend: function() {
                        $('.order-btn').addClass('disabled');
                        $('.order-loading').removeClass('d-none');
                    },
                    complete: function() {
                        $('.order-btn').removeClass('disabled');
                        $('.order-loading').addClass('d-none');
                    },
                    success: function(response) {
                        localStorage.removeItem('cart');
                        showCart();
                        cartCount()
                        $('.success').html(
                            `Successfully ordered. Your Code is <span class="rental_code text-success">${response.data.code}</span>. See <a href="/order-list">Order List</a>`
                        );
                        var end_date = $('.end_date').val('');
                        var nrc = $('.nrc').val('');
                        var address = $('.address').val('');
                        var remark = $('.remark').val('');
                        $(".cart-error").html(``);
                        $('.grand_total').text('');
                        $('#duration').text('0');
                        window.location.href = "order-list?success=true";
                    },
                    error: function(response) {
                        var html = '';
                        var errors = response.responseJSON.errors
                        errors.forEach(e => {
                            html += `<li class="text-danger">${e}</li>`;
                        });
                        $(".cart-error").html(html);
                    }
                });
            }

            function days_between(end_date) {

                const date1 = new Date();
                const date2 = new Date(end_date);
                const diffTime = Math.abs(date2 - date1);
                const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
                $('#duration').text(diffDays)
                return diffDays;

            }

            // remove btn click
            $('.cart-table-body').on('click', '.remove-btn', function() {
                var row_id = $(this).data('row_id')
                removeItem(row_id)
            });
            // plus
            $('.cart-table-body').on('click', '.plus-btn', function() {
                var row_id = $(this).data('row_id');
                changeQty(row_id, 'plus');
            });
            // minus
            $('.cart-table-body').on('click', '.minus-btn', function() {
                var row_id = $(this).data('row_id');
                changeQty(row_id, 'minus');
            });
            // clear cart
            $('.clear-cart').click(function(e) {
                e.preventDefault();
                var result = confirm('Are you sure?');
                if (result) {
                    localStorage.removeItem('cart');
                    showCart();
                    cartCount()
                }
            });
            // order
            $('.order-btn').click(function(e) {
                e.preventDefault();
                var cart = JSON.parse(localStorage.getItem('cart'));
                var end_date = $('.end_date').val();
                var nrc = $('.nrc').val();
                var address = $('.address').val();
                var remark = $('.remark').val();

                order(cart, remark, end_date, nrc, address)
            });

            function grand_total(end_date) {
                var total = $('#grand_total').text();
                var days = days_between(end_date);
                var grand_total = total * days;
                $('.grand_total').text(grand_total + ' Ks for ' + days + ' days');
            }

            $('.end_date').change(function(e) {
                e.preventDefault();
                var end_date = $(this).val();
                if (!end_date) {
                    end_date = new Date()
                }
                grand_total(end_date)
            });
        });
    </script>
@endsection
