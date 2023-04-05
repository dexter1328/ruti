@extends('vendor.layout.auth')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading p-3 w-100"><h4 class='m-auto'> Register Your Account </h4></div>
                <!-- <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ url('/vendor/register') }}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label for="name" class="col-md-4 control-label">Name</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" autofocus>

                                @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-4 control-label">E-Mail Address</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}">

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password" class="col-md-4 control-label">Password</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control" name="password">

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                            <label for="password-confirm" class="col-md-4 control-label">Confirm Password</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation">

                                @if ($errors->has('password_confirmation'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password_confirmation') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Register
                                </button>
                            </div>
                        </div>
                    </form>
                </div> -->
                <div class="font-para SignUPform col-lg-12 col-md-12 col-sm-12">
                        <form id="signupForm" method="post" action="{{ url('/w2bcustomer/register') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label for="input-12" class="col-form-label">First Name<span class="text-danger">*</span></label>
                                <div>
                                    <input type="text" name="first_name" class="form-control" value="{{old('first_name')}}" placeholder="Enter First Name">
                                    @if ($errors->has('first_name'))
                                    <span class="text-danger">{{ $errors->first('first_name') }}</span>
                                    @endif
                                </div>
                                <label for="input-12" class="col-form-label">Last Name<span class="text-danger">*</span></label>
                                <div>
                                    <input type="text" name="last_name" class="form-control" value="{{old('last_name')}}" placeholder="Enter Last Name">
                                    @if ($errors->has('last_name'))
                                    <span class="text-danger">{{ $errors->first('last_name') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="input-12" class="col-form-label">Phone No.<span class="text-danger">*</span></label>
                                <div>
                                    <input type="text" name="mobile" class="form-control" value="{{old('mobile')}}" placeholder="Enter Phone Number">
                                    @if ($errors->has('mobile'))
                                    <span class="text-danger">{{ $errors->first('mobile') }}</span>
                                    @endif
                                </div>
                                <label for="input-12" class="col-form-label">Email<span class="text-danger">*</span></label>
                                <div>
                                    <input type="email" name="email" class="form-control" value="{{old('email')}}" placeholder="Enter E-mail">
                                    @if ($errors->has('email'))
                                        <span class="text-danger">{{ $errors->first('email') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="input-13" class="col-form-label">Password<span class="text-danger">*</span></label>
                                <div>
                                    <input type="password" id="password" name="password" class="form-control" value="{{old('password')}}" placeholder="Enter Password">
                                    <span toggle="#password" class="fa fa-eye field-icon toggle-password"></span>
                                    @if ($errors->has('password'))
                                        <span class="text-danger">{{ $errors->first('password') }}</span>
                                    @endif
                                </div>
                                <label for="input-13" class="col-form-label">Confirm Password<span class="text-danger">*</span></label>
                                <div>
                                    <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" value="{{old('password_confirmation')}}" placeholder="Enter Confirm Password">
                                    <span class="confirm-check fa"></span>
                                    @if ($errors->has('password_confirmation'))
                                        <span class="text-danger">{{ $errors->first('password_confirmation') }}</span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group AcceptCheckbox">
                                <div class="">
                                    <input type="checkbox" id="terms_condition" name="terms_condition" value="yes"{{ old('terms_condition') == 'yes' ? 'checked' : '' }} class="">

                                    <label for="terms_condition"> I've read and accept the <a href="{{url('/privacy-policy')}}" style="color:navy !important;text-decoration: revert;">privacy</a> and <a href="{{url('/terms-condition')}}" style="color:navy !important;text-decoration: revert;">terms.</a></label><br>
                                    @if ($errors->has('terms_condition'))
                                        <span class="text-danger">{{ $errors->first('terms_condition') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class='col-sm-10'>
                                {!! app('captcha')->display() !!}
                                @if ($errors->has('g-recaptcha-response'))
                                    <span class="text-danger">{{ $errors->first('g-recaptcha-response') }}
                                    </span>
                                @endif
                                </div>
                            </div>
                            <center>
                                <div class="form-footer w-100 px-4">
                                    <button type="submit" class="btn btn-primary sign_up_btn w-100"> SignUp<ig/button>
                                    <button type="submit" class="btn mt-3 btn-light sign_up_btn w-50"> Register with Google<ig/button>
                                    <button type="reset" class="btn mt-3 btn-primary w-50"> Register with Facebook</button>
                                    <hr>
                                    <button type="reset" class="btn btn-success w-100"> Sign up as Customer</button>
                                </div>
                            </center>
                        </form>
                    </div>
            </div>
        </div>
    </div>
</div>
@endsection
