@extends('layouts.admin-layout')
@section('auth-change-active')
    active
@endsection
@section('style')
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h3 class="my-5 text-center">Change Password</h3>
                    <div class="row">
                        <div class="col-6 offset-3">
                            @if (Session::has('success'))
                                <p class="text-center text-success">{{ Session::get('success') }}</p>
                            @elseif(Session::has('error'))
                                <p class="text-center text-danger">{{ Session::get('error') }}</p>
                            @endif
                            <form action="{{ route('admin.change-password') }}" method="POST">
                                @csrf
                                <div class="form-group">
                                    <label for="">Old Password</label>
                                    <input type="password" name="old_password"
                                        class="form-control password @error('old_password') is-invalid @enderror"
                                        value="{{ old('old_password') }}">
                                    @error('old_password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="">New Password</label>
                                    <input type="password" name="new_password"
                                        class="form-control password @error('new_password') is-invalid @enderror"
                                        value="{{ old('new_password') }}">
                                    @error('new_password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="">Confirm Password</label>
                                    <input type="password" name="confirm_password"
                                        class="form-control password @error('confirm_password') is-invalid @enderror"
                                        value="{{ old('confirm_password') }}">
                                    @error('confirm_password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="show_hide_password">
                                        <label class="form-check-label" for="show_hide_password">
                                            Show password
                                        </label>
                                    </div>
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
