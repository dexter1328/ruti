@extends('vendor.layout.auth')

@section('content')
<div class="card-body">
    <div class="card-content p-2">
        <div class="text-center">
            <img src="{{ asset('public/images/logo-icon-xx.png') }}" alt="logo icon">
        </div>
        <div class="card-title text-uppercase text-center py-3">Reset Password</div>
       <form class="form-horizontal" role="form" method="POST" action="{{ url('/vendor/password/reset') }}">
        @csrf
            <input type="hidden" name="token" value="{{ $token }}">
            <div class="form-group">
                <label for="email" class="sr-only">E-Mail Address</label>
                <div class="position-relative has-icon-right">
                    <input type="email" id="email" class="form-control input-shadow" name="email" placeholder="E-Mail Address" autofocus>
                    <div class="form-control-position">
                        <i class="icon-user"></i>
                    </div>
                    @if ($errors->has('email'))
                        <label class="error">{{ $errors->first('email') }}</label>
                    @endif
                </div>
            </div>
            <div class="form-group">
                <label for="password" class="sr-only">Password</label>
                <div class="position-relative has-icon-right">
                    <input type="password" id="password" class="form-control input-shadow" name="password" placeholder="Password">
                    <div class="form-control-position">
                        <i class="icon-lock"></i>
                    </div>
                    @if ($errors->has('password'))
                        <label class="error">{{ $errors->first('password') }}</label>
                    @endif
                </div>
            </div>
            <div class="form-group">
                <label for="password-confirm" class="sr-only">Confirm Password</label>
                <div class="position-relative has-icon-right">
                    <input type="password" id="password-confirm" class="form-control input-shadow" name="password_confirmation" placeholder="Confirm Password">
                    <div class="form-control-position">
                        <i class="icon-lock"></i>
                    </div>
                    @if ($errors->has('password_confirmation'))
                        <label class="error">{{ $errors->first('password_confirmation') }}</label>
                    @endif
                </div>
            </div>
            <button class="btn btn-warning btn-block mt-3">Reset Password</button>
        </form>
    </div>
</div>
@endsection

