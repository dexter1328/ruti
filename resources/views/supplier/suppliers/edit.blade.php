@extends('supplier.layout.main')
@section('content')

<div class="row">
	<div class="col-lg-12">
		<div class="card">
			<div class="card-header">
				<div class="left">
					<span>Edit Employee</span>
				</div>

			</div>
			<div class="card-body">
				<form id="signupForm" method="post" action="{{ route('suppliers.update', $vendor->id) }}" enctype="multipart/form-data">
					@csrf
					@method('PATCH')
					<div class="form-group row">
						<label for="input-12" class="col-sm-2 col-form-label">Name<span class="text-danger">*</span></label>
						<div class="col-sm-4">
							<input type="text" name="name" class="form-control" value="{{old('name',$vendor->name)}}">
							@if ($errors->has('name'))
								<span class="text-danger">{{ $errors->first('name') }}</span>
							@endif
						</div>
						<label for="input-12" class="col-sm-2 col-form-label">Email<span class="text-danger">*</span></label>
						<div class="col-sm-4">
							<input type="email" name="email" class="form-control" value="{{old('email',$vendor->email)}}">
							@if ($errors->has('email'))
								<span class="text-danger">{{ $errors->first('email') }}</span>
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
						<label for="input-12" class="col-sm-2 col-form-label">Address</label>
						<div class="col-sm-4">
							<textarea class="form-control" id="input-8" name="address">{{old('address',$vendor->address)}}
							</textarea>
						</div>
						<label for="input-13" class="col-sm-2 col-form-label">Country</label>
						<div class="col-sm-4">
							<select class="form-control" name="country" id="country">
								<option value="">Select Country</option>
								@foreach($countries as $country)
									<option value="{{$country->id}}"{{ (old("country", $vendor->country) == $country->id ? "selected":"") }}>{{$country->name}}</option>
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
							<input type="text" name="pincode" class="form-control" value="{{old('pincode',$vendor->pincode)}}">
						</div>
						<label for="input-13" class="col-sm-2 col-form-label">Status<span class="text-danger">*</span></label>
						<div class="col-sm-4">
							<select name="status" class="form-control">
								@php $ac_status = ''; $de_status = '';
									if(old('status')){
										if(old('status')=='active'){
											$ac_status = 'selected="selected"';
										}elseif(old('status')=='deactive'){
											$de_status = 'selected="selected"';
										}
									}
									else{
										if($vendor->status == 'active'){
											$ac_status = 'selected="selected"';
										}elseif($vendor->status == 'deactive'){
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

					<div class="form-group row">
						<label for="input-10" class="col-sm-2 col-form-label">Role<span class="text-danger">*</span></label>
						<div class="col-sm-4">
							<select id="role_id" name="role_id" class="form-control">
								<option value="">Select Role</option>
								@foreach($vendor_roles as $vendor_role)
									<option value="{{$vendor_role->id}}" {{ (old("role_id", $vendor->role_id) == $vendor_role->id ? "selected":"") }}>{{$vendor_role->role_name}}</option>
								@endforeach
							</select>
							@if ($errors->has('role_id'))
                            <span class="text-danger">{{ $errors->first('role_id') }}</span>
                            @endif
						</div>
						<label for="input-10" class="col-sm-2 col-form-label">Image</label>
                        <div class="col-sm-4">
                            <input type="file" class="form-control" name="image">
                            @if($vendor->image)
							<br>
							<a href="{{url('public/images/suppliers/'.$vendor->image)}}" rel="prettyPhoto">
								<img src="{{url('public/images/suppliers/'.$vendor->image)}}" style="width: 100px; height: auto;">
							</a>
							@endif
                        </div>
					</div>
					<center>
						<div class="form-footer">
							<button type="submit" class="btn btn-success"><i class="fa fa-check-square-o"></i> SAVE</button>
							<a href="{{url('supplier/suppliers')}}"><button type="button" class="btn btn-danger"><i class="fa fa-times"></i> CANCEL</button></a>
						</div>
					</center>
				</form>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">

var countryID = "{{old('country', $vendor->country)}}";
var stateID = "{{old('state', $vendor->state)}}";
var cityID = "{{old('city', $vendor->city)}}";
var role_id = "{{old('role_id', $vendor->role_id)}}";

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
			url: "{{url('/supplier/get-store-roles')}}/"+store_id,
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

function goBack() {
	window.history.back();
}
</script>
@endsection
