{{-- @extends('vendor.layout.auth')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12 col-md-offset-2">
            <div class="card-body panel-default">
                <div class="card-title text-uppercase text-center py-3">Register</div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ url('/w2bcustomer/register') }}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('first_name') ? ' has-error' : '' }}">
                            <label for="name" class="col-md-4 control-label">First Name</label>

                            <div class="col-md-12">
                                <input id="first_name" type="text" class="form-control" name="first_name" value="{{ old('first_name') }}" autofocus>

                                @if ($errors->has('first_name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('first_name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('last_name') ? ' has-error' : '' }}">
                            <label for="name" class="col-md-4 control-label">Last Name</label>

                            <div class="col-md-12">
                                <input id="last_name" type="text" class="form-control" name="last_name" value="{{ old('last_name') }}" autofocus>

                                @if ($errors->has('last_name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('last_name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-12 control-label">E-Mail Address</label>

                            <div class="col-md-12">
                                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}">

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>


                        <div class="form-group{{ $errors->has('mobile') ? ' has-error' : '' }}">
                            <label for="name" class="col-md-4 control-label">Mobile</label>

                            <div class="col-md-12">
                                <input id="mobile" type="number" class="form-control" name="mobile" value="{{ old('mobile') }}" autofocus>

                                @if ($errors->has('mobile'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('mobile') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password" class="col-md-4 control-label">Password</label>

                            <div class="col-md-12">
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

                            <div class="col-md-12">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation">

                                @if ($errors->has('password_confirmation'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password_confirmation') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-12 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Register
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection --}}
@extends('vendor.layout.auth')
@section('content')
    <style type="text/css">

        /*@media (min-width: 767px){
            .navbar-nav.m-nav {
                top: -10;
            }
        }*/
        .fa{
            margin-top:10px;
        }
        .g-recaptcha{
            transform:scale(0.70);-webkit-transform:scale(0.70);transform-origin:0 0;-webkit-transform-origin:0 0;
        }
        #rc-anchor-alert, .rc-anchor-alert {
            visibility: hidden !important;
        }
        /*.rc-anchor-alert {
            display:none !important;
            color:white !impo;
        }*/
        .font-para.SignUPform label {
            font-size: 13px;
        }
        .font-para.SignUPform {
            padding: 30px 20px;
            margin: 20px 0;
            display: block;
            margin: 10px auto;
        }
        .form-footer {
            margin: 30px 0 0px;
            display: block;
        }
        .form-footer button {
            box-shadow: 0 5px 30px 0 rgba(81, 39, 159, .2);
        }
        .form-footer button.btn.btn-success i {
            padding: 0 8px 0 0;
        }
        button:focus {
            outline: 0px dotted;
            outline: 0px auto -webkit-focus-ring-color;
        }
        .AcceptCheckbox input[type="checkbox"] + label:before {

            margin-top: 7px;
        }

        .field-icon {
            float: right;
            margin-right: 13px;
            margin-top: -26px !important;
            z-index: 2;
        }

        .confirm-check {
            float: right;
            margin-top: -26px !important;
            margin-right: 13px;
            z-index: 2;
        }
        .heading {
            padding: 20px 17%;
        }
    </style>

    <div style="clear:both;"></div>

    <!-- terms-condition start -->
    <section id="inner-main-content">
        <h2 class="heading">Register your Account</h2>
        <div class="container">
            <div class="row align-items-center justify-content-center">
                <div class=''>
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
                                <label for="input-12" class="col-form-label">Image<span class="text-danger">*</span></label>
                                <div class="custom-file">
                                    <input type="file" name="image" class="form-control custom-file-input" id="customFile" value="{{old('image')}}">
                                    <label class="custom-file-label" for="customFile">Choose Your Image</label>
                                    @if ($errors->has('image'))
                                        <span class="text-danger">{{ $errors->first('image') }}</span>
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
                                    <button type="button" onclick="window.location='{{ url("w2bcustomer/auth/google") }}'"  class="btn mt-3 btn-light sign_up_btn w-50"> Register with Google<ig/button>
                                    <button type="button" onclick="window.location='{{ url("w2bcustomer/auth/fb") }}'"  class="btn mt-3 btn-primary w-50"> Register with Facebook</button>
                                    <hr>
                                </div>
                            </center>
                        </form>
                        <div class='text-center'>
                            Are you a seller or supplier?
                        </div>

                        <div class='w-100 my-2 mx-auto d-flex '>
                            <button type="button" onclick="window.location='{{ url("vendor-signup") }}'" style="background-color:#ee7322;color:#fff !important;" class="btn btn-block w-50">Sign Up as Seller</button>
                            <button type="button" onclick="window.location='{{ url("supplier/signup") }}'" class="btn btn-primary ml-1 w-50">Sign Up as Supplier</button>
                        </div>
                        <div class="form-row mt-2">
                            <div class="form-group col-12" style="text-align: center;">
                               Already have an account? <br>
                               <a href="{{ url('/w2bcustomer/login') }}">Sign in as Customer  | </a>
                               <a class='ml-2' href="{{ url("/vendor/login") }}">Sign in as Seller  | </a>
                               <a class='ml-2' href="{{ url("/supplier/login") }}">Sign in as Supplier</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script>
        // Add the following code if you want the name of the file appear on select
        $(".custom-file-input").on("change", function() {
          var fileName = $(this).val().split("\\").pop();
          $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
        });
        </script>

    <script type="text/javascript">

    var countryID = "{{old('country')}}";
    var stateID = "{{old('state')}}";
    var cityID = "{{old('city')}}";

    $(function() {

        setTimeout(function(){ getState(); }, 500);
        setTimeout(function(){ getCity(); }, 500);

        $("#country").change(function() {
            countryID = $(this).val();
            getState();
        });

        $("#state").change(function() {
            stateID = $(this).val();
            getCity();
        });

        /*var date = new Date();
        date.setDate(date.getDate() + 1);
        $('#datepicker').datepicker({
            autoclose: true,
            startDate: date,
            todayHighlight: true
        });*/
        $(".toggle-password").click(function() {

            $(this).toggleClass("fa-eye fa-eye-slash");
            var input = $($(this).attr("toggle"));
            if (input.attr("type") == "password") {
                input.attr("type", "text");
            } else {
                input.attr("type", "password");
            }
        });

        $('#password, #password_confirmation').on('keyup', function () {
            if ($('#password').val() == $('#password_confirmation').val()) {
                $('.confirm-check').removeClass('fa-close');
                $('.confirm-check').addClass('fa-check').css('color', 'green');
            } else {
                $('.confirm-check').removeClass('fa-check');
                $('.confirm-check').addClass('fa-close').css('color', 'red');
            }
        });

    });

    function getState(){
        if(countryID != ''){
            $.ajax({
                data: {
                "_token": "{{ csrf_token() }}"
                },
                url: "{{ url('/get-state') }}/"+countryID,
                type: "GET",
                dataType: 'json',
                success: function (data) {
                    $('#state').empty();
                    $.each(data, function(i, val) {
                        $("#state").append('<option value=' +val.id + '>' + val.name + '</option>');
                    });
                    if($("#state option[value='"+stateID+"']").length > 0){
                        $('#state').val(stateID);
                    }
                },
                error: function (data) {
                }
            });
        }else{
            $("#country").val('');
        }
    }

    function getCity(){
        if(stateID != ''){
            $.ajax({
                data: {
                "_token": "{{ csrf_token() }}"
                },
                url: "{{ url('/get-city') }}/"+stateID,
                type: "GET",
                dataType: 'json',
                success: function (data) {
                    $('#city').empty();
                    $.each(data, function(i, val) {
                        $("#city").append('<option value=' +val.id + '>' + val.name + '</option>');
                    });
                    if($("#city option[value='"+cityID+"']").length > 0){
                        $('#city').val(cityID);
                    }
                },
                error: function (data) {
                }
            });
        }else{
            $("#state").val('');
        }
    }
    </script>
@endsection
