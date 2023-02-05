@extends('admin.layout.auth')

@section('content')

@if($errors->any())
<h4>{{$errors->first()}}</h4>
@endif

<div class="card-body">
    <div class="card-content p-2">
        <div class="text-center">
            <img src="{{ asset('public/images/logo-icon-xx.png') }}" alt="logo icon">
           <!--  <img src="{{ asset('public/images/logo-icon.png') }}" alt="logo icon"> -->
        </div>
        <div class="card-title text-uppercase text-center py-3">Reset Password</div>
        <form role="form" method="POST" action="{{ url('/api/password/reset') }}">
            {{ csrf_field() }}
            <input type="hidden" name="token" value="{{ $token }}">
             @if ($errors->has('token'))
                        <label class="error">{{ $errors->first('token') }}</label>
                    @endif
            <div class="form-group">
                <label for="email" class="sr-only">E-Mail Address</label>
                <div class="position-relative has-icon-right">
                    <input type="email" id="email" class="form-control input-shadow " name="email"  placeholder="E-Mail Address" autofocus>
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
                    <input type="password" id="password" class="form-control input-shadow {{ $errors->has('password') ? 'error' : '' }}" name="password" placeholder="Password">
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
                    <input type="password" id="password-confirm" class="form-control input-shadow {{ $errors->has('password_confirmation') ? 'error' : '' }}" name="password_confirmation" placeholder="Confirm Password">
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
