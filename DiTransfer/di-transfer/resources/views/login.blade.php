@extends('base')

@section('title', 'Login|DiTransfer')

@section('content')
<div class="wrapper">
    <div class="inner">
        <img src="/images/image-1.png" alt="" class="image-1">
        <form action="">
            <h3 class="log-in-header">Already have an account?</h3>
            <div class="form-box">
            <div class="form-holder">
                <span class="lnr lnr-user"></span>
                <input type="text" class="form-control" placeholder="Username">
            </div>
            <div class="form-holder">
                <span class="lnr lnr-lock"></span>
                <input type="password" class="form-control" placeholder="Password">
            </div>
            </div>
            <button>
                <span>Login</span>
            </button>
        </form>
        <img src="{{ asset('images/image-2.png') }}" alt="" class="image-2">
    </div>
</div>
@endsection
