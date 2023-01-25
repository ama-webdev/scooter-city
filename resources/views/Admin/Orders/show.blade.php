@extends('layouts.admin-layout')
@section('order-active')
    active
@endsection
@section('style')
    <style>
        img {
            width: 100px;
        }

        td {
            height: 50px;
            vertical-align: middle;
        }
    </style>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center gap-4">
                        <i class="fas fa-arrow-left back-btn"></i>
                        <h3 class="my-5"> #{{ $order->code }}</h3>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-3">
                            <table class="table">
                                <tr>
                                    <th>Status</th>
                                    <td class="text-uppercase">{{ $order->status }}</td>
                                </tr>
                                <tr>
                                    <th>NRC</th>
                                    <td>{{ $order->nrc }}</td>
                                </tr>
                                <tr>
                                    <th>Address</th>
                                    <td>{{ $order->address }}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-3">
                            <table class="table">
                                <tr>
                                    <th>Start Date</th>
                                    <td>{{ $order->start_date }}</td>
                                </tr>
                                <tr>
                                    <th>End Date</th>
                                    <td>{{ $order->end_date }}</td>
                                </tr>
                                <tr>
                                    <th>Duration</th>
                                    <td>{{ \App\Helper\DATE::duration($order->start_date, $order->end_date) }} days</td>
                                </tr>
                                <tr>
                                    <th>Remaining</th>
                                    <td>{{ \App\Helper\DATE::duration(now(), $order->end_date) }} days</td>
                                </tr>
                            </table>
                        </div>

                    </div>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Photo</th>
                                    <th>Name</th>
                                    <th>Price</th>
                                    <th>Qty</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $gtotal = 0;
                                    $duration = \App\Helper\DATE::duration($order->start_date, $order->end_date);
                                    foreach ($order->booking_details as $item) {
                                        $gtotal += $item->total;
                                    }
                                @endphp
                                @foreach ($order->booking_details as $item)
                                    <tr>
                                        <td>
                                            <img src="{{ $item->bike->photo }}" alt="">
                                        </td>
                                        <td>{{ $item->bike->name }}</td>
                                        <td>{{ number_format($item->bike->price) }}</td>
                                        <td>{{ $item->qty }}</td>
                                        <td>{{ number_format($item->total) }}</td>
                                    </tr>
                                @endforeach
                                <tr>
                                    <td colspan="4" class="fw-bold">Total</td>
                                    <td>{{ number_format($gtotal) }} Ks</td>
                                </tr>
                                <tr>
                                    <td colspan="4" class="fw-bold">Duration</td>
                                    <td>{{ $duration }} days
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="4" class="fw-bold">Grand Total</td>
                                    <td>{{ number_format($order->total) }} Ks
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    @if ($order->status == 'rent')
                        <form action="{{ route('admin.orders.return') }}" method="POST">
                            @csrf
                            <input type="hidden" name="id" value="{{ $order->id }}">
                            <button class="btn btn-danger">Return</button>
                        </form>
                    @endif

                    @if ($order->status == 'booking')
                        <form action="{{ route('admin.orders.rent') }}" method="POST">
                            @csrf
                            <input type="hidden" name="id" value="{{ $order->id }}">
                            <button class="btn btn-danger">Rent</button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
@endsection
