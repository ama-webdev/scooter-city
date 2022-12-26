@extends('layouts.user-layout')
@section('style')
@endsection
@section('content')
    @php
        $status = app('request')->input('status');
    @endphp
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="table-responsive">
                    <div class="d-flex align-items-center justify-content-between">
                        <h3 class="my-5">Your Order List</h3>
                        <div class="form-group">
                            <select class="form-select" class="status" id="status-filter">
                                <option value="">Select Status</option>
                                <option value="booking" @if ($status == 'booking') selected @endif>Booking</option>
                                <option value="return" @if ($status == 'return') selected @endif>Return</option>
                            </select>
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
                                    <td><a href="{{ route('user.order-detail', $order->id) }}">{{ $order->code }}</a></td>
                                    <td>{{ $order->status }}</td>
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

                history.pushState(null, '',
                    `?status=${status}`
                );
                window.location.reload();
            }
            $('#status-filter').change(function(e) {
                e.preventDefault();
                filter();
            });
        });
    </script>
@endsection
