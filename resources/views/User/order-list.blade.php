@extends('layouts.user-layout')
@section('style')
@endsection
@section('content')
    @php
        $status = app('request')->input('status');
        $success = app('request')->input('success');
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
                    @if ($success)
                        <p class="text-success text-center">Successfully ordered.</p>
                    @endif
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
                                <th>Actions</th>
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
                                    @if ($order->status == 'booking')
                                        <td><button class="btn btn-danger btn-sm cancel-btn"
                                                data-id="{{ $order->id }}">Cancel</button></td>
                                    @else
                                        <td><button class="btn btn-danger btn-sm disabled" disabled>Cancel</button></td>
                                    @endif
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
            $('.cancel-btn').click(function(e) {
                e.preventDefault();
                var result = confirm('Are You Sure?')
                if (result) {
                    var data = {
                        id: $(this).data('id')
                    }
                    $.ajax({
                        type: "post",
                        url: "cancel-order",
                        data: data,
                        dataType: "json",
                        success: function(response) {
                            window.location.reload()
                        }
                    });
                }
            });
        });
    </script>
@endsection
