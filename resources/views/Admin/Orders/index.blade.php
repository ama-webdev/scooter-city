@extends('layouts.admin-layout')
@section('order-active')
    active
@endsection
@section('style')
    <style>
        .table thead th {
            padding: .5rem;
        }
    </style>
@endsection

@section('content')
    @php
        $status = app('request')->input('status');
        $code = app('request')->input('code');
    @endphp
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <h3 class="mt-5"> Order List</h3>
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
                                                class="text-uppercase text-sm text-white p-1 @if ($order->status == 'booking') bg-warning @elseif($order->status == 'rent') bg-success
                                                 @elseif($order->status == 'cancel') bg-danger
                                                @elseif($order->status == 'return') bg-info @endif">{{ $order->status }}</span>


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
