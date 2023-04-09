<!DOCTYPE html>
<html>
<head>
    <title></title>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <!-- Latest compiled JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>
<body>
     <center><h3>Vendor Signup</h3></center>
<div class="row" style="margin-top: 50px;">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <div class="container-fluid">
                    <form id="signupForm" method="post" action="{{ url('/vendor-signup') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group row">
                        <label for="input-12" class="col-sm-2 col-form-label">Name<span class="text-danger">*</span></label>
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
                            <input type="password" name="password" class="form-control" value="{{old('password')}}" placeholder="Enter Password">
                            @if ($errors->has('password'))
                                <span class="text-danger">{{ $errors->first('password') }}</span>
                            @endif
                        </div>
                        <label for="input-12" class="col-sm-2 col-form-label">Phone Number</label>
                        <div class="col-sm-4">
                            <input type="text" name="phone_number" class="form-control" value="{{old('phone_number')}}" placeholder="Enter Phone Number">
                            @if ($errors->has('phone_number'))
                                <span class="text-danger">{{ $errors->first('phone_number') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="input-13" class="col-sm-2 col-form-label">Mobile Number</label>
                        <div class="col-sm-4">
                            <input type="text" name="mobile_number" class="form-control" value="{{old('mobile_number')}}" placeholder="Enter Mobile Number">
                            @if ($errors->has('mobile_number'))
                                <span class="text-danger">{{ $errors->first('mobile_number') }}</span>
                            @endif
                        </div>
                        <label for="input-12" class="col-sm-2 col-form-label">Address</label>
                        <div class="col-sm-4">
                            <textarea class="form-control" id="input-8" name="address" placeholder="Enter Address">{{old('address')}}</textarea>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="input-13" class="col-sm-2 col-form-label">Country</label>
                        <div class="col-sm-4">
                            <select class="form-control" name="country" id="country">
                                <option value="">Select Country</option>
                                @foreach($countries as $country)
                                <option value="{{$country->id}}" {{ (old("country") == $country->id ? "selected":"") }}>{{$country->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <label for="input-12" class="col-sm-2 col-form-label">State</label>
                        <div class="col-sm-4">
                            <select class="form-control" id="state" name="state" value="{{old('state')}}">
                                <option value="">Select State</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="input-13" class="col-sm-2 col-form-label">City</label>
                        <div class="col-sm-4">
                            <select class="form-control" id="city" name="city" value="{{old('city')}}">
                                <option value="">Select City</option>
                            </select>
                        </div>
                        <label for="input-12" class="col-sm-2 col-form-label">Pincode</label>
                        <div class="col-sm-4">
                            <input type="text" name="pincode" class="form-control" value="{{old('pincode')}}" placeholder="Enter Pincode">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="input-11" class="col-sm-2 col-form-label">Expired Date</label>
                        <div class="col-sm-4">
                            <input type="text" id="datepicker" class="form-control" name="expired_date" value="{{old('expired_date')}}" placeholder="Enter Expired Date">
                        </div>
                        <label for="input-10" class="col-sm-2 col-form-label">Membership</label>
                        <div class="col-sm-4">
                            <select name="membership_id" class="form-control">
                                <option value="">Select Membership</option>
                                @foreach($memberships as $membership)
                                <option value="{{$membership->id}}" {{ (old("membership_id") == $membership->id ? "selected":"") }}>{{$membership->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="input-13" class="col-sm-2 col-form-label">Admin Comission %</label>
                        <div class="col-sm-4">
                            <input type="text" name="admin_commision" class="form-control" value="{{old('admin_commision')}}" placeholder="Enter Admin Comission">
                        </div>
                        <label for="input-12" class="col-sm-2 col-form-label">Website link</label>
                        <div class="col-sm-4">
                            <input type="text" name="website_link" class="form-control" value="{{old('website_link')}}" placeholder="Enter Website Link">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="input-10" class="col-sm-2 col-form-label">Image</label>
                        <div class="col-sm-4">
                            <input type="file" class="form-control" name="image">
                        </div>
                    </div>
                    <center>
                        <div class="form-footer">
                            <button type="submit" class="btn btn-success"><i class="fa fa-check-square-o"></i> SAVE</button>
                        </div>
                    </center>
                </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
$('#autoclose-datepicker').datepicker({
    autoclose: true,
    todayHighlight: true
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

    var date = new Date();
    date.setDate(date.getDate() + 1);
    $('#datepicker').datepicker({
        autoclose: true,
        startDate: date,
        todayHighlight: true
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
</body>
</html>
