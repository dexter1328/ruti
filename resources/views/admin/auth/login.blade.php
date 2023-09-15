@extends('admin.layout.auth')

@section('content')
<div class="card-body">
    <div class="card-content p-2">
        <div class="text-center">
            <img src="{{asset('public/wb/img/logo/logo2.png')}}" alt="logo icon">
        </div>
        <div class="card-title text-uppercase text-center py-3">Admin Sign In</div>
        <form role="form" method="POST" action="{{ url('/admin/login') }}">
            {{ csrf_field() }}
            <div class="form-group">
                <label for="email" class="sr-only">E-Mail Address</label>
                <div class="position-relative has-icon-right">
                    <input type="email" id="email" class="form-control input-shadow {{ $errors->has('email') ? 'error' : '' }}" name="email" value="{{ old('email') }}" placeholder="E-Mail Address" autofocus>
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
            <div class="form-row">
                <div class="form-group col-6">
                    <div class="icheck-material-primary">
                        <input type="checkbox" id="user-checkbox" name="remember" checked="" />
                        <label for="user-checkbox">Remember me</label>
                    </div>
                </div>
                <div class="form-group col-6 text-right">
                    <a href="{{ url('/admin/password/reset') }}">Reset Password</a>
                </div>
            </div>
            <button type="submit" class="btn btn-primary btn-block">Sign In</button>
            <a href="{{url('/')}}" style="background-color:#ee7322;color:#fff !important;" class="btn btn-block">Home</a>

        </form>
    </div>
</div>
@endsection
