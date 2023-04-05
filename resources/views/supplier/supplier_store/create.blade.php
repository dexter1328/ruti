@extends('supplier.layout.main')

@section('content')
<style type="text/css">
	.table td, .table th {
    white-space: normal;
    border-top: 1px solid #ffffff;
}
</style>
<div class="row">
	<div class="col-lg-12">
		<div class="card">
			<div class="card-header">
				<div class="left"><span>Add Store</span></div>
			</div>
			<div class="card-body">
				<form id="signupForm" method="post" action="{{ route('supplier.stores.store') }}" enctype="multipart/form-data">
					@csrf
					<div class="form-group row">
						<label for="input-10" class="col-sm-2 col-form-label">Name<span class="text-danger">*</span></label>
						<div class="col-sm-4">
							<input type="text"  class="form-control" name="name" value="{{old('name')}}" placeholder="Enter Name">
							@if ($errors->has('name'))
								<span class="text-danger">{{ $errors->first('name') }}</span>
							@endif
						</div>
						<label for="input-13" class="col-sm-2 col-form-label">Email<span class="text-danger">*</span></label>
						<div class="col-sm-4">
							<input type="email" name="email" class="form-control" value="{{old('email')}}" placeholder="Enter E-mail">
							@if ($errors->has('email'))
								<span class="text-danger">{{ $errors->first('email') }}</span>
							@endif
						</div>
					</div>
					<div class="form-group row">
						<label for="input-13" class="col-sm-2 col-form-label">Phone Number<span class="text-danger">*</span></label>
						<div class="col-sm-4">
							<input type="text" name="phone_number" class="form-control" value="{{old('phone_number')}}" placeholder="Enter Phone Number">
							@if ($errors->has('phone_number'))
								<span class="text-danger">{{ $errors->first('phone_number') }}</span>
							@endif
						</div>
						<label for="input-12" class="col-sm-2 col-form-label">Mobile Number</label>
						<div class="col-sm-4">
							<input type="text" name="mobile_number" class="form-control" value="{{old('mobile_number')}}" placeholder="Enter Mobile Number">
							@if ($errors->has('mobile_number'))
								<span class="text-danger">{{ $errors->first('mobile_number') }}</span>
							@endif
						</div>


					</div>
					<div class="form-group row">
						<label for="input-12" class="col-sm-2 col-form-label">Manager Name<span class="text-danger">*</span></label>
						<div class="col-sm-4">
							<input type="text" name="manager_name" class="form-control" value="{{old('manager_name')}}" placeholder="Enter Manager Name">
							@if ($errors->has('manager_name'))
								<span class="text-danger">{{ $errors->first('manager_name') }}</span>
							@endif
						</div>
						<label for="input-13" class="col-sm-2 col-form-label">No OF Staff<span class="text-danger">*</span></label>
						<div class="col-sm-4">
							<input type="number" name="no_of_staff" class="form-control" value="{{old('no_of_staff')}}" placeholder="Enter No Of Staff">
							@if ($errors->has('no_of_staff'))
								<span class="text-danger">{{ $errors->first('no_of_staff') }}</span>
							@endif
						</div>

					</div>
					<div class="form-group row">

						<label for="input-13" class="col-sm-2 col-form-label">Branch Admin<span class="text-danger">*</span></label>
						<div class="col-sm-4">
							<input type="text" name="branch_admin" class="form-control" value="{{old('branch_admin')}}" placeholder="Enter Branch Admin">
							@if ($errors->has('branch_admin'))
								<span class="text-danger">{{ $errors->first('branch_admin') }}</span>
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
						<label for="input-12" class="col-sm-2 col-form-label">Pickup Time Limit<span class="text-danger">*</span></label>
						<div class="col-sm-4">
							<input type="text" name="pickup_time_limit" class="form-control" value="{{old('pickup_time_limit')}}" placeholder="Pickup Time Limit">Note: Time limit in minutes
							@if ($errors->has('pickup_time_limit'))
								<span class="text-danger">{{ $errors->first('pickup_time_limit') }}</span>
							@endif
						</div>
					</div>
					<div class="form-group row">

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
						<div class="col-12">
							<b>Store Time </b>(Note: Choose time according "US/Eastern" TimeZone)
						</div>
					</div>
					<div class="table-responsive">
						<table id="store_tbl" class="table table-borderless">
							<tr>
								<td width="20%">Sunday</td>
								<td width="60%">
									<div id="sun-div">
										<div class="row">
											<div class="col-4">
												<select class="form-control  sun-div" name="sunday_open_time">
													@foreach(vendor_store_hours() as $time)
														@php $open = '';
															if($time->format('H:i') == "09:00"){
																$open = 'selected="selected"';
															}
														@endphp
														<option value="{{$time->format('H:i')}}"{{$open}}>{{$time->format('H:i')}}</option>
													@endforeach
												</select>
												<div id="sun-close" style="display: none;">Closed</div>
												<input type="hidden" name="sun_status" id="sun-status" value="open">
											</div>
											<div class="col-4">
												<select class="form-control  sun-div" name="sunday_close_time">
													@foreach(vendor_store_hours() as $time)
														@php $close = '';
															if($time->format('H:i') == "05:00"){
																$close = 'selected="selected"';
															}
														@endphp
														<option value="{{$time->format('H:i')}}"{{$close}}>{{$time->format('H:i')}}</option>
													@endforeach
												</select>
											</div>
											<div class="col-4">
												<a href="javaScript:void(0)" onclick="hideStoreTime('sunday')" class="sun-div"><i class="fa fa-close" style="margin-top:8px;"></i></a>
												<div id = "sun-open-event" style="display:none;">
													<a href="javaScript:void(0)" onclick="showStoreTime('sunday')"><i class="fa fa-plus" style="margin-top:6px;"></i></a>
												</div>
											</div>
										</div>
									</div>
								</td>
							</tr>
							<tr>
								<td width="20%">Monday</td>
								<td width="60%">
									<div id="mon-div">
										<div class="row">
											<div class="col-4">
												<select class="form-control  mon-div" name="monday_open_time">
													@foreach(vendor_store_hours() as $time)
														@php $open = '';
															if($time->format('H:i') == "09:00"){
																$open = 'selected="selected"';
															}
														@endphp
														<option value="{{$time->format('H:i')}}"{{$open}}>{{$time->format('H:i')}}</option>
													@endforeach
												</select>
												<div id="mon-close" style="display: none;">Closed</div>
												<input type="hidden" name="mon_status" id="mon-status" value="open">
											</div>
											<div class="col-4">
												<select class="form-control  mon-div" name="monday_close_time">
													@foreach(vendor_store_hours() as $time)
														@php $close = '';
															if($time->format('H:i') == "05:00"){
																$close = 'selected="selected"';
															}
														@endphp
														<option value="{{$time->format('H:i')}}"{{$close}}>{{$time->format('H:i')}}</option>
													@endforeach
												</select>
											</div>
											<div class="col-4">
												<a href="javaScript:void(0)" onclick="hideStoreTime('monday')" class="mon-div"><i class="fa fa-close" style="margin-top:8px;"></i></a>
												<div id = "mon-open-event" style="display:none;">
													<a href="javaScript:void(0)" onclick="showStoreTime('monday')"><i class="fa fa-plus" style="margin-top:6px;"></i></a>
												</div>
											</div>
										</div>
									</div>
								</td>
							</tr>
							<tr>
								<td width="20%">Tuesday</td>
								<td width="60%">
									<div id="tue-div">
										<div class="row">
											<div class="col-4">
												<select class="form-control  tue-div" name="tuesday_open_time">
													@foreach(vendor_store_hours() as $time)
														@php $open = '';
															if($time->format('H:i') == "09:00"){
																$open = 'selected="selected"';
															}
														@endphp
														<option value="{{$time->format('H:i')}}"{{$open}}>{{$time->format('H:i')}}</option>
													@endforeach
												</select>
												<div id="tue-close" style="display: none;">Closed</div>
												<input type="hidden" name="tue_status" id="tue-status" value="open">
											</div>
											<div class="col-4">
												<select class="form-control  tue-div" name="tuesday_close_time">
													@foreach(vendor_store_hours() as $time)
														@php $close = '';
															if($time->format('H:i') == "05:00"){
																$close = 'selected="selected"';
															}
														@endphp
														<option value="{{$time->format('H:i')}}"{{$close}}>{{$time->format('H:i')}}</option>
													@endforeach
												</select>
											</div>
											<div class="col-4">
												<a href="javaScript:void(0)" onclick="hideStoreTime('tuesday')" class="tue-div"><i class="fa fa-close" style="margin-top:8px;"></i></a>
												<div id = "tue-open-event" style="display:none;">
													<a href="javaScript:void(0)" onclick="showStoreTime('tuesday')"><i class="fa fa-plus" style="margin-top:6px;"></i></a>
												</div>
											</div>
										</div>
									</div>
								</td>
							</tr>
							<tr>
								<td width="20%">Wednesday</td>
								<td width="60%">
									<div id="wed-div">
										<div class="row">
											<div class="col-4">
												<select class="form-control  wed-div" name="wednesday_open_time">
													@foreach(vendor_store_hours() as $time)
														@php $open = '';
															if($time->format('H:i') == "09:00"){
																$open = 'selected="selected"';
															}
														@endphp
														<option value="{{$time->format('H:i')}}"{{$open}}>{{$time->format('H:i')}}</option>
													@endforeach
												</select>
												<div id="wed-close" style="display: none;">Closed</div>
												<input type="hidden" name="wed_status" id="wed-status" value="open">
											</div>
											<div class="col-4">
												<select class="form-control  wed-div" name="wednesday_close_time">
													@foreach(vendor_store_hours() as $time)
														@php $close = '';
															if($time->format('H:i') == "05:00"){
																$close = 'selected="selected"';
															}
														@endphp
														<option value="{{$time->format('H:i')}}"{{$close}}>{{$time->format('H:i')}}</option>
													@endforeach
												</select>
											</div>
											<div class="col-4">
												<a href="javaScript:void(0)" onclick="hideStoreTime('wednesday')" class="wed-div"><i class="fa fa-close" style="margin-top:8px;"></i></a>
												<div id = "wed-open-event" style="display:none;">
													<a href="javaScript:void(0)" onclick="showStoreTime('wednesday')"><i class="fa fa-plus" style="margin-top:6px;"></i></a>
												</div>
											</div>
										</div>
									</div>
								</td>
							</tr>
							<tr>
								<td width="20%">Thursday</td>
								<td width="60%">
									<div id="thu-div">
										<div class="row">
											<div class="col-4">
												<select class="form-control  thu-div" name="thursday_open_time">
													@foreach(vendor_store_hours() as $time)
														@php $open = '';
															if($time->format('H:i') == "09:00"){
																$open = 'selected="selected"';
															}
														@endphp
														<option value="{{$time->format('H:i')}}"{{$open}}>{{$time->format('H:i')}}</option>
													@endforeach
												</select>
												<div id="thu-close" style="display: none;">Closed</div>
												<input type="hidden" name="thu_status" id="thu-status" value="open">
											</div>
											<div class="col-4">
												<select class="form-control  thu-div" name="thursday_close_time">
													@foreach(vendor_store_hours() as $time)
														@php $close = '';
															if($time->format('H:i') == "05:00"){
																$close = 'selected="selected"';
															}
														@endphp
														<option value="{{$time->format('H:i')}}"{{$close}}>{{$time->format('H:i')}}</option>
													@endforeach
												</select>
											</div>
											<div class="col-4">
												<a href="javaScript:void(0)" onclick="hideStoreTime('thursday')" class="thu-div"><i class="fa fa-close" style="margin-top:8px;"></i></a>
												<div id = "thu-open-event" style="display:none;">
													<a href="javaScript:void(0)" onclick="showStoreTime('thursday')"><i class="fa fa-plus" style="margin-top:6px;"></i></a>
												</div>
											</div>
										</div>
									</div>
								</td>
							</tr>
							<tr>
								<td width="20%">Friday</td>
								<td width="60%">
									<div id="fri-div">
										<div class="row">
											<div class="col-4">
												<select class="form-control  fri-div" name="friday_open_time">
													@foreach(vendor_store_hours() as $time)
														@php $open = '';
															if($time->format('H:i') == "09:00"){
																$open = 'selected="selected"';
															}
														@endphp
														<option value="{{$time->format('H:i')}}"{{$open}}>{{$time->format('H:i')}}</option>
													@endforeach
												</select>
												<div id="fri-close" style="display: none;">Closed</div>
												<input type="hidden" name="fri_status" id="fri-status" value="open">
											</div>
											<div class="col-4">
												<select class="form-control  fri-div" name="friday_close_time">
													@foreach(vendor_store_hours() as $time)
														@php $close = '';
															if($time->format('H:i') == "05:00"){
																$close = 'selected="selected"';
															}
														@endphp
														<option value="{{$time->format('H:i')}}"{{$close}}>{{$time->format('H:i')}}</option>
													@endforeach
												</select>
											</div>
											<div class="col-4">
												<a href="javaScript:void(0)" onclick="hideStoreTime('friday')" class="fri-div"><i class="fa fa-close" style="margin-top:8px;"></i></a>
												<div id = "fri-open-event" style="display:none;">
													<a href="javaScript:void(0)" onclick="showStoreTime('friday')"><i class="fa fa-plus" style="margin-top:6px;"></i></a>
												</div>
											</div>
										</div>
									</div>
								</td>
							</tr>
							<tr>
								<td width="20%">Saturday</td>
								<td width="20%">
									<div id="sat-div">
										<div class="row">
											<div class="col-4">
												<select class="form-control  sat-div" name="saturday_open_time">
													@foreach(vendor_store_hours() as $time)
														@php $open = '';
															if($time->format('H:i') == "09:00"){
																$open = 'selected="selected"';
															}
														@endphp
														<option value="{{$time->format('H:i')}}"{{$open}}>{{$time->format('H:i')}}</option>
													@endforeach
												</select>
												<div id="sat-close" style="display: none;">Closed</div>
												<input type="hidden" name="sat_status" id="sat-status" value="open">
											</div>
											<div class="col-4">
												<select class="form-control  sat-div" name="saturday_close_time">
													@foreach(vendor_store_hours() as $time)
														@php $close = '';
															if($time->format('H:i') == "05:00"){
																$close = 'selected="selected"';
															}
														@endphp
														<option value="{{$time->format('H:i')}}"{{$close}}>{{$time->format('H:i')}}</option>
													@endforeach
												</select>
											</div>
											<div class="col-4">
												<a href="javaScript:void(0)" onclick="hideStoreTime('saturday')" class="sat-div"><i class="fa fa-close" style="margin-top:8px;"></i></a>
												<div id = "sat-open-event" style="display:none;">
													<a href="javaScript:void(0)" onclick="showStoreTime('saturday')"><i class="fa fa-plus" style="margin-top:6px;"></i></a>
												</div>
											</div>
										</div>
									</div>
								</td>
							</tr>
						</table>
					</div>
					<center>
						<div class="form-footer">
							<button type="submit" class="btn btn-success"><i class="fa fa-check-square-o"></i> SAVE</button>
							<a href="{{url('supplier/stores')}}"><button type="button" class="btn btn-danger"><i class="fa fa-times"></i> CANCEL</button></a>
						</div>
					</center>
				</form>
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
$(document).ready(function(){

   $('.timepicker-12-hr').wickedpicker();

});

function hideStoreTime(name)
{
	if(name == 'sunday'){
		$(".sun-div").css('display','none');
		$("#sun-close").css('display','block');
		$("#sun-status").val('closed');
		$("#sun-open-event").css('display','block');
	}
	if(name == 'saturday'){
		$(".sat-div").css('display','none');
		$("#sat-close").css('display','block');
		$("#sat-status").val('closed');
		$("#sat-open-event").css('display','block');
	}
	if(name == 'friday'){
		$(".fri-div").css('display','none');
		$("#fri-close").css('display','block');
		$("#fri-status").val('closed');
		$("#fri-open-event").css('display','block');
	}
	if(name == 'thursday'){
		$(".thu-div").css('display','none');
		$("#thu-close").css('display','block');
		$("#thu-status").val('closed');
		$("#thu-open-event").css('display','block');
	}
	if(name == 'wednesday'){
		$(".wed-div").css('display','none');
		$("#wed-close").css('display','block');
		$("#wed-status").val('closed');
		$("#wed-open-event").css('display','block');
	}
	if(name == 'tuesday'){
		$(".tue-div").css('display','none');
		$("#tue-close").css('display','block');
		$("#tue-status").val('closed');
		$("#tue-open-event").css('display','block');
	}
	if(name == 'monday'){
		$(".mon-div").css('display','none');
		$("#mon-close").css('display','block');
		$("#mon-status").val('closed');
		$("#mon-open-event").css('display','block');
	}

}

function showStoreTime(name)
{
	if(name == 'sunday'){
		$(".sun-div").css('display','block');
		$("#sun-close").css('display','none');
		$("#sun-status").val('open');
		$("#sun-open-event").css('display','none');
	}
	if(name == 'saturday'){
		$(".sat-div").css('display','block');
		$("#sat-close").css('display','none');
		$("#sat-status").val('open');
		$("#sat-open-event").css('display','none');
	}
	if(name == 'friday'){
		$(".fri-div").css('display','block');
		$("#fri-close").css('display','none');
		$("#fri-status").val('open');
		$("#fri-open-event").css('display','none');
	}
	if(name == 'thursday'){
		$(".thu-div").css('display','block');
		$("#thu-close").css('display','none');
		$("#thu-status").val('open');
		$("#thu-open-event").css('display','none');
	}
	if(name == 'wednesday'){
		$(".wed-div").css('display','block');
		$("#wed-close").css('display','none');
		$("#wed-status").val('open');
		$("#wed-open-event").css('display','none');
	}
	if(name == 'tuesday'){
		$(".tue-div").css('display','block');
		$("#tue-close").css('display','none');
		$("#tue-status").val('open');
		$("#tue-open-event").css('display','none');
	}
	if(name == 'monday'){
		$(".mon-div").css('display','block');
		$("#mon-close").css('display','none');
		$("#mon-status").val('open');
		$("#mon-open-event").css('display','none');
	}
}

// store hours
// function saturdayClose(){
// 	$("#sat-open").css('display','nne');
// 	$("#sat-close").css('display','block');
// 	$("#sat-event").css('display','none');
// 	$("#sat-add").css('display','block');
// }

// function satAdd()
// {
// 	$("#sat-open").css('display','block');
// 	$("#sat-close").css('display','none');
// 	$("#sat-event").css('display','block');
// 	$("#sat-add").css('display','none');
// }

</script>
@endsection
