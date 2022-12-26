@extends('layouts.admin-layout')
@section('bike-active')
    active
@endsection
@section('style')
    <style>
        .table thead th {
            padding: .5rem;
        }

        img {
            width: 50px;
        }
    </style>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex align-item-center justify-content-between">
                    <h5>Bikes</h5>
                    <a href="{{ route('admin.bikes.create') }}" class="btn btn-sm btn-primary d-flex gap-2 px-3">
                        <i class="fas fa-plus "></i>
                        New Bike
                    </a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Photo</th>
                                    <th>Name</th>
                                    <th>Qty</th>
                                    <th>Price Per day (MMK)</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($bikes as $bike)
                                    <tr>
                                        <td><img src="{{ $bike->photo }}" alt=""></td>
                                        <td>{{ $bike->name }}</td>
                                        <td>{{ $bike->qty }}</td>
                                        <td>{{ number_format($bike->price) }}</td>
                                        <td>
                                            <a href="{{ route('admin.bikes.edit', $bike->id) }}" class="text-warning"><i
                                                    class="far fa-edit"></i></a>
                                            &nbsp;
                                            <a href="" class="text-danger delete-btn"><i
                                                    class="far fa-trash"></i></a>
                                            <form action="{{ route('admin.bikes.destroy', $bike->id) }}" method="POST"
                                                class="d-none delete-form">
                                                @csrf
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{ $bikes->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        $(document).ready(function() {
            $(".delete-btn").click(function(e) {
                e.preventDefault();
                var parent = $(this).parent();
                $result = confirm('Are you sure?');
                if ($result) {
                    $(".delete-form", parent).submit();
                }
            })
        });
    </script>
@endsection
