@extends('layouts.user-layout')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-6 offset-3">
                <div class="card my-5">
                    <div class="card-body">
                        <h3 class="my-3 text-center">Change Password</h3>
                        @if (Session::has('success'))
                            <p class="text-center text-success">{{ Session::get('success') }}</p>
                        @elseif(Session::has('error'))
                            <p class="text-center text-danger">{{ Session::get('error') }}</p>
                        @endif
                        <form action="{{ route('user.change-password') }}" method="POST">
                            @csrf
                            <div class="form-group mb-3">
                                <label for="">Old Password</label>
                                <input type="password" name="old_password"
                                    class="form-control @error('old_password') is-invalid @enderror"
                                    value="{{ old('old_password') }}">
                                @error('old_password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group mb-3">
                                <label for="">New Password</label>
                                <input type="password" name="new_password"
                                    class="form-control @error('new_password') is-invalid @enderror"
                                    value="{{ old('new_password') }}">
                                @error('new_password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group mb-3">
                                <label for="">Confirm Password</label>
                                <input type="password" name="confirm_password"
                                    class="form-control @error('confirm_password') is-invalid @enderror"
                                    value="{{ old('confirm_password') }}">
                                @error('confirm_password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <button class="btn btn-primary">Change</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
