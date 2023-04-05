@extends('supplier.layout.main')
@section('content')
<div class="row">
	<div class="col-lg-12">
		<div class="card">
			<div class="card-header">
				<div class="left">
					<i class="fa fa-users"></i><span>Edit Customer</span>
				</div>
				<div class="right">
					<button onclick="goBack()" class="btn btn-block btn-primary">Go Back</button>
				</div>
			</div>
			<div class="card-body">
				<form id="signupForm" method="post" action="{{ route('supplier.customer.update',$customer->id) }}" enctype="multipart/form-data">
					@csrf
					@method('PATCH')
					<div class="form-group row">
						<label for="input-10" class="col-sm-2 col-form-label">Wallet<span class="text-danger">*</span></label>
						<div class="col-sm-4">
							<input type="text" class="form-control" id="input-10" name="wallet_id" placeholder="Enter Wallet" value="{{$customer->wallet_id}}">
							@if ($errors->has('wallet_id'))
								<span class="text-danger">{{ $errors->first('wallet_id') }}</span>
							@endif
						</div>
						<label for="input-11" class="col-sm-2 col-form-label">First Name<span class="text-danger">*</span></label>
						<div class="col-sm-4">
							<input type="text" class="form-control" id="input-10" name="first_name" placeholder="Enter First Name" value="{{$customer->first_name}}">
							@if ($errors->has('first_name'))
								<span class="text-danger">{{ $errors->first('first_name') }}</span>
							@endif
						</div>
					</div>
					<div class="form-group row">
						<label for="input-10" class="col-sm-2 col-form-label">Last Name<span class="text-danger">*</span></label>
						<div class="col-sm-4">
							<input type="text" class="form-control" id="input-10" name="last_name" placeholder="Enter Last Name" value="{{$customer->last_name}}">
							@if ($errors->has('last_name'))
								<span class="text-danger">{{ $errors->first('last_name') }}</span>
							@endif
						</div>
						<label for="input-11" class="col-sm-2 col-form-label">Email<span class="text-danger">*</span></label>
						<div class="col-sm-4">
							<input type="email" class="form-control" id="input-10" name="email" placeholder="Enter E-mail" value="{{$customer->email}}">
							@if ($errors->has('email'))
								<span class="text-danger">{{ $errors->first('email') }}</span>
							@endif
						</div>
					</div>
					<div class="form-group row">
						<label for="input-10" class="col-sm-2 col-form-label">Address<span class="text-danger">*</span></label>
						<div class="col-sm-4">
							<textarea class="form-control" id="input-10" name="address" placeholder="Enter Address">{{$customer->address}}</textarea>
							@if ($errors->has('address'))
								<span class="text-danger">{{ $errors->first('address') }}</span>
							@endif
						</div>
						<label for="input-11" class="col-sm-2 col-form-label">Country<span class="text-danger">*</span></label>
						<div class="col-sm-4">
							<select class="form-control" name="country" id="country">
								<option value="">Select Country</option>
								@foreach($countries as $country)
								<?PHP $country_id = ($country->id == $customer->country) ? 'selected="selected"' : ''; ?>
								<option value="{{$country->id}}"<?php echo $country_id; ?>>{{$country->name}}</option>
								@endforeach
							</select>
							@if ($errors->has('country'))
								<span class="text-danger">{{ $errors->first('country') }}</span>
							@endif
						</div>
					</div>
					<div class="form-group row">
						<label for="input-10" class="col-sm-2 col-form-label">State<span class="text-danger">*</span></label>
						<div class="col-sm-4">
							<select class="form-control" id="state" name="state" value="{{old('state')}}">
								<?php
								$users_states = DB::table('states')
								->where('id', '=', $customer->state)
								->get();
								foreach ($users_states as $value) {
								$state_id = ($value->id == $customer->state) ? 'selected="selected"' : '';
								echo $state_id;
								?>
								<option value="{{$value->id}}"<?php echo $state_id; ?>>{{$value->name}}</option>
								<?php }
								?>
							</select>
							@if ($errors->has('state'))
								<span class="text-danger">{{ $errors->first('state') }}</span>
							@endif
						</div>
						<label for="input-11" class="col-sm-2 col-form-label">City<span class="text-danger">*</span></label>
						<div class="col-sm-4">
							<select class="form-control" id="city" name="city" value="{{old('city')}}">
								<?php $users_cities = DB::table('cities')
								->where('id', '=', $customer->city)
								->get();
								foreach ($users_cities as $value) {
								$city_id = ($value->id == $customer->city) ? 'selected="selected"' : '';
								?>
								<option value="{{$value->id}}"<?php echo $city_id; ?>>{{$value->name}}</option>
								<?php } ?>
							</select>
							@if ($errors->has('city'))
								<span class="text-danger">{{ $errors->first('city') }}</span>
							@endif
						</div>
					</div>
					<div class="form-group row">
						<label for="input-10" class="col-sm-2 col-form-label">Latitude<span class="text-danger">*</span></label>
						<div class="col-sm-4">
							<input type="text" class="form-control" id="input-10" name="lat" placeholder="Enter Latitude" value="{{$customer->lat}}">
							@if ($errors->has('lat'))
								<span class="text-danger">{{ $errors->first('lat') }}</span>
							@endif
						</div>
						<label for="input-11" class="col-sm-2 col-form-label">Longitude<span class="text-danger">*</span></label>
						<div class="col-sm-4">
							<input type="text" class="form-control" id="input-10" name="long" placeholder="Enter Longitude" value="{{$customer->long}}">
							@if ($errors->has('long'))
								<span class="text-danger">{{ $errors->first('long') }}</span>
							@endif
						</div>
					</div>
					<div class="form-group row">
						<label for="input-10" class="col-sm-2 col-form-label">Pincode<span class="text-danger">*</span></label>
						<div class="col-sm-4">
							<input type="text" class="form-control" id="input-10" name="pincode" placeholder="Enter Pincode" value="{{$customer->pincode}}">
							@if ($errors->has('pincode'))
								<span class="text-danger">{{ $errors->first('pincode') }}</span>
							@endif
						</div>
						<label for="input-11" class="col-sm-2 col-form-label">Phone Code</label>
						<div class="col-sm-4">
							<input type="text" class="form-control" id="input-10" name="phone_code" placeholder="Enter Phonecode" value="{{$customer->phone_code}}">
						</div>
					</div>
					<div class="form-group row">
						<label for="input-10" class="col-sm-2 col-form-label">DOB<span class="text-danger">*</span></label>
						<div class="col-sm-4">
							<input type="text" class="form-control" id="input-10" name="dob" placeholder="Enter DOB" value="{{$customer->dob}}">
							@if ($errors->has('dob'))
								<span class="text-danger">{{ $errors->first('dob') }}</span>
							@endif
						</div>
						<label for="input-11" class="col-sm-2 col-form-label">Anniversary Date<span class="text-danger">*</span></label>
						<div class="col-sm-4">
							<input type="text" class="form-control" id="input-10" name="anniversary_date" placeholder="Enter Anniversary Date" value="{{$customer->anniversary_date}}">
							@if ($errors->has('anniversary_date'))
								<span class="text-danger">{{ $errors->first('anniversary_date') }}</span>
							@endif
						</div>
					</div>
					<div class="form-group row">
						<label for="input-10" class="col-sm-2 col-form-label">Mobile<span class="text-danger">*</span></label>
						<div class="col-sm-4">
							<input type="text" class="form-control" id="input-10" name="mobile" placeholder="Enter Mobile Number" value="{{$customer->mobile}}">
							@if ($errors->has('mobile'))
								<span class="text-danger">{{ $errors->first('mobile') }}</span>
							@endif
						</div>
						<label for="input-11" class="col-sm-2 col-form-label">Receive Newsletter<span class="text-danger">*</span></label>
						<div class="col-sm-4">
							<input type="text" class="form-control" id="input-10" name="receive_newsletter" placeholder="Enter Newsletter" value="{{$customer->receive_newsletter}}">
							@if ($errors->has('receive_newsletter'))
								<span class="text-danger">{{ $errors->first('receive_newsletter') }}</span>
							@endif
						</div>
					</div>
					<div class="form-group row">
						<label for="input-10" class="col-sm-2 col-form-label">Terms & Condition<span class="text-danger">*</span></label>
						<div class="col-sm-4">
							<input type="text" class="form-control" id="input-10" name="terms_conditions" placeholder="Enter Terms & Condition" value="{{$customer->terms_conditions}}">
							@if ($errors->has('terms_conditions'))
								<span class="text-danger">{{ $errors->first('terms_conditions') }}</span>
							@endif
						</div>
						<label for="input-11" class="col-sm-2 col-form-label">Device<span class="text-danger">*</span></label>
						<div class="col-sm-4">
							<input type="text" class="form-control" id="input-10" name="device_id" placeholder="Enter Device" value="{{$customer->device_id}}">
							@if ($errors->has('device_id'))
								<span class="text-danger">{{ $errors->first('device_id') }}</span>
							@endif
						</div>
					</div>
					<div class="form-group row">
						<label for="input-13" class="col-sm-2 col-form-label">Status<span class="text-danger">*</span></label>
						<div class="col-sm-4">
							<select name="status" class="form-control">
								<option value="">Select Status</option>
								<option value="active" @if($customer->status=='active') selected="selected" @endif>Active</option>
								<option value="deactive" @if($customer->status=='deactive') selected="selected" @endif>Deactive</option>
							</select>
							@if ($errors->has('status'))
								<span class="text-danger">{{ $errors->first('status') }}</span>
							@endif
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
<!--End Row-->
<script type="text/javascript">
$(function() {
	$("#country").change(function() {
		var countryID = $(this).val();
		$.ajax({
			data: {
			"_token": "{{ csrf_token() }}",
			"countryID": countryID
			},
			url: "{{ route('country.store') }}",
			type: "POST",
			dataType: 'json',
			success: function (data) {
				$('#state').empty();
				$.each(data, function(i, val) {
					$("#state").append('<option value=' +val.id + '>' + val.name + '</option>');
				});
			},
			error: function (data) {
			}
		});
	});
});
$(function() {
	$("#state").change(function() {
		var stateID = $(this).val();
		$.ajax({
			data: {
			"_token": "{{ csrf_token() }}",
			"stateID": stateID
			},
			url: "{{ route('state.store') }}",
			type: "POST",
			dataType: 'json',
			success: function (data) {
				$('#city').empty();
				$.each(data, function(i, val) {
					$("#city").append('<option value=' +val.id + '>' + val.name + '</option>');
				});
			},
			error: function (data) {
			}
		});
	});
});
function goBack() {
	window.history.back();
}
</script>
@endsection
