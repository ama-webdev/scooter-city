@extends('layouts.admin-layout')
@section('cat-active')
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
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex align-item-center justify-content-between">
                    <h5>Categories</h5>
                    <a href="{{ route('admin.categories.create') }}" class="btn btn-sm btn-primary d-flex gap-2 px-3">
                        <i class="fas fa-plus "></i>
                        New Category
                    </a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($categories as $category)
                                    <tr>
                                        <td>{{ $category->name }}</td>
                                        <td>
                                            <a href="{{ route('admin.categories.edit', $category->id) }}"
                                                class="text-warning"><i class="far fa-edit"></i></a>
                                            &nbsp;
                                            <a href="" class="text-danger delete-btn"><i
                                                    class="far fa-trash"></i></a>
                                            <form action="{{ route('admin.categories.destroy', $category->id) }}"
                                                method="POST" class="d-none delete-form">
                                                @csrf
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{ $categories->links() }}
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
