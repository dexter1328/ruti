@extends('vendor.layout.main')
@section('content')
@if(session()->get('success'))
	<div class="alert alert-success alert-dismissible" role="alert">
		<button type="button" class="close" data-dismiss="alert">×</button>
		<div class="alert-icon">
			<i class="fa fa-check"></i>
		</div>
		<div class="alert-message">
			<span><strong>Success!</strong> {{ session()->get('success') }}</span>
		</div>
	</div>
@endif
<div class="row">
	<div class="col-lg-12">
		<div class="card">
			<div class="card-header">
				<div class="left"><span>Edit Profile</span></div>
			</div>
			<div class="card-body">
				<form id="signupForm" method="post" action="{{ url('vendor/profile') }}" enctype="multipart/form-data">
					@csrf
					<div class="form-group row">

						<label for="input-10" class="col-sm-2 col-form-label">@if(Auth::user()->parent_id == 0) Administrator @else Name @endif<span class="text-danger">*</span></label>
						<div class="col-sm-4">
							<input type="text" class="form-control" id="input-10" name="name" placeholder="Enter Name" value="{{old('name',$vendor->name)}}">
							@if ($errors->has('name'))
								<span class="text-danger">{{ $errors->first('name') }}</span>
							@endif
						</div>
						<label for="input-11" class="col-sm-2 col-form-label">Email<span class="text-danger">*</span></label>
						<div class="col-sm-4">
							<input type="email" class="form-control" id="input-11" name="email" placeholder="Enter Email" value="{{old('email',$vendor->email)}}">
							@if ($errors->has('email'))
								<span class="text-danger">{{ $errors->first('email') }}</span>
							@endif
						</div>
					</div>
					@if(Auth::user()->parent_id == 0)
						<div class="form-group row">
	                        <label for="input-12" class="col-sm-2 col-form-label">Business Name<span class="text-danger">*</span></label>
	                        <div class="col-sm-4">
	                            <input type="text" name="business_name" class="form-control" value="{{old('business_name',$vendor->business_name)}}" placeholder="Enter Business Name">
	                            @if ($errors->has('business_name'))
	                            <span class="text-danger">{{ $errors->first('business_name') }}</span>
	                            @endif
	                        </div>
	                        <label for="input-12" class="col-sm-2 col-form-label">Tax ID<span class="text-danger">*</span></label>
	                        <div class="col-sm-4">
	                            <input type="text" name="tax_id" class="form-control" value="{{old('tax_id',$vendor->tax_id)}}" placeholder="Enter Tax ID">
	                            @if ($errors->has('tax_id'))
	                                <span class="text-danger">{{ $errors->first('tax_id') }}</span>
	                            @endif
	                        </div>
	                    </div>
	                @endif
	                <div class="form-group row">
	                    <label for="input-13" class="col-sm-2 col-form-label">Account Number</label>
						<div class="col-sm-4">
							<input type="text" name="bank_account_number" class="form-control" value="{{old('bank_account_number',$vendor->bank_account_number)}}">
							@if ($errors->has('bank_account_number'))
								<span class="text-danger">{{ $errors->first('bank_account_number') }}</span>
							@endif
						</div>
						<label for="input-12" class="col-sm-2 col-form-label">Routing Number</label>
						<div class="col-sm-4">
							<input type="text" name="bank_routing_number" class="form-control" value="{{old('bank_routing_number',$vendor->bank_routing_number)}}">
							@if ($errors->has('bank_routing_number'))
								<span class="text-danger">{{ $errors->first('bank_routing_number') }}</span>
							@endif
						</div>
					</div>
					<div class="form-group row">
						<label for="input-12" class="col-sm-2 col-form-label">Phone Number</label>
						<div class="col-sm-4">
							<input type="text" name="phone_number" class="form-control" value="{{old('phone_number',$vendor->phone_number)}}">
							@if ($errors->has('phone_number'))
								<span class="text-danger">{{ $errors->first('phone_number') }}</span>
							@endif
						</div>
						<label for="input-13" class="col-sm-2 col-form-label">Mobile Number<span class="text-danger">*</span></label>
						<div class="col-sm-4">
							<input type="text" name="mobile_number" class="form-control" value="{{old('mobile_number',$vendor->mobile_number)}}">
							@if ($errors->has('mobile_number'))
								<span class="text-danger">{{ $errors->first('mobile_number') }}</span>
							@endif
						</div>
					</div>
					
					<div class="form-group row">
						<label for="input-12" class="col-sm-2 col-form-label">Address<span class="text-danger">*</span></label>
						<div class="col-sm-4">
							<textarea class="form-control" id="input-8" name="address">{{old('address',$vendor->address)}}
							</textarea>
							@if ($errors->has('address'))
								<span class="text-danger">{{ $errors->first('address') }}</span>
							@endif 
						</div>
						<label for="input-13" class="col-sm-2 col-form-label">Country<span class="text-danger">*</span></label>
						<div class="col-sm-4">
							<select class="form-control" name="country" id="country">
								<option value="">Select Country</option>
								@foreach($countries as $country)
									<option value="{{$country->id}}"{{ (old("country", $vendor->country) == $country->id ? "selected":"") }}>{{$country->name}}</option>
								@endforeach
							</select>
							@if ($errors->has('country'))
								<span class="text-danger">{{ $errors->first('country') }}</span>
							@endif
						</div>
					</div>
					<div class="form-group row">
						<label for="input-12" class="col-sm-2 col-form-label">State<span class="text-danger">*</span></label>
						<div class="col-sm-4">
							<select class="form-control" id="state" name="state" value="{{old('state')}}">
								<option value="">Select State</option>
							</select>
							@if ($errors->has('state'))
								<span class="text-danger">{{ $errors->first('state') }}</span>
							@endif
						</div>
						<label for="input-13" class="col-sm-2 col-form-label">City<span class="text-danger">*</span></label>
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
						<label for="input-12" class="col-sm-2 col-form-label">Pincode<span class="text-danger">*</span></label>
						<div class="col-sm-4">
							<input type="text" name="pincode" class="form-control" value="{{old('pincode',$vendor->pincode)}}">
							@if ($errors->has('pincode'))
								<span class="text-danger">{{ $errors->first('pincode') }}</span>
							@endif
						</div>
						<label for="input-12" class="col-sm-2 col-form-label">Website link</label>
						<div class="col-sm-4">
							<input type="text" name="website_link" class="form-control" value="{{old('website_link',$vendor->website_link)}}">
						</div>
					</div>
					<div class="form-group row">
						<label for="input-12" class="col-sm-2 col-form-label">Image</label>
						<div class="col-sm-4">
							<input type="file" class="form-control" id="input-8" name="image" value="{{old('image')}}">
							@if ($errors->has('image'))
								<span class="text-danger">{{ $errors->first('image') }}</span>
							@endif
							@if($vendor->image)
								@php $image = asset('public/images/vendors/'.$vendor->image); @endphp
								<br>
								<img class="img-responsive" id="imagePreview" src="{{$image}}" height="100" width="100">
							@endif
						</div>
					</div>
					<center>
						<div class="form-footer">
							<button type="submit" class="btn btn-success"><i class="fa fa-check-square-o"></i> SAVE</button>
							<a href="{{url('vendor/home')}}"><button type="button" class="btn btn-danger"><i class="fa fa-times"></i> CANCEL</button></a>
						</div>
					</center>
				</form>
			</div>
		</div>
	</div>
</div>
<!--End Row--> 

<script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script> 

<script type="text/javascript">

var countryID = "{{old('country', $vendor->country)}}";
var stateID = "{{old('state', $vendor->state)}}";
var cityID = "{{old('city', $vendor->city)}}";

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

