@extends('layouts.user-layout')
@section('style')
    <style>
        .choose-wrapper {
            width: 100%;
            height: 80vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .choose-wrapper>div {
            width: 100%;
        }
    </style>
@endsection
@section('content')
    <div class="choose-wrapper">
        <div class="">
            <h1 class="text-center">Who Are You?</h1>
            <div class="row justify-content-center mt-5">
                <div class="col-2 text-center">
                    <a href="{{ route('page.vendor-register') }}" class="btn btn-success px-5">Vendor</a>
                </div>
                <div class="col-1 text-center">Or</div>
                <div class="col-2 text-center">
                    <a href="{{ route('page.user-register') }}" class="btn btn-danger px-5">User</a>
                </div>
            </div>
        </div>
    </div>
@endsection
