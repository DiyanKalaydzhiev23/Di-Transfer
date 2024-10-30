@extends('base')

@section('title', 'Register|DiTransfer')

@section('content')
<div class="wrapper">
    <div class="inner">
        <img src="/images/image-1.png" alt="" class="image-1">
        <form method="post">
            @csrf
            <h3 class="log-in-header">Create an account?</h3>
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <div class="form-holder">
                <span class="lnr lnr-user"></span>
                <input type="text" name="name" class="form-control" placeholder="Username">
            </div>
            <div class="form-holder">
                <span class="lnr lnr-envelope"></span>
                <input type="text" name="email" class="form-control" placeholder="Mail">
            </div>
            <div class="form-holder">
                <span class="lnr lnr-lock"></span>
                <input type="password" name="password" class="form-control" placeholder="Password">
            </div>
            <div class="form-holder">
                <span class="lnr lnr-lock"></span>
                <input type="password" name="password_confirmation" class="form-control" placeholder="Confirm Password">
            </div>
            <button>
                <span>Register</span>
            </button>
        </form>
        <img src="{{ asset('images/image-2.png') }}" alt="" class="image-2">
    </div>
</div>
@endsection
