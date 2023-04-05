@extends('supplier.layout.main')
@section('content')
<div class="row">
	<div class="col-lg-12">
		<div class="card">
			<div class="card-header">
				<div class="left">
					<span>Edit Customer</span>
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
						<label for="input-11" class="col-sm-2 col-form-label">First Name<span class="text-danger">*</span></label>
						<div class="col-sm-4">
							<input type="text" class="form-control" id="input-10" name="first_name" placeholder="Enter First Name" value="{{old('first_name',$customer->first_name)}}">
							@if ($errors->has('first_name'))
								<span class="text-danger">{{ $errors->first('first_name') }}</span>
							@endif
						</div>
						<label for="input-10" class="col-sm-2 col-form-label">Last Name<span class="text-danger">*</span></label>
						<div class="col-sm-4">
							<input type="text" class="form-control" id="input-10" name="last_name" placeholder="Enter Last Name" value="{{old('first_name',$customer->last_name)}}">
							@if ($errors->has('last_name'))
								<span class="text-danger">{{ $errors->first('last_name') }}</span>
							@endif
						</div>
					</div>
					<div class="form-group row">
						<label for="input-11" class="col-sm-2 col-form-label">Email<span class="text-danger">*</span></label>
						<div class="col-sm-4">
							<input type="email" class="form-control" id="input-10" name="email" placeholder="Enter E-mail" value="{{old('email',$customer->email)}}">
							@if ($errors->has('email'))
								<span class="text-danger">{{ $errors->first('email') }}</span>
							@endif
						</div>
						<label for="input-10" class="col-sm-2 col-form-label">DOB<span class="text-danger">*</span></label>
						<div class="col-sm-4">
							<input type="text" class="form-control autoclose-datepicker" id="input-10" name="dob" placeholder="Enter DOB" value="{{old('dob',date('m/d/Y', strtotime($customer->dob)))}}">
							@if ($errors->has('dob'))
								<span class="text-danger">{{ $errors->first('dob') }}</span>
							@endif
						</div>
					</div>
					<div class="form-group row">
						<label for="input-11" class="col-sm-2 col-form-label">Anniversary Date<span class="text-danger">*</span></label>
						<div class="col-sm-4">
							<input type="text" class="form-control autoclose-datepicker" id="input-11" name="anniversary_date" placeholder="Enter Anniversary Date" value="{{old('anniversary_date',date('m/d/Y', strtotime($customer->anniversary_date)))}}">
							@if ($errors->has('anniversary_date'))
								<span class="text-danger">{{ $errors->first('anniversary_date') }}</span>
							@endif
						</div>
						<label for="input-10" class="col-sm-2 col-form-label">Mobile<span class="text-danger">*</span></label>
						<div class="col-sm-4">
							<input type="text" class="form-control" id="input-10" name="mobile" placeholder="Enter Mobile Number" value="{{old('mobile',$customer->mobile)}}">
							@if ($errors->has('mobile'))
								<span class="text-danger">{{ $errors->first('mobile') }}</span>
							@endif
						</div>
					</div>
					<div class="form-group row">
						<label for="input-10" class="col-sm-2 col-form-label">Address<span class="text-danger">*</span></label>
						<div class="col-sm-4">
							<textarea class="form-control" id="input-10" name="address" placeholder="Enter Address">{{old('address',$customer->address)}}</textarea>
							@if ($errors->has('address'))
								<span class="text-danger">{{ $errors->first('address') }}</span>
							@endif
						</div>
						<label for="input-11" class="col-sm-2 col-form-label">Country<span class="text-danger">*</span></label>
						<div class="col-sm-4">
							<select class="form-control" name="country" id="country">
								<option value="">Select Country</option>
								@foreach($countries as $country)
									<option value="{{$country->id}}"{{ (old("country", $customer->country) == $country->id ? "selected":"") }}>{{$country->name}}</option>
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
								<option value="">Select State</option>
							</select>
							@if ($errors->has('state'))
								<span class="text-danger">{{ $errors->first('state') }}</span>
							@endif
						</div>
						<label for="input-11" class="col-sm-2 col-form-label">City<span class="text-danger">*</span></label>
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
						<label for="input-10" class="col-sm-2 col-form-label">Latitude<span class="text-danger">*</span></label>
						<div class="col-sm-4">
							<input type="text" class="form-control" id="input-10" name="lat" placeholder="Enter Latitude" value="{{old('lat',$customer->lat)}}">
							@if ($errors->has('lat'))
								<span class="text-danger">{{ $errors->first('lat') }}</span>
							@endif
						</div>
						<label for="input-11" class="col-sm-2 col-form-label">Longitude<span class="text-danger">*</span></label>
						<div class="col-sm-4">
							<input type="text" class="form-control" id="input-10" name="long" placeholder="Enter Longitude" value="{{old('long',$customer->long)}}">
							@if ($errors->has('long'))
								<span class="text-danger">{{ $errors->first('long') }}</span>
							@endif
						</div>
					</div>
					<div class="form-group row">
						<label for="input-10" class="col-sm-2 col-form-label">Zip Code<span class="text-danger">*</span></label>
						<div class="col-sm-4">
							<input type="text" class="form-control" id="input-10" name="pincode" placeholder="Enter Zip Code" value="{{old('pincode',$customer->pincode)}}">
							@if ($errors->has('pincode'))
								<span class="text-danger">{{ $errors->first('pincode') }}</span>
							@endif
						</div>
						<label for="input-11" class="col-sm-2 col-form-label">Receive Newsletter<span class="text-danger">*</span></label>
						<div class="col-sm-4">
							<input type="text" class="form-control" id="input-10" name="receive_newsletter" placeholder="Enter Newsletter" value="{{old('receive_newsletter',$customer->receive_newsletter)}}">
							@if ($errors->has('receive_newsletter'))
								<span class="text-danger">{{ $errors->first('receive_newsletter') }}</span>
							@endif
						</div>
					</div>
					<div class="form-group row">
						<label for="input-10" class="col-sm-2 col-form-label">Terms & Condition<span class="text-danger">*</span></label>
						<div class="col-sm-4">
							<input type="text" class="form-control" id="input-10" name="terms_conditions" placeholder="Enter Terms & Condition" value="{{old('terms_conditions',$customer->terms_conditions)}}">
							@if ($errors->has('terms_conditions'))
								<span class="text-danger">{{ $errors->first('terms_conditions') }}</span>
							@endif
						</div>
						<label for="input-13" class="col-sm-2 col-form-label">Status<span class="text-danger">*</span></label>
						<div class="col-sm-4">
							<select name="status" class="form-control">
								<option value="">Select Status</option>
								@php $ac_status = ''; $de_status = '';
									if(old('status')){
										if(old('status')=='active'){
											$ac_status = 'selected="selected"';
										}elseif(old('status')=='deactive'){
											$de_status = 'selected="selected"';
										}
									}
									else{
										if($customer->status == 'active'){
											$ac_status = 'selected="selected"';
										}elseif($customer->status == 'deactive'){
											$de_status = 'selected="selected"';
										}
									}
								@endphp
								<option value="active"{{$ac_status}}>Active</option>
								<option value="deactive"{{$de_status}}>Deactive</option>
							</select>
							@if ($errors->has('status'))
								<span class="text-danger">{{ $errors->first('status') }}</span>
							@endif
						</div>
					</div>
					<center>
						<div class="form-footer">
							<button type="submit" class="btn btn-success"><i class="fa fa-check-square-o"></i> SAVE</button>
							<a href="{{url('supplier/customer')}}"><button type="button" class="btn btn-danger"><i class="fa fa-times"></i> CANCEL</button></a>
						</div>
					</center>
				</form>
			</div>
		</div>
	</div>
</div>
<!--End Row-->
<script type="text/javascript">
var countryID = "{{old('country' , $customer->country)}}";
var stateID = "{{old('state' , $customer->state)}}";
var cityID = "{{old('city' , $customer->city)}}";

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

function goBack() {
	window.history.back();
}
</script>
@endsection
