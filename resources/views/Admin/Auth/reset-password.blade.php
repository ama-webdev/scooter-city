@extends('layouts.admin-layout')
@section('auth-reset-active')
    active
@endsection
@section('style')
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h3 class="my-5 text-center">Reset Password</h3>
                    <div class="row">
                        <div class="col-6 offset-3">
                            @if (Session::has('success'))
                                <p class="text-center text-success">{{ Session::get('success') }}</p>
                            @elseif(Session::has('error'))
                                <p class="text-center text-danger">{{ Session::get('error') }}</p>
                            @endif
                            <form action="{{ route('admin.reset-password') }}" method="POST">
                                @csrf
                                <div class="form-group">
                                    <label for="">Email</label>
                                    <input type="password" name="email"
                                        class="form-control @error('email') is-invalid @enderror"
                                        value="{{ old('email') }}">
                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="">Password</label>
                                    <input type="password" name="password"
                                        class="form-control @error('password') is-invalid @enderror"
                                        value="{{ old('password') }}">
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
    </div>
@endsection
