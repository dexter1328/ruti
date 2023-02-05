@extends('vendor.layout.auth')

<!-- Main Content -->
@section('content')

<div class="card-body">
    <div class="card-content p-2">
        <div class="card-title text-uppercase pb-2">Reset Password</div>
        @if(session('status'))
            <div class="alert alert-success alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert">×</button>
                <div class="alert-icon">
                    <i class="fa fa-check"></i>
                </div>
                <div class="alert-message">
                    <span><strong>Success!</strong> {{ session('status') }}</span>
                </div>
            </div>
        @endif

       <!--  @if (session('status'))
            
                <div class="pb-2 alert-message">
                    <span><strong>Success!</strong> {{ session('status') }}</span>
                </div>
            
        @endif -->
        <p class="pb-2">Please enter your email address. You will receive a link to create a new password via email.</p>
        <form class="form-horizontal" role="form" method="POST" action="{{ url('/vendor/password/email') }}">
            {{ csrf_field() }}
            <div class="form-group">
                <label for="email" class="">Email Address</label>
                <div class="position-relative has-icon-right">
                    <input type="email" id="email" name="email" class="form-control input-shadow {{ $errors->has('email') ? 'error' : '' }}" value="{{ old('email') }}" placeholder="Email Address">
                    <div class="form-control-position">
                        <i class="icon-envelope-open"></i>
                    </div>
                    @if ($errors->has('email'))
                        <label class="error">{{ $errors->first('email') }}</label>
                    @endif
                </div>
            </div>

            <button class="btn btn-warning btn-block mt-3">Reset Password</button>
        </form>
    </div>
</div>
<div class="card-footer text-center py-3">
    <p class="text-dark mb-0">Return to the <a href="{{ route('vendor.login') }}"> Sign In</a></p>
</div>
@endsection

