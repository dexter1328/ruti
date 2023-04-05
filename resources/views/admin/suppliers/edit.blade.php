@extends('admin.layout.main')
@section('content')

<div class="row">
	<div class="col-lg-12">
		<div class="card">
			<div class="card-header">
				<div class="left">
					<!-- <i class="fa fa-users"></i> -->
					<span>Edit Supplier</span>
				</div>
			</div>
			<div class="card-body">
            	<div class="container-fluid">
					<form id="signupForm" method="post" action="{{ route('supplier.update',$supplier->id) }}" enctype="multipart/form-data">
						@csrf
						@method('PATCH')
						<div class="form-group row">
							<label for="input-12" class="col-sm-2 col-form-label">Sales Person Name<span class="text-danger">*</span></label>
							<div class="col-sm-4">
								<input type="text" name="sales_person_name" class="form-control" value="{{old('sales_person_name',isset($sales->name)?$sales->name:'')}}">
								@if ($errors->has('sales_person_name'))
								<span class="text-danger">{{ $errors->first('sales_person_name') }}</span>
								@endif
							</div>
							<label for="input-12" class="col-sm-2 col-form-label">Sales Person Mobile Number<span class="text-danger">*</span></label>
							<div class="col-sm-4">
								<input type="text" name="sales_person_mobile_number" class="form-control" value="{{old('sales_person_mobile_number',isset($sales->mobile)?$sales->mobile:'')}}">
								@if ($errors->has('sales_person_mobile_number'))
									<span class="text-danger">{{ $errors->first('sales_person_mobile_number') }}</span>
								@endif
							</div>
						</div>
						<div class="form-group row">
							<label for="input-12" class="col-sm-2 col-form-label">Name<span class="text-danger">*</span></label>
							<div class="col-sm-4">
								<input type="text" name="name" class="form-control" value="{{old('name',$supplier->name)}}">
								@if ($errors->has('name'))
								<span class="text-danger">{{ $errors->first('name') }}</span>
								@endif
							</div>
							<label for="input-12" class="col-sm-2 col-form-label">Email<span class="text-danger">*</span></label>
							<div class="col-sm-4">
								<input type="email" name="email" class="form-control" value="{{old('email',$supplier->email)}}">
								@if ($errors->has('email'))
									<span class="text-danger">{{ $errors->first('email') }}</span>
								@endif
							</div>
						</div>
						<div class="form-group row">
	                        <label for="input-12" class="col-sm-2 col-form-label">Business Name<span class="text-danger">*</span></label>
	                        <div class="col-sm-4">
	                            <input type="text" name="business_name" class="form-control" value="{{old('business_name',$supplier->business_name)}}" placeholder="Enter Business Name">
	                            @if ($errors->has('business_name'))
	                            <span class="text-danger">{{ $errors->first('business_name') }}</span>
	                            @endif
	                        </div>
	                        <label for="input-12" class="col-sm-2 col-form-label">Tax ID<span class="text-danger">*</span></label>
	                        <div class="col-sm-4">
	                            <input type="text" name="tax_id" class="form-control" value="{{old('tax_id',$supplier->tax_id)}}" placeholder="Enter Tax ID">
	                            @if ($errors->has('tax_id'))
	                                <span class="text-danger">{{ $errors->first('tax_id') }}</span>
	                            @endif
	                        </div>
	                    </div>
						<div class="form-group row">
							<label for="input-12" class="col-sm-2 col-form-label">Phone Number</label>
							<div class="col-sm-4">
								<input type="text" name="phone_number" class="form-control" value="{{old('phone_number',$supplier->phone_number)}}">
								@if ($errors->has('phone_number'))
									<span class="text-danger">{{ $errors->first('phone_number') }}</span>
								@endif
							</div>
							<label for="input-13" class="col-sm-2 col-form-label">Mobile Number<span class="text-danger">*</span></label>
							<div class="col-sm-4">
								<input type="text" name="mobile_number" class="form-control" value="{{old('mobile_number',$supplier->mobile_number)}}">
								@if ($errors->has('mobile_number'))
									<span class="text-danger">{{ $errors->first('mobile_number') }}</span>
								@endif
							</div>
						</div>
						<div class="form-group row">
							<label for="input-12" class="col-sm-2 col-form-label">Address</label>
							<div class="col-sm-4">
								<textarea class="form-control" id="input-8" name="address">{{old('address',$supplier->address)}}
								</textarea>
							</div>
							<label for="input-13" class="col-sm-2 col-form-label">Country</label>
							<div class="col-sm-4">
								<select class="form-control" name="country" id="country">
									<option value="">Select Country</option>
									@foreach($countries as $country)
										<option value="{{$country->id}}"{{ (old("country", $supplier->country) == $country->id ? "selected":"") }}>{{$country->name}}</option>
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
								<input type="text" name="pincode" class="form-control" value="{{old('pincode',$supplier->pincode)}}">
							</div>
							<label for="input-11" class="col-sm-2 col-form-label">Expired Date</label>
							<div class="col-sm-4">
								<input type="text" id="datepicker" class="form-control" name="expired_date"
								value="{{old('expired_date',date('m/d/Y', strtotime($supplier->expired_date)))}}">
							</div>
						</div>
						<div class="form-group row">
							<label for="input-12" class="col-sm-2 col-form-label">Website link</label>
							<div class="col-sm-4">
								<input type="text" name="website_link" class="form-control" value="{{old('website_link',$supplier->website_link)}}">
							</div>
							<label for="input-13" class="col-sm-2 col-form-label">Transaction Fees %</label>
							<div class="col-sm-4">
								<input type="text" name="admin_commision" class="form-control" value="{{old('admin_commision',$supplier->admin_commision)}}">
							</div>
						</div>
						<div class="form-group row">
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
											if($supplier->status == 'active'){
												$ac_status = 'selected="selected"';
											}elseif($supplier->status == 'deactive'){
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
							<label for="input-10" class="col-sm-2 col-form-label">Image</label>
	                        <div class="col-sm-4">
	                            <input type="file" class="form-control" name="image">
	                            @if($supplier->image)
								<br>
								<a href="{{url('public/images/suppliers/'.$supplier->image)}}" rel="prettyPhoto">
									<img src="{{url('public/images/suppliers/'.$supplier->image)}}" style="width: 100px; height: auto;">
								</a>
								@endif
	                        </div>
						</div>
						<center>
							<div class="form-footer">
								<button type="submit" class="btn btn-success"><i class="fa fa-check-square-o"></i> SAVE</button>
								<a href="{{url('admin/supplier')}}"><button type="button" class="btn btn-danger"><i class="fa fa-times"></i> CANCEL</button></a>
							</div>
						</center>
					</form>
                </div>
			</div>
		</div>
	</div>
</div>
<!--End Row-->
<script type="text/javascript">

var countryID = "{{old('country' , $supplier->country)}}";
var stateID = "{{old('state' , $supplier->state)}}";
var cityID = "{{old('city' , $supplier->city)}}";

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
@endsection
