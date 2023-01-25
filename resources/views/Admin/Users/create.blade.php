@extends('layouts.admin-layout')
@section('user-active')
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
                <h5>Create New User</h5>
                <a href="" class="btn btn-sm btn-primary d-flex gap-2 px-3 back-btn">
                    <i class="fas fa-undo "></i>
                    Back
                </a>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.users.store') }}" method="POST">
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
                        <label for="">Email</label>
                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                            value="{{ old('email') }}">
                        @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="">Phone No</label>
                        <input type="text" name="phone_no" class="form-control @error('phone_no') is-invalid @enderror"
                            value="{{ old('phone_no') }}">
                        @error('phone_no')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="">Address</label>
                        <textarea name="address"
                            class="form-control @error('address') is-invalid @enderror">{{ old('address') }}</textarea>
                        @error('address')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="">Gender</label>
                        <select name="gender" class="form-select @error('gender') is-invalid @enderror">
                            <option value="">Choose Gender</option>
                            <option value="male" @if (old('gender')=='male' ) selected @endif>Male</option>
                            <option value="female" @if (old('gender')=='female' ) selected @endif>Female</option>
                        </select>
                        @error('gender')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="">Password</label>
                        <input type="password" name="password"
                            class="form-control @error('password') is-invalid @enderror" value="{{ old('password') }}">
                        @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="">Confirm Password</label>
                        <input type="password" name="confirm_password"
                            class="form-control @error('confirm_password') is-invalid @enderror"
                            value="{{ old('confirm-password') }}">
                        @error('confirm_password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="">Role</label>
                        <select name="role" id="" class="form-select @error('role') is-invalid @enderror">
                            <option value="">Select Role</option>
                            <!-- <option value="user" @if (old('role') == 'user') selected @endif>User</option> -->
                            <option value="vendor" @if (old('role')=='vendor' ) selected @endif>Vendor</option>
                            <option value="admin" @if (old('role')=='admin' ) selected @endif>Admin</option>
                        </select>
                        @error('role')
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