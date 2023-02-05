@extends('vendor.layout.main')

@section('content')

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <div class="left"><span>Add Employee</span></div>
            </div>
            <div class="card-body">
                <form id="signupForm" method="post" action="{{ route('vendors.store') }}" enctype="multipart/form-data">
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
                        <label for="input-13" class="col-sm-2 col-form-label">Confirm Password<span class="text-danger">*</span></label>
                        <div class="col-sm-4">
                            <input type="password" name="confirm_password" class="form-control" value="{{old('confirm_password')}}" placeholder="Enter Confirm Password">
                            @if ($errors->has('confirm_password'))
                                <span class="text-danger">{{ $errors->first('confirm_password') }}</span>
                            @endif
                        </div>
                       
                    </div>
                    <div class="form-group row">
                        <label for="input-12" class="col-sm-2 col-form-label">Phone Number</label>
                        <div class="col-sm-4">
                            <input type="text" name="phone_number" class="form-control" value="{{old('phone_number')}}" placeholder="Enter Phone Number">
                             @if ($errors->has('phone_number'))
                            <span class="text-danger">{{ $errors->first('phone_number') }}</span>
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
                        </div>
                        <label for="input-13" class="col-sm-2 col-form-label">Status<span class="text-danger">*</span></label>
                        <div class="col-sm-4">
                            <select name="status" class="form-control">
                                <option value="">Select Status</option>
                                <option value="active" @if(old('status')=='active' ) selected="selected" @endif>Active</option>
                                <option value="deactive" @if(old('status')=='deactive' ) selected="selected" @endif>Deactive</option>
                            </select>
                            @if ($errors->has('status'))
                            <span class="text-danger">{{ $errors->first('status') }}</span>
                            @endif
                        </div>
                        
                    </div>
                    <div class="form-group row">
                        <label for="input-10" class="col-sm-2 col-form-label">Store<span class="text-danger">*</span></label>
                        <div class="col-sm-4">
                            <select id="store_id" name="store_id" class="form-control">
                                <option value="">Select Store</option>
                                @foreach($vendor_stores as $vendor_store)
                                <option value="{{$vendor_store->id}}" {{ (old("store_id") == $vendor_store->id ? "selected":"") }}>{{$vendor_store->name}}</option>
                                @endforeach
                            </select>
                            @if ($errors->has('store_id'))
                            <span class="text-danger">{{ $errors->first('store_id') }}</span>
                            @endif
                        </div>
                        <label for="input-10" class="col-sm-2 col-form-label">Role<span class="text-danger">*</span></label>
                        <div class="col-sm-4">
                            <select id="role_id" name="role_id" class="form-control">
                                <option value="">Select Role</option>
                                @php /* @endphp
                                @foreach($vendor_roles as $vendor_role)
                                <option value="{{$vendor_role->id}}" {{ (old("role_id") == $vendor_role->id ? "selected":"") }}>{{$vendor_role->role_name}}</option>
                                @endforeach
                                @php */ @endphp
                            </select>
                            @if ($errors->has('role_id'))
                            <span class="text-danger">{{ $errors->first('role_id') }}</span>
                            @endif
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
                            <a href="{{url('vendor/vendors')}}"><button type="button" class="btn btn-danger"><i class="fa fa-times"></i> CANCEL</button></a>
                        </div>
                    </center>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
var countryID = "{{old('country')}}";
var stateID = "{{old('state')}}";
var cityID = "{{old('city')}}";
var store_id = "{{old('store_id')}}";
var role_id = "{{old('role_id')}}";

$(function() {

    setTimeout(function(){ getState(); }, 500);
    setTimeout(function(){ getCity(); }, 500);
    setTimeout(function(){ getStoreRoles(); }, 500);

    $("#country").change(function() {
        countryID = $(this).val();
        getState();
    });

    $("#state").change(function() {
        stateID = $(this).val();
        getCity();
    });

    $("#store_id").change(function() {
        store_id = $(this).val();
        getStoreRoles();
    });

    $('.multiple-select').select2({
        placeholder: "Select store"

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

function getStoreRoles()
{
    if(store_id != ''){

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: "{{url('/vendor/get-store-roles')}}/"+store_id,
            dataType: "json",
            success: function(data){

                $('#role_id').empty();
                $("#role_id").append('<option value="">Select Role</option>');
                $.each(data, function(i, val) {
                    $("#role_id").append('<option value=' +val.id + '>' + val.role_name + '</option>');
                });
                if($("#role_id option[value='"+role_id+"']").length > 0){
                    $('#role_id').val(role_id);
                }
            }
        });
    }
}
</script>
@endsection 