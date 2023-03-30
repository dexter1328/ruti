@extends('supplier.layout.main')

@section('content')
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
						<label for="input-12" class="col-sm-2 col-form-label">Password<span class="text-danger">*</span></label>
						<div class="col-sm-4">
							<input type="password" name="password" class="form-control" value="{{old('password')}}" placeholder="Enter Password">
							@if ($errors->has('password'))
								<span class="text-danger">{{ $errors->first('password') }}</span>
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
						<label for="input-12" class="col-sm-2 col-form-label">Manager Name<span class="text-danger">*</span></label>
						<div class="col-sm-4">
							<input type="text" name="manager_name" class="form-control" value="{{old('manager_name')}}" placeholder="Enter Manager Name">
							@if ($errors->has('manager_name'))
								<span class="text-danger">{{ $errors->first('manager_name') }}</span>
							@endif
						</div>
						<label for="input-13" class="col-sm-2 col-form-label">No OF Staff<span class="text-danger">*</span></label>
						<div class="col-sm-4">
							<input type="text" name="no_of_staff" class="form-control" value="{{old('no_of_staff')}}" placeholder="Enter No Of Staff">
							@if ($errors->has('no_of_staff'))
								<span class="text-danger">{{ $errors->first('no_of_staff') }}</span>
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
						<label for="input-13" class="col-sm-2 col-form-label">Branch Admin<span class="text-danger">*</span></label>
						<div class="col-sm-4">
							<input type="text" name="branch_admin" class="form-control" value="{{old('branch_admin')}}" placeholder="Enter Branch Admin">
							@if ($errors->has('branch_admin'))
								<span class="text-danger">{{ $errors->first('branch_admin') }}</span>
							@endif
						</div>
					</div>
					<div class="form-group row">
						<label for="input-12" class="col-sm-2 col-form-label">Image<span class="text-danger">*</span></label>
						<div class="col-sm-4">
							<input type="file" name="image" class="form-control" value="{{old('image')}}">
							@if ($errors->has('image'))
								<span class="text-danger">{{ $errors->first('image') }}</span>
							@endif
						</div>
						<label for="input-11" class="col-sm-2 col-form-label">Address<span class="text-danger">*</span></label>
						<div class="col-sm-4">
							<textarea class="form-control" id="input-8" name="address" placeholder="Enter Address">{{old('address')}}
							</textarea>
							@if ($errors->has('address'))
								<span class="text-danger">{{ $errors->first('address') }}</span>
							@endif
						</div>
					</div>
					<div class="form-group row">
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
						<label for="input-13" class="col-sm-2 col-form-label">State<span class="text-danger">*</span></label>
						<div class="col-sm-4">
							<select class="form-control" id="state" name="state" value="{{old('state')}}">
								<option value="">Select State</option>
							</select>
							@if ($errors->has('state'))
								<span class="text-danger">{{ $errors->first('state') }}</span>
							@endif
						</div>
					</div>
					<div class="form-group row">
						<label for="input-12" class="col-sm-2 col-form-label">City<span class="text-danger">*</span></label>
						<div class="col-sm-4">
							<select class="form-control" id="city" name="city" value="{{old('city')}}">
								<option value="">Select City</option>
							</select>
							@if ($errors->has('city'))
								<span class="text-danger">{{ $errors->first('city') }}</span>
							@endif
						</div>
						<label for="input-13" class="col-sm-2 col-form-label">Latitude</label>
						<div class="col-sm-4">
							<input type="text" name="lat" class="form-control" value="{{old('lat')}}" placeholder="Enter Latitude">
							@if ($errors->has('lat'))
								<span class="text-danger">{{ $errors->first('lat') }}</span>
							@endif
						</div>
					</div>
					<div class="form-group row">
						<label for="input-12" class="col-sm-2 col-form-label">Longitude</label>
						<div class="col-sm-4">
							<input type="text" name="long" class="form-control" value="{{old('long')}}" placeholder="Enter Longitude">
							@if ($errors->has('long'))
								<span class="text-danger">{{ $errors->first('long') }}</span>
							@endif
						</div>
						<label for="input-13" class="col-sm-2 col-form-label">Pincode<span class="text-danger">*</span></label>
						<div class="col-sm-4">
							<input type="text" name="pincode" class="form-control" value="{{old('pincode')}}" placeholder="Enter Pincode">
							@if ($errors->has('pincode'))
								<span class="text-danger">{{ $errors->first('pincode') }}</span>
							@endif
						</div>
					</div>
					<div class="form-group row">
						<label for="input-13" class="col-sm-2 col-form-label">Website link</label>
						<div class="col-sm-4">
							<input type="text" name="website_link" class="form-control" value="{{old('website_link')}}" placeholder="Enter Website Link">
						</div>
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
					</div>
					<div class="form-group row">
						<label for="input-12" class="col-sm-2 col-form-label">Pickup Time Limit<span class="text-danger">*</span></label>
						<div class="col-sm-4">
							<input type="text" name="pickup_time_limit" class="form-control" value="{{old('pickup_time_limit')}}">Note:in minutes
							@if ($errors->has('pickup_time_limit'))
								<span class="text-danger">{{ $errors->first('pickup_time_limit') }}</span>
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
						<h4 class="col-sm-12">Store Time</h4>
					</div>
					<div class="table-responsive">
						<table id="store_tbl" class="table table-bordered">
							<tr>
								<td>Sunday</td>
								<td>
									<div id="sun-div">
										<select class="form-control" name="sunday_open_time">
											@foreach(vendor_store_hours() as $time)
												<option value="{{$time->format('H:i')}}">{{$time->format('H:i')}}</option>
											@endforeach
										</select>
										<select class="form-control" name="sunday_close_time">
											@foreach(vendor_store_hours() as $time)
												<option value="{{$time->format('H:i')}}">{{$time->format('H:i')}}</option>
											@endforeach
										</select>
										<a href="javaScript:void(0)" onclick="hideStoreTime('sunday')"><i class="fa fa-close"></i></a>
									</div>
									<div id="sun-close" style="display: none;">Closed
									</div>
									<input type="hidden" name="sun_status" id="sun-status" value="open">
								</td>
								<td id = "sun-open-event" style="display:none">
									<a href="javaScript:void(0)" onclick="showStoreTime('sunday')"><i class="fa fa-plus"></i></a>
								</td>
							</tr>
							<tr>
								<td>Monday</td>
								<td>
									<div id="mon-div">
										<select class="form-control" name="monday_open_time">
											@foreach(vendor_store_hours() as $time)
												<option value="{{$time->format('H:i')}}">{{$time->format('H:i')}}</option>
											@endforeach
										</select>
										<select class="form-control" name="monday_close_time">
											@foreach(vendor_store_hours() as $time)
												<option value="{{$time->format('H:i')}}">{{$time->format('H:i')}}</option>
											@endforeach
										</select>
										<a href="javaScript:void(0)" onclick="hideStoreTime('monday')"><i class="fa fa-close"></i></a>
									</div>
									<div id="mon-close" style="display: none;">Closed
									</div>
									<input type="hidden" name="mon_status" id="mon-status" value="open">
								</td>
								<td id = "mon-open-event" style="display:none">
									<a href="javaScript:void(0)" onclick="showStoreTime('monday')"><i class="fa fa-plus"></i></a>
								</td>
							</tr>
							<tr>
								<td>Tuesday</td>
								<td>
									<div id="tue-div">
										<select class="form-control" name="tuesday_open_time">
											@foreach(vendor_store_hours() as $time)
												<option value="{{$time->format('H:i')}}">{{$time->format('H:i')}}</option>
											@endforeach
										</select>
										<select class="form-control" name="tuesday_close_time">
											@foreach(vendor_store_hours() as $time)
												<option value="{{$time->format('H:i')}}">{{$time->format('H:i')}}</option>
											@endforeach
										</select>
										<a href="javaScript:void(0)" onclick="hideStoreTime('tuesday')"><i class="fa fa-close"></i></a>
									</div>
									<div id="tue-close" style="display: none;">Closed
									</div>
									<input type="hidden" name="tue_status" id="tue-status" value="open">
								</td>
								<td id = "tue-open-event" style="display:none">
									<a href="javaScript:void(0)" onclick="showStoreTime('tuesday')"><i class="fa fa-plus"></i></a>
								</td>
							</tr>
							<tr>
								<td>Wednesday</td>
								<td>
									<div id="wed-div">
										<select class="form-control" name="wednesday_open_time">
											@foreach(vendor_store_hours() as $time)
												<option value="{{$time->format('H:i')}}">{{$time->format('H:i')}}</option>
											@endforeach
										</select>
										<select class="form-control" name="wednesday_close_time">
											@foreach(vendor_store_hours() as $time)
												<option value="{{$time->format('H:i')}}">{{$time->format('H:i')}}</option>
											@endforeach
										</select>
										<a href="javaScript:void(0)" onclick="hideStoreTime('wednesday')"><i class="fa fa-close"></i></a>
									</div>
									<div id="wed-close" style="display: none;">Closed
									</div>
									<input type="hidden" name="wed_status" id="wed-status" value="open">
								</td>
								<td id = "wed-open-event" style="display:none">
									<a href="javaScript:void(0)" onclick="showStoreTime('wednesday')"><i class="fa fa-plus"></i></a>
								</td>
							</tr><tr>
								<td>Thursday</td>
								<td>
									<div id="thu-div">
										<select class="form-control" name="thursday_open_time">
											@foreach(vendor_store_hours() as $time)
												<option value="{{$time->format('H:i')}}">{{$time->format('H:i')}}</option>
											@endforeach
										</select>
										<select class="form-control" name="thursday_close_time">
											@foreach(vendor_store_hours() as $time)
												<option value="{{$time->format('H:i')}}">{{$time->format('H:i')}}</option>
											@endforeach
										</select>
										<a href="javaScript:void(0)" onclick="hideStoreTime('thursday')"><i class="fa fa-close"></i></a>
									</div>
									<div id="thu-close" style="display: none;">Closed
									</div>
									<input type="hidden" name="thu_status" id="thu-status" value="open">
								</td>
								<td id = "thu-open-event" style="display:none">
									<a href="javaScript:void(0)" onclick="showStoreTime('thursday')"><i class="fa fa-plus"></i></a>
								</td>
							</tr>
							<tr>
								<td>Friday</td>
								<td>
									<div id="fri-div">
										<select class="form-control" name="friday_open_time">
											@foreach(vendor_store_hours() as $time)
												<option value="{{$time->format('H:i')}}">{{$time->format('H:i')}}</option>
											@endforeach
										</select>
										<select class="form-control" name="friday_close_time">
											@foreach(vendor_store_hours() as $time)
												<option value="{{$time->format('H:i')}}">{{$time->format('H:i')}}</option>
											@endforeach
										</select>
										<a href="javaScript:void(0)" onclick="hideStoreTime('friday')"><i class="fa fa-close"></i></a>
									</div>
									<div id="fri-close" style="display: none;">Closed
									</div>
									<input type="hidden" name="fri_status" id="fri-status" value="open">
								</td>
								<td id = "fri-open-event" style="display:none">
									<a href="javaScript:void(0)" onclick="showStoreTime('friday')"><i class="fa fa-plus"></i></a>
								</td>
							</tr>
							<tr>
								<td>Saturday</td>
								<td>
									<div id="sat-div">
										<select class="form-control" name="saturday_open_time">
											@foreach(vendor_store_hours() as $time)
												<option value="{{$time->format('H:i')}}">{{$time->format('H:i')}}</option>
											@endforeach
										</select>
										<select class="form-control" name="saturday_close_time">
											@foreach(vendor_store_hours() as $time)
												<option value="{{$time->format('H:i')}}">{{$time->format('H:i')}}</option>
											@endforeach
										</select>
										<a href="javaScript:void(0)" onclick="hideStoreTime('saturday')"><i class="fa fa-close"></i></a>
									</div>
									<div id="sat-close" style="display: none;">Closed
									</div>
									<input type="hidden" name="sat_status" id="sat-status" value="open">
								</td>
								<td id = "sat-open-event" style="display:none">
									<a href="javaScript:void(0)" onclick="showStoreTime('saturday')"><i class="fa fa-plus"></i></a>
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
		$("#sun-div").css('display','none');
		$("#sun-close").css('display','block');
		$("#sun-status").val('closed');
		$("#sun-open-event").css('display','block');
	}
	if(name == 'saturday'){
		$("#sat-div").css('display','none');
		$("#sat-close").css('display','block');
		$("#sat-status").val('closed');
		$("#sat-open-event").css('display','block');
	}
	if(name == 'friday'){
		$("#fri-div").css('display','none');
		$("#fri-close").css('display','block');
		$("#fri-status").val('closed');
		$("#fri-open-event").css('display','block');
	}
	if(name == 'thursday'){
		$("#thu-div").css('display','none');
		$("#thu-close").css('display','block');
		$("#thu-status").val('closed');
		$("#thu-open-event").css('display','block');
	}
	if(name == 'wednesday'){
		$("#wed-div").css('display','none');
		$("#wed-close").css('display','block');
		$("#wed-status").val('closed');
		$("#wed-open-event").css('display','block');
	}
	if(name == 'tuesday'){
		$("#tue-div").css('display','none');
		$("#tue-close").css('display','block');
		$("#tue-status").val('closed');
		$("#tue-open-event").css('display','block');
	}
	if(name == 'monday'){
		$("#mon-div").css('display','none');
		$("#mon-close").css('display','block');
		$("#mon-status").val('closed');
		$("#mon-open-event").css('display','block');
	}

}

function showStoreTime(name)
{
	if(name == 'sunday'){
		$("#sun-div").css('display','block');
		$("#sun-close").css('display','none');
		$("#sun-status").val('open');
		$("#sun-open-event").css('display','none');
	}
	if(name == 'saturday'){
		$("#sat-div").css('display','block');
		$("#sat-close").css('display','none');
		$("#sat-status").val('open');
		$("#sat-open-event").css('display','none');
	}
	if(name == 'friday'){
		$("#fri-div").css('display','block');
		$("#fri-close").css('display','none');
		$("#fri-status").val('open');
		$("#fri-open-event").css('display','none');
	}
	if(name == 'thursday'){
		$("#thu-div").css('display','block');
		$("#thu-close").css('display','none');
		$("#thu-status").val('open');
		$("#thu-open-event").css('display','none');
	}
	if(name == 'wednesday'){
		$("#wed-div").css('display','block');
		$("#wed-close").css('display','none');
		$("#wed-status").val('open');
		$("#wed-open-event").css('display','none');
	}
	if(name == 'tuesday'){
		$("#tue-div").css('display','block');
		$("#tue-close").css('display','none');
		$("#tue-status").val('open');
		$("#tue-open-event").css('display','none');
	}
	if(name == 'monday'){
		$("#mon-div").css('display','block');
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
