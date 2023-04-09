@extends('front_end.layout')
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
            border: 2px dotted #d2d2d2;
            padding: 30px 20px;
            margin: 20px 0;
            display: block;
            width: 90%;
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
            margin-top: -26px;
            z-index: 2;
        }

        .confirm-check {
            float: right;
            margin-top: -26px;
            margin-right: 13px;
            z-index: 2;
        }
    </style>

    <div style="clear:both;"></div>

    <!-- terms-condition start -->
    <section id="inner-main-content">
        <h2 class="heading text-center mt-4">Seller Register</h2>
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-10 offset-md-1">
                    <div class="font-para SignUPform">
                        <form id="signupForm" method="post" action="{{ url('/vendor-signup') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group row">
                                <label for="input-12" class="col-sm-2 col-form-label">Sales Person Name<!-- <span class="text-danger">*</span> --></label>
                                <div class="col-sm-4">
                                    <input type="text" name="sales_person_name" class="form-control" value="{{old('sales_person_name')}}" placeholder="Enter Name">
                                    @if ($errors->has('sales_person_name'))
                                    <span class="text-danger">{{ $errors->first('sales_person_name') }}</span>
                                    @endif
                                </div>
                                <label for="input-12" class="col-sm-2 col-form-label">Sales Person Mobile Number<!-- <span class="text-danger">*</span> --></label>
                                <div class="col-sm-4">
                                    <input type="text" name="sales_person_mobile_number" class="form-control" value="{{old('sales_person_mobile_number')}}" placeholder="Enter Mobile Number">
                                    @if ($errors->has('sales_person_mobile_number'))
                                        <span class="text-danger">{{ $errors->first('sales_person_mobile_number') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="input-12" class="col-sm-2 col-form-label">Administrator<span class="text-danger">*</span></label>
                                <div class="col-sm-4">
                                    <input type="text" name="name" class="form-control" value="{{old('name')}}" placeholder="Enter Name">
                                    @if ($errors->has('name'))
                                    <span class="text-danger">{{ $errors->first('name') }}</span>
                                    @endif
                                </div>
                                <label for="input-12" class="col-sm-2 col-form-label">Email<span class="text-danger">*</span></label>
                                <div class="col-sm-4">
                                    <input type="email" name="email" class="form-control" value="{{old('email')}}" placeholder="Enter E-mail">
                                    @if ($errors->has('email'))
                                        <span class="text-danger">{{ $errors->first('email') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="input-13" class="col-sm-2 col-form-label">Password<span class="text-danger">*</span></label>
                                <div class="col-sm-4">
                                    <input type="password" id="password" name="password" class="form-control" value="{{old('password')}}" placeholder="Enter Password">
                                    <span toggle="#password" class="fa fa-eye field-icon toggle-password"></span>
                                    @if ($errors->has('password'))
                                        <span class="text-danger">{{ $errors->first('password') }}</span>
                                    @endif
                                </div>
                                <label for="input-13" class="col-sm-2 col-form-label">Confirm Password<span class="text-danger">*</span></label>
                                <div class="col-sm-4">
                                    <input type="password" id="confirm_password" name="confirm_password" class="form-control" value="{{old('confirm_password')}}" placeholder="Enter Confirm Password">
                                    <span class="confirm-check fa"></span>
                                    @if ($errors->has('confirm_password'))
                                        <span class="text-danger">{{ $errors->first('confirm_password') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="input-12" class="col-sm-2 col-form-label">Business Name<span class="text-danger">*</span></label>
                                <div class="col-sm-4">
                                    <input type="text" name="business_name" class="form-control" value="{{old('business_name')}}" placeholder="Enter Business Name">
                                    @if ($errors->has('business_name'))
                                    <span class="text-danger">{{ $errors->first('business_name') }}</span>
                                    @endif
                                </div>
                                <label for="input-12" class="col-sm-2 col-form-label">Tax ID<span class="text-danger">*</span></label>
                                <div class="col-sm-4">
                                    <input type="text" name="tax_id" class="form-control" value="{{old('tax_id')}}" placeholder="Enter Tax ID">
                                    @if ($errors->has('tax_id'))
                                        <span class="text-danger">{{ $errors->first('tax_id') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="input-12" class="col-sm-2 col-form-label">Office Number</label>
                                <div class="col-sm-4">
                                    <input type="text" name="office_number" class="form-control" value="{{old('office_number')}}" placeholder="Enter Office Number">
                                    @if ($errors->has('office_number'))
                                        <span class="text-danger">{{ $errors->first('office_number') }}</span>
                                    @endif
                                </div>
                                <label for="input-13" class="col-sm-2 col-form-label">Mobile Number<span class="text-danger">*</span></label>
                                <div class="col-sm-4">
                                    <input type="text" name="mobile_number" class="form-control" value="{{old('mobile_number')}}" placeholder="Enter Mobile Number">
                                    @if ($errors->has('mobile_number'))
                                        <span class="text-danger">{{ $errors->first('mobile_number') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="input-12" class="col-sm-2 col-form-label">Address</label>
                                <div class="col-sm-4">
                                    <textarea class="form-control" id="input-8" name="address" placeholder="Enter Address">{{old('address')}}</textarea>
                                </div>
                                <label for="input-13" class="col-sm-2 col-form-label">Country</label>
                                <div class="col-sm-4">
                                    <select class="form-control" name="country" id="country">
                                        <option value="">Select Country</option>
                                        @foreach($countries as $country)
                                        <option value="{{$country->id}}" {{ (old("country") == $country->id ? "selected":"") }}>{{$country->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="input-12" class="col-sm-2 col-form-label">State</label>
                                <div class="col-sm-4">
                                    <select class="form-control" id="state" name="state" value="{{old('state')}}">
                                        <option value="">Select State</option>
                                    </select>
                                </div>
                                <label for="input-13" class="col-sm-2 col-form-label">City</label>
                                <div class="col-sm-4">
                                    <select class="form-control" id="city" name="city" value="{{old('city')}}">
                                        <option value="">Select City</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="input-12" class="col-sm-2 col-form-label">Zip Code</label>
                                <div class="col-sm-4">
                                    <input type="text" name="pincode" class="form-control" value="{{old('pincode')}}" placeholder="Enter Zip Code">
                                     @if ($errors->has('pincode'))
                                    <span class="text-danger">{{ $errors->first('pincode') }}</span>
                                    @endif
                                </div>
                                <label for="input-12" class="col-sm-2 col-form-label">Website link</label>
                                <div class="col-sm-4">
                                    <input type="text" name="website_link" class="form-control" value="{{old('website_link')}}" placeholder="Enter Website Link">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="input-10" class="col-sm-2 col-form-label">Image<span class="text-danger">*</span></label>
                                <div class="col-sm-4">
                                    <input type="file" class="form-control" name="image" style="overflow: hidden;">
                                    @if ($errors->has('image'))
                                        <span class="text-danger">{{ $errors->first('image') }}</span>
                                    @endif
                                </div>
                            </div>
                            {{-- <div class="form-group row AcceptCheckbox">
                                <div class="col-sm-10" style="margin-top:0px !important;">
                                    <input type="checkbox" id="terms_condition" name="terms_condition" value="yes"{{ old('terms_condition') == 'yes' ? 'checked' : '' }} class="form-control">

                                    <label for="terms_condition"> I've read and accept the <a href="{{url('/privacy-policy')}}" style="color:navy !important;text-decoration: revert;">privacy</a> and <a href="{{url('/terms-condition')}}" style="color:navy !important;text-decoration: revert;">terms.</a></label><br>
                                    @if ($errors->has('terms_condition'))
                                        <span class="text-danger">{{ $errors->first('terms_condition') }}</span>
                                    @endif
                                </div>
                            </div> --}}
                            <div class="form-check">
                                <label for="terms_condition" class="form-check-label">
                                    <input type="checkbox" class="form-check-input" type="checkbox" id="terms_condition" name="terms_condition" value="yes"{{ old('terms_condition') == 'yes' ? 'checked' : '' }}>
                                     I've read and accept the <a href="{{url('/privacy-policy')}}" style="color:navy !important;text-decoration: revert;">privacy</a> and <a href="{{url('/terms-condition')}}" style="color:navy !important;text-decoration: revert;">terms.</a>
                                </label>
                              </div><br>
                            <div class="form-group row">
                                <div class="col-sm-4">
                                {!! app('captcha')->display() !!}
                                @if ($errors->has('g-recaptcha-response'))
                                    <span class="text-danger">{{ $errors->first('g-recaptcha-response') }}
                                    </span>
                                @endif
                                </div>
                            </div>
                            <center>
                                <div class="form-footer">
                                    <button type="submit" class="btn btn-success"> SignUp</button>
                                    <button type="reset" class="btn btn-success"> Reset</button>
                                </div>
                            </center>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

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

        $('#password, #confirm_password').on('keyup', function () {
            if ($('#password').val() == $('#confirm_password').val()) {
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
