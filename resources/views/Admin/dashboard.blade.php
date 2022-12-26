@extends('layouts.admin-layout')
@section('dash-active')
    active
@endsection
@section('content')
    <div class="row">
        <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
            <a href="{{ route('admin.orders.index') }}" class="card">
                <div class="card-body p-3">
                    <div class="row">
                        <div class="col-8">
                            <div class="numbers">
                                <p class="text-sm mb-0 text-uppercase font-weight-bold">Orders</p>
                                <h5 class="font-weight-bolder">
                                    {{ $order_count }}
                                </h5>
                            </div>
                        </div>
                        <div class="col-4 text-end">
                            <div class="icon icon-shape bg-gradient-primary shadow-primary text-center rounded-circle">
                                <i class="fas fa-cubes text-lg opacity-10" aria-hidden="true"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
            <a href="{{ route('admin.bikes.index') }}" class="card">
                <div class="card-body p-3">
                    <div class="row">
                        <div class="col-8">
                            <div class="numbers">
                                <p class="text-sm mb-0 text-uppercase font-weight-bold">Bikes</p>
                                <h5 class="font-weight-bolder">
                                    {{ $bike_count }}
                                </h5>
                            </div>
                        </div>
                        <div class="col-4 text-end">
                            <div class="icon icon-shape bg-gradient-danger shadow-danger text-center rounded-circle">
                                <i class="fas fa-motorcycle text-lg opacity-10" aria-hidden="true"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
            <a href="{{ route('admin.brands.index') }}" class="card">
                <div class="card-body p-3">
                    <div class="row">
                        <div class="col-8">
                            <div class="numbers">
                                <p class="text-sm mb-0 text-uppercase font-weight-bold"> Brands</p>
                                <h5 class="font-weight-bolder">
                                    {{ $brand_count }}
                                </h5>
                            </div>
                        </div>
                        <div class="col-4 text-end">
                            <div class="icon icon-shape bg-gradient-success shadow-success text-center rounded-circle">
                                <i class="fas fa-boxes text-lg opacity-10" aria-hidden="true"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-xl-3 col-sm-6">
            <a href="{{ route('admin.users.index') }}" class="card">
                <div class="card-body p-3">
                    <div class="row">
                        <div class="col-8">
                            <div class="numbers">
                                <p class="text-sm mb-0 text-uppercase font-weight-bold">Users</p>
                                <h5 class="font-weight-bolder">
                                    {{ $user_count }}
                                </h5>

                            </div>
                        </div>
                        <div class="col-4 text-end">
                            <div class="icon icon-shape bg-gradient-warning shadow-warning text-center rounded-circle">
                                <i class="fas fa-user-ninja text-lg opacity-10" aria-hidden="true"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
    </div>
    @php
        $status = app('request')->input('status');
        $code = app('request')->input('code');
    @endphp
    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <h3 class="mt-3"> Order List</h3>
                        <div class="row my-3">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="code">Code</label>
                                    <input type="text" id="code" class="form-control" value="{{ $code ?? '' }}">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="status">Status</label>
                                    <select class="form-select" class="status" id="status-filter">
                                        <option value="">Select Status</option>
                                        <option value="booking" @if ($status == 'booking') selected @endif>Booking
                                        </option>
                                        <option value="return" @if ($status == 'return') selected @endif>Return
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3 pt-2">
                                <button class="btn btn-primary mt-4 search-btn">Search</button>
                                <button class="btn btn-danger mt-4 clear-filter">Clear</button>
                            </div>
                        </div>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Code</th>
                                    <th>Status</th>
                                    <th>Qty</th>
                                    <th>Total</th>
                                    <th>Duration</th>
                                    <th>Remain</th>
                                    <th>Start Date</th>
                                    <th>End Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($orders as $order)
                                    @php
                                        $duration = \App\Helper\DATE::duration($order->start_date, $order->end_date);
                                        $remain = \App\Helper\DATE::duration(now(), $order->end_date);
                                    @endphp
                                    <tr>
                                        <td><a href="{{ route('admin.orders.show', $order->id) }}"
                                                class="text-primary">{{ $order->code }}</a>
                                        </td>
                                        <td>
                                            <span
                                                class="text-uppercase text-sm text-white p-1 @if ($order->status == 'booking') bg-danger @else bg-success @endif">{{ $order->status }}</span>
                                        </td>
                                        <td>{{ $order->qty }}</td>
                                        <td class="text-center">{{ number_format($order->total) }}Ks</td>
                                        <td>
                                            {{ $duration }} days
                                        </td>
                                        @if ($remain > 0 && $order->status == 'booking')
                                            <td class="text-success">{{ $remain }} days</td>
                                        @elseif($remain == 0 && $order->status == 'booking')
                                            <td class="text-warning">0 days</td>
                                        @elseif($remain < 0 && $order->status == 'booking')
                                            <td class="text-danger">{{ $remain }} days</td>
                                        @else
                                            <td class="">-</td>
                                        @endif
                                        <td>{{ $order->start_date }}</td>
                                        <td>{{ $order->end_date }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    {{ $orders->appends($_GET)->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        $(document).ready(function() {
            function filter() {
                var status = $('#status-filter').val();
                var code = $('#code').val();


                history.pushState(null, '',
                    `?status=${status}&code=${code}`
                );
                window.location.reload();
            }
            $('#status-filter').change(function(e) {
                e.preventDefault();
                filter();
            });
            $('#code').keyup(function(e) {
                if (e.which == 13) {
                    filter()
                }
            });
            $('.search-btn').click(function(e) {
                e.preventDefault();
                filter()
            });
            $('.clear-filter').click(function(e) {
                history.pushState(null, '', 'orders');
                window.location.reload();
            });
        });
    </script>
@endsection
