@extends('admin.layout.main')

@section('content')
<div class="row">
	<div class="col-lg-12">
		<div class="card">
			<div class="card-header">
				<div class="left"><!-- <i class="fa fa-shopping-bag"></i> --><span>Add Store</span></div>
			</div>
			<div class="card-body">
            	<div class="container-fluid">
					<form id="signupForm" method="post" action="{{ route('supplier_store.store') }}" enctype="multipart/form-data">
					@csrf
					<div class="form-group row">
						<label for="input-10" class="col-sm-2 col-form-label">Supplier<span class="text-danger">*</span></label>
						<div class="col-sm-4">
							<select name="vendor_id" class="form-control">
								<option value="">Select Supplier</option>
								@foreach($vendors as $vendor)
								<option value="{{$vendor->id}}" {{ (old("vendor_id") == $vendor->id ? "selected":"") }}>{{$vendor->name}}</option>
								@endforeach
							</select>
							@if ($errors->has('vendor_id'))
								<span class="text-danger">{{ $errors->first('vendor_id') }}</span>
							@endif
						</div>
						<label for="input-10" class="col-sm-2 col-form-label">Name<span class="text-danger">*</span></label>
						<div class="col-sm-4">
							<input type="text"  class="form-control" name="name" value="{{old('name')}}" placeholder="Enter Name">
							@if ($errors->has('name'))
								<span class="text-danger">{{ $errors->first('name') }}</span>
							@endif
						</div>
					</div>
					<div class="form-group row">
						<label for="input-13" class="col-sm-2 col-form-label">Email<span class="text-danger">*</span></label>
						<div class="col-sm-4">
							<input type="email" name="email" class="form-control" value="{{old('email')}}" placeholder="Enter E-mail">
							@if ($errors->has('email'))
								<span class="text-danger">{{ $errors->first('email') }}</span>
							@endif
						</div>
						<label for="input-13" class="col-sm-2 col-form-label">Phone Number<span class="text-danger">*</span></label>
						<div class="col-sm-4">
							<input type="text" name="phone_number" class="form-control" value="{{old('phone_number')}}" placeholder="Enter Phone Number">
							@if ($errors->has('phone_number'))
								<span class="text-danger">{{ $errors->first('phone_number') }}</span>
							@endif
						</div>
					</div>
					<div class="form-group row">

						<label for="input-12" class="col-sm-2 col-form-label">Mobile Number</label>
						<div class="col-sm-4">
							<input type="text" name="mobile_number" class="form-control" value="{{old('mobile_number')}}" placeholder="Enter Mobile Number">
							@if ($errors->has('mobile_number'))
								<span class="text-danger">{{ $errors->first('mobile_number') }}</span>
							@endif
						</div>
						<label for="input-12" class="col-sm-2 col-form-label">Manager Name<span class="text-danger">*</span></label>
						<div class="col-sm-4">
							<input type="text" name="manager_name" class="form-control" value="{{old('manager_name')}}" placeholder="Enter Manager Name">
							@if ($errors->has('manager_name'))
								<span class="text-danger">{{ $errors->first('manager_name') }}</span>
							@endif
						</div>
					</div>
					<div class="form-group row">

						<label for="input-13" class="col-sm-2 col-form-label">No OF Staff<span class="text-danger">*</span></label>
						<div class="col-sm-4">
							<input type="number" name="no_of_staff" class="form-control" value="{{old('no_of_staff')}}" placeholder="Enter No Of Staff">
							@if ($errors->has('no_of_staff'))
								<span class="text-danger">{{ $errors->first('no_of_staff') }}</span>
							@endif
						</div>
						<label for="input-13" class="col-sm-2 col-form-label">Branch Admin<span class="text-danger">*</span></label>
						<div class="col-sm-4">
							<input type="text" name="branch_admin" class="form-control" value="{{old('branch_admin')}}" placeholder="Enter Branch Admin">
							@if ($errors->has('branch_admin'))
								<span class="text-danger">{{ $errors->first('branch_admin') }}</span>
							@endif
						</div>
					</div>
					<div class="form-group row">

						<label for="input-11" class="col-sm-2 col-form-label">Address<span class="text-danger">*</span></label>
						<div class="col-sm-4">
							<textarea class="form-control" id="input-8" name="address" placeholder="Enter Address">{{old('address')}}</textarea>
							@if ($errors->has('address'))
								<span class="text-danger">{{ $errors->first('address') }}</span>
							@endif
						</div>
						<label for="input-12" class="col-sm-2 col-form-label">Country<span class="text-danger">*</span></label>
						<div class="col-sm-4">
							<select class="form-control" name="country" id="country">
								<option value="">Select Country</option>
								@foreach($countries as $country)
								<option value="{{$country->id}}" {{ (old("country") == $country->id ? "selected":"") }}>{{$country->name}}</option>
								@endforeach
							</select>
							@if ($errors->has('country'))
								<span class="text-danger">{{ $errors->first('country') }}</span>
							@endif
						</div>
					</div>
					<div class="form-group row">


						<label for="input-13" class="col-sm-2 col-form-label">State<span class="text-danger">*</span></label>
						<div class="col-sm-4">
							<select class="form-control" id="state" name="state" value="{{old('state')}}">
								<option value="">Select State</option>
							</select>
							@if ($errors->has('state'))
								<span class="text-danger">{{ $errors->first('state') }}</span>
							@endif
						</div>
						<label for="input-12" class="col-sm-2 col-form-label">City<span class="text-danger">*</span></label>
						<div class="col-sm-4">
							<select class="form-control" id="city" name="city" value="{{old('city')}}">
								<option value="">Select City</option>
							</select>
							@if ($errors->has('city'))
								<span class="text-danger">{{ $errors->first('city') }}</span>
							@endif
						</div>
					</div>
					<div class="form-group row">

						<label for="input-13" class="col-sm-2 col-form-label">Latitude<span class="text-danger">*</span></label>
						<div class="col-sm-4">
							<input type="text" name="lat" class="form-control" value="{{old('lat')}}" placeholder="Enter Latitude">
							@if ($errors->has('lat'))
								<span class="text-danger">{{ $errors->first('lat') }}</span>
							@endif
						</div>
						<label for="input-12" class="col-sm-2 col-form-label">Longitude<span class="text-danger">*</span></label>
						<div class="col-sm-4">
							<input type="text" name="long" class="form-control" value="{{old('long')}}" placeholder="Enter Longitude">
							@if ($errors->has('long'))
								<span class="text-danger">{{ $errors->first('long') }}</span>
							@endif
						</div>
					</div>
					<div class="form-group row">

						<label for="input-13" class="col-sm-2 col-form-label">Zip Code<span class="text-danger">*</span></label>
						<div class="col-sm-4">
							<input type="text" name="pincode" class="form-control" value="{{old('pincode')}}" placeholder="Enter Zip Code">
							@if ($errors->has('pincode'))
								<span class="text-danger">{{ $errors->first('pincode') }}</span>
							@endif
						</div>
						<label for="input-13" class="col-sm-2 col-form-label">Website link</label>
						<div class="col-sm-4">
							<input type="text" name="website_link" class="form-control" value="{{old('website_link')}}" placeholder="Enter Website Link">
						</div>
					</div>
					<div class="form-group row">

						<label for="input-12" class="col-sm-2 col-form-label">Status<span class="text-danger">*</span></label>
						<div class="col-sm-4">
							<select name="status" class="form-control">
								<option value="">Select Status</option>
								<option value="enable" @if(old('status')=='enable') selected="selected" @endif>Enable</option>
								<option value="disable" @if(old('status')=='disable') selected="selected" @endif>Disable</option>
							</select>
							@if ($errors->has('status'))
								<span class="text-danger">{{ $errors->first('status') }}</span>
							@endif
						</div>
						<label for="input-13" class="col-sm-2 col-form-label">Current Status<span class="text-danger">*</span></label>
						<div class="col-sm-4">
							<select name="current_status" class="form-control">
								<option value="">Select Current Status</option>
								<option value="open" @if(old('current_status')=='open') selected="selected" @endif>Open</option>
								<option value="close" @if(old('current_status')=='close') selected="selected" @endif>Close</option>
							</select>
							@if ($errors->has('current_status'))
								<span class="text-danger">{{ $errors->first('current_status') }}</span>
							@endif
						</div>
					</div>
					<div class="form-group row">

						<label for="input-13" class="col-sm-2 col-form-label">Return Policy<span class="text-danger">*</span></label>
						<div class="col-sm-4">
							<input type="number" name="return_policy" class="form-control" value="{{old('return_policy')}}" placeholder="Enter Return Policy">
							<span>Note:6+ days</span><br>
							@if ($errors->has('return_policy'))
								<span class="text-danger">{{ $errors->first('return_policy') }}</span>
							@endif
						</div>
						<label for="input-12" class="col-sm-2 col-form-label">Image<span class="text-danger">*</span></label>
						<div class="col-sm-4">
							<input type="file" name="image" class="form-control" value="{{old('image')}}">
							@if ($errors->has('image'))
								<span class="text-danger">{{ $errors->first('image') }}</span>
							@endif
						</div>
					</div>
					<div class="form-group row">

						<label for="input-12" class="col-sm-2 col-form-label">Pickup Time Limit<span class="text-danger">*</span></label>
						<div class="col-sm-4">
							<input type="text" name="pickup_time_limit" class="form-control" value="{{old('pickup_time_limit')}}">Note: Time limit in minutes
							@if ($errors->has('pickup_time_limit'))
								<span class="text-danger">{{ $errors->first('pickup_time_limit') }}</span>
							@endif
						</div>
					</div>
					<center>
						<div class="form-footer">
							<button type="submit" class="btn btn-success"><i class="fa fa-check-square-o"></i> SAVE</button>
							<a href="{{url('admin/supplier_store')}}"><button type="button" class="btn btn-danger"><i class="fa fa-times"></i> CANCEL</button></a>
						</div>
					</center>
				</form>
                </div>
			</div>
		</div>
	</div>
</div>

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
