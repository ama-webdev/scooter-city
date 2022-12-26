@extends('layouts.admin-layout')
@section('cat-active')
    active
@endsection
@section('style')
    <style>
        .table thead th {
            padding: .5rem;
        }

        form {
            max-width: 500px;
            display: block;
            margin: 0 auto;
            border: 1px solid #ddd;
            padding: 1rem 2rem;
            border-radius: 1rem;
        }
    </style>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex align-item-center justify-content-between">
                    <h5>Create New Category</h5>
                    <a href="" class="btn btn-sm btn-primary d-flex gap-2 px-3 back-btn">
                        <i class="fas fa-undo "></i>
                        Back
                    </a>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.categories.store') }}" method="POST">
                        @csrf
                        <h5 class="my-3 text-center">Complete the form</h5>
                        <div class="form-group">
                            <label for="">Name</label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                                value="{{ old('name') }}">
                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <button class="btn btn-primary">Create</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection
