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
				<div class="left"><span>Edit Store</span></div>
			</div>
			<div class="card-body">
				<form id="signupForm" method="post" action="{{ route('supplier.stores.update',$vendor_store->id) }}" enctype="multipart/form-data">
					@csrf
					@method('PATCH')
					<div class="form-group row">
						<label for="input-10" class="col-sm-2 col-form-label">Name<span class="text-danger">*</span></label>
						<div class="col-sm-4">
							<input type="text" class="form-control" name="name" value="{{old('name',$vendor_store->name)}}">
							@if ($errors->has('name'))
								<span class="text-danger">{{ $errors->first('name') }}</span>
							@endif
						</div>
						<label for="input-13" class="col-sm-2 col-form-label">Email<span class="text-danger">*</span></label>
						<div class="col-sm-4">
							<input type="email" name="email" class="form-control" value="{{old('email',$vendor_store->email)}}">
							@if ($errors->has('email'))
								<span class="text-danger">{{ $errors->first('email') }}</span>
							@endif
						</div>
					</div>
					<div class="form-group row">
						<label for="input-13" class="col-sm-2 col-form-label">Phone Number<span class="text-danger">*</span></label>
						<div class="col-sm-4">
							<input type="text" name="phone_number" class="form-control" value="{{old('phone_number',$vendor_store->phone_number)}}">
							@if ($errors->has('phone_number'))
								<span class="text-danger">{{ $errors->first('phone_number') }}</span>
							@endif
						</div>
						<label for="input-12" class="col-sm-2 col-form-label">Mobile Number</label>
						<div class="col-sm-4">
							<input type="text" name="mobile_number" class="form-control" value="{{old('mobile_number',$vendor_store->mobile_number)}}">
							@if ($errors->has('mobile_number'))
								<span class="text-danger">{{ $errors->first('mobile_number') }}</span>
							@endif
						</div>
					</div>
					<div class="form-group row">
						<label for="input-12" class="col-sm-2 col-form-label">Manager Name<span class="text-danger">*</span></label>
						<div class="col-sm-4">
							<input type="text" name="manager_name" class="form-control" value="{{old('manager_name',$vendor_store->manager_name)}}" placeholder="Enter Manager Name">
							@if ($errors->has('manager_name'))
								<span class="text-danger">{{ $errors->first('manager_name') }}</span>
							@endif
						</div>
						<label for="input-13" class="col-sm-2 col-form-label">No OF Staff<span class="text-danger">*</span></label>
						<div class="col-sm-4">
							<input type="number" name="no_of_staff" class="form-control" value="{{old('no_of_staff',$vendor_store->no_of_staff)}}" placeholder="Enter No Of Staff">
							@if ($errors->has('no_of_staff'))
								<span class="text-danger">{{ $errors->first('no_of_staff') }}</span>
							@endif
						</div>
					</div>
					<div class="form-group row">
						<label for="input-13" class="col-sm-2 col-form-label">Branch Admin<span class="text-danger">*</span></label>
						<div class="col-sm-4">
							<input type="text" name="branch_admin" class="form-control" value="{{old('branch_admin',$vendor_store->branch_admin)}}">
							@if ($errors->has('branch_admin'))
								<span class="text-danger">{{ $errors->first('branch_admin') }}</span>
							@endif
						</div>
						<label for="input-12" class="col-sm-2 col-form-label">Image</label>
						<div class="col-sm-4">
							<input type="file" name="image" class="form-control" value="{{old('image')}}">
							@if ($errors->has('image'))
								<span class="text-danger">{{ $errors->first('image') }}</span>
							@endif
							@if($vendor_store->image)
							<br>
							<a href="{{url('public/images/stores/'.$vendor_store->image)}}" rel="prettyPhoto">
								<img src="{{url('public/images/stores/'.$vendor_store->image)}}" style="width: 200px; height: auto;">
							</a>
							@endif
						</div>
					</div>
					<div class="form-group row">
						<label for="input-11" class="col-sm-2 col-form-label">Address<span class="text-danger">*</span></label>
						<div class="col-sm-4">
							<textarea class="form-control" id="input-8" name="address">{{$vendor_store->address1}}</textarea>
							@if ($errors->has('address'))
								<span class="text-danger">{{ $errors->first('address') }}</span>
							@endif
						</div>
						<label for="input-12" class="col-sm-2 col-form-label">Country<span class="text-danger">*</span></label>
						<div class="col-sm-4">
							<select class="form-control" name="country" id="country">
								<option value="">Select Country</option>
								@foreach($countries as $country)
									<option value="{{$country->id}}"{{ (old("country", $vendor_store->country) == $country->id ? "selected":"") }}>{{$country->name}}</option>
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
							<input type="text" name="lat" class="form-control" value="{{old('lat',$vendor_store->lat)}}">
							@if ($errors->has('lat'))
								<span class="text-danger">{{ $errors->first('lat') }}</span>
							@endif
						</div>
						<label for="input-12" class="col-sm-2 col-form-label">Longitude<span class="text-danger">*</span></label>
						<div class="col-sm-4">
							<input type="text" name="long" class="form-control" value="{{old('long',$vendor_store->long)}}">
							@if ($errors->has('long'))
								<span class="text-danger">{{ $errors->first('long') }}</span>
							@endif
						</div>
					</div>
					<div class="form-group row">
						<label for="input-13" class="col-sm-2 col-form-label">Zip Code<span class="text-danger">*</span></label>
						<div class="col-sm-4">
							<input type="text" name="pincode" class="form-control" value="{{old('pincode',$vendor_store->pincode)}}">
							@if ($errors->has('pincode'))
								<span class="text-danger">{{ $errors->first('pincode') }}</span>
							@endif
						</div>
						<label for="input-12" class="col-sm-2 col-form-label">Website link</label>
						<div class="col-sm-4">
							<input type="text" name="website_link" class="form-control" value="{{old('website_link',$vendor_store->website_link)}}">
						</div>
					</div>
					<div class="form-group row">
						<label for="input-12" class="col-sm-2 col-form-label">Status<span class="text-danger">*</span></label>
						<div class="col-sm-4">
							<select name="status" class="form-control">
								<option value="">Select Status</option>
								@php $ac_enable = ''; $de_disable = '';
									if(old('status')){
										if(old('status')=='enable'){
											$ac_enable = 'selected="selected"';
										}elseif(old('status')=='disable'){
											$de_disable = 'selected="selected"';
										}
									}else{
										if($vendor_store->status == 'enable'){
											$ac_enable = 'selected="selected"';
										}elseif($vendor_store->status == 'disable'){
											$de_disable = 'selected="selected"';
										}
									}
								@endphp
								<option value="enable"{{$ac_enable}}>Enable</option>
								<option value="disable"{{$de_disable}}>Disable</option>
							</select>
							@if ($errors->has('status'))
								<span class="text-danger">{{ $errors->first('status') }}</span>
							@endif
						</div>
						<label for="input-13" class="col-sm-2 col-form-label">Current Status<span class="text-danger">*</span></label>
						<div class="col-sm-4">
							<select name="current_status" class="form-control">
								<option value="">Select Current Status</option>
								@php $ac_open = ''; $de_close = '';
										if(old('current_status')){
											if(old('current_status')=='open'){
												$ac_open = 'selected="selected"';
											}elseif(old('current_status')=='close'){
												$de_close = 'selected="selected"';
											}
										}else{
											if($vendor_store->open_status == 'open'){
												$ac_open = 'selected="selected"';
											}elseif($vendor_store->open_status == 'close'){
												$de_close = 'selected="selected"';
											}
										}
								@endphp
								<option value="open"{{$ac_open}}>Open</option>
								<option value="close"{{$de_close}}>Close</option>
							</select>
							@if ($errors->has('current_status'))
								<span class="text-danger">{{ $errors->first('current_status') }}</span>
							@endif
						</div>
					</div>
					<div class="form-group row">
						<label for="input-13" class="col-sm-2 col-form-label">Pickup Time Limit<span class="text-danger">*</span></label>
						<div class="col-sm-4">
							<input type="text" name="pickup_time_limit" class="form-control" value="{{old('pickup_time_limit',$vendor_store->pickup_time_limit)}}" placeholder="Enter Return Policy">Note: Time limit in minutes
							@if ($errors->has('pickup_time_limit'))
								<span class="text-danger">{{ $errors->first('pickup_time_limit') }}</span>
							@endif
						</div>
					</div>
					<div class="form-group row">
						<div class="col-12">
							<b>Store Time </b>(Note: Choose time according "US/Eastern" TimeZone)
						</div>
					</div>
					@if(!empty($day))
					<div class="table-responsive">
						<table id="store_tbl" class="table table-borderless">
							<tr>
								<td width="20%">Sunday</td>
								<td width="60%">
									<div id="sun-div">
										<div class="row">
											<div class="col-4">
												<select class="form-control  sun-div" name="sunday_open_time" {{isset($sunday->daystart_time) && $sunday->daystart_time != NULL ? 'style=display:block;' : 'style=display:none;'}}>
													@foreach(vendor_store_hours() as $time)
														<option value="{{$time->format('H:i')}}"{{ (old("sunday_open_time", $sunday->daystart_time) == $time->format('H:i') ? "selected":"") }}>{{$time->format('H:i')}}</option>
													@endforeach
												</select>
												<div id="sun-close" {{isset($sunday->daystart_time) && $sunday->daystart_time != NULL ? 'style=display:none;' : 'style=display:block;'}}>Closed</div>
												<input type="hidden" name="sun_status" id="sun-status" {{isset($sunday->daystart_time) && $sunday->daystart_time != NULL ? 'value=open' : 'value=closed'}}>
											</div>
											<div class="col-4">
												<select class="form-control  sun-div" name="sunday_close_time" {{isset($sunday->daystart_time) && $sunday->daystart_time != NULL ? 'style=display:block;' : 'style=display:none;'}}>
													@foreach(vendor_store_hours() as $time)
														<option value="{{$time->format('H:i')}}"{{ (old("sunday_close_time", $sunday->dayend_time) == $time->format('H:i') ? "selected":"") }}>{{$time->format('H:i')}}</option>
													@endforeach
												</select>
											</div>
											<div class="col-4">
												<a href="javaScript:void(0)" onclick="hideStoreTime('sunday')" class="sun-div" {{isset($sunday->daystart_time) && $sunday->daystart_time != NULL ? 'style=display:block;' : 'style=display:none;'}}><i class="fa fa-close" style="margin-top:8px;"></i></a>
												<div id = "sun-open-event" {{isset($sunday->daystart_time) && $sunday->daystart_time != NULL ? 'style=display:none;' : 'style=display:block;'}}>
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
												<select class="form-control  mon-div" name="monday_open_time" {{isset($monday->daystart_time) && $monday->daystart_time != NULL ? 'style=display:block;' : 'style=display:none;'}}>
													@foreach(vendor_store_hours() as $time)
														<option value="{{$time->format('H:i')}}"{{ (old("monday_open_time", $monday->daystart_time) == $time->format('H:i') ? "selected":"") }}>{{$time->format('H:i')}}</option>
													@endforeach
												</select>
												<div id="mon-close" {{isset($monday->daystart_time) && $monday->daystart_time != NULL ? 'style=display:none;' : 'style=display:block;'}}>Closed</div>
												<input type="hidden" name="mon_status" id="mon-status" {{isset($monday->daystart_time) && $monday->daystart_time != NULL ? 'value=open' : 'value=closed'}}>
											</div>
											<div class="col-4">
												<select class="form-control  mon-div" name="monday_close_time" {{isset($monday->daystart_time) && $monday->daystart_time != NULL ? 'style=display:block;' : 'style=display:none;'}}>
													@foreach(vendor_store_hours() as $time)
														<option value="{{$time->format('H:i')}}"{{ (old("monday_close_time", $monday->dayend_time) == $time->format('H:i') ? "selected":"") }}>{{$time->format('H:i')}}</option>
													@endforeach
												</select>
											</div>
											<div class="col-4">
												<a href="javaScript:void(0)" onclick="hideStoreTime('monday')" class="mon-div" {{isset($monday->daystart_time) && $monday->daystart_time != NULL ? 'style=display:block;' : 'style=display:none;'}}><i class="fa fa-close" style="margin-top:8px;"></i></a>
												<div id = "mon-open-event" {{isset($monday->daystart_time) && $monday->daystart_time != NULL ? 'style=display:none;' : 'style=display:block;'}}>
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
												<select class="form-control  tue-div" name="tuesday_open_time" {{isset($tuesday->daystart_time) && $tuesday->daystart_time != NULL ? 'style=display:block;' : 'style=display:none;'}}>
													@foreach(vendor_store_hours() as $time)
														<option value="{{$time->format('H:i')}}"{{ (old("tuesday_open_time", $tuesday->daystart_time) == $time->format('H:i') ? "selected":"") }}>{{$time->format('H:i')}}</option>
													@endforeach
												</select>
												<div id="tue-close" {{isset($tuesday->daystart_time) && $tuesday->daystart_time != NULL ? 'style=display:none;' : 'style=display:block;'}}>Closed</div>
												<input type="hidden" name="tue_status" id="tue-status" {{isset($tuesday->daystart_time) && $tuesday->daystart_time != NULL ? 'value=open' : 'value=closed'}}>
											</div>
											<div class="col-4">
												<select class="form-control  tue-div" name="tuesday_close_time" {{isset($tuesday->daystart_time) && $tuesday->daystart_time != NULL ? 'style=display:block;' : 'style=display:none;'}}>
													@foreach(vendor_store_hours() as $time)
														<option value="{{$time->format('H:i')}}"{{ (old("tuesday_close_time", $tuesday->dayend_time) == $time->format('H:i') ? "selected":"") }}>{{$time->format('H:i')}}</option>
													@endforeach
												</select>
											</div>
											<div class="col-4">
												<a href="javaScript:void(0)" onclick="hideStoreTime('tuesday')" class="tue-div" {{isset($tuesday->daystart_time) && $tuesday->daystart_time != NULL ? 'style=display:block;' : 'style=display:none;'}}><i class="fa fa-close" style="margin-top:8px;"></i></a>
												<div id = "tue-open-event" {{isset($tuesday->daystart_time) && $tuesday->daystart_time != NULL ? 'style=display:none;' : 'style=display:block;'}}>
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
												<select class="form-control  wed-div" name="wednesday_open_time" {{isset($wednesday->daystart_time) && $wednesday->daystart_time != NULL ? 'style=display:block;' : 'style=display:none;'}}>
													@foreach(vendor_store_hours() as $time)
														<option value="{{$time->format('H:i')}}"{{ (old("wednesday_open_time", $wednesday->daystart_time) == $time->format('H:i') ? "selected":"") }}>{{$time->format('H:i')}}</option>
													@endforeach
												</select>
												<div id="wed-close" {{isset($wednesday->daystart_time) && $wednesday->daystart_time != NULL ? 'style=display:none;' : 'style=display:block;'}}>Closed</div>
												<input type="hidden" name="wed_status" id="wed-status" {{isset($wednesday->daystart_time) && $wednesday->daystart_time != NULL ? 'value=open' : 'value=closed'}}>
											</div>
											<div class="col-4">
												<select class="form-control  wed-div" name="wednesday_close_time" {{isset($wednesday->daystart_time) && $wednesday->daystart_time != NULL ? 'style=display:block;' : 'style=display:none;'}}>
													@foreach(vendor_store_hours() as $time)
														<option value="{{$time->format('H:i')}}"{{ (old("wednesday_close_time", $wednesday->dayend_time) == $time->format('H:i') ? "selected":"") }}>{{$time->format('H:i')}}</option>
													@endforeach
												</select>
											</div>
											<div class="col-4">
												<a href="javaScript:void(0)" onclick="hideStoreTime('wednesday')" class="wed-div" {{isset($wednesday->daystart_time) && $wednesday->daystart_time != NULL ? 'style=display:block;' : 'style=display:none;'}}><i class="fa fa-close" style="margin-top:8px;"></i></a>
												<div id = "wed-open-event" {{isset($wednesday->daystart_time) && $wednesday->daystart_time != NULL ? 'style=display:none;' : 'style=display:block;'}}>
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
												<select class="form-control  thu-div" name="thursday_open_time" {{isset($thursday->daystart_time) && $thursday->daystart_time != NULL ? 'style=display:block;' : 'style=display:none;'}}>
													@foreach(vendor_store_hours() as $time)
														<option value="{{$time->format('H:i')}}"{{ (old("thursday_open_time", $thursday->daystart_time) == $time->format('H:i') ? "selected":"") }}>{{$time->format('H:i')}}</option>
													@endforeach
												</select>
												<div id="thu-close" {{isset($thursday->daystart_time) && $thursday->daystart_time != NULL ? 'style=display:none;' : 'style=display:block;'}}>Closed</div>
												<input type="hidden" name="thu_status" id="thu-status" {{isset($thursday->daystart_time) && $thursday->daystart_time != NULL ? 'value=open' : 'value=closed'}}>
											</div>
											<div class="col-4">
												<select class="form-control  thu-div" name="thursday_close_time" {{isset($thursday->daystart_time) && $thursday->daystart_time != NULL ? 'style=display:block;' : 'style=display:none;'}}>
													@foreach(vendor_store_hours() as $time)
														<option value="{{$time->format('H:i')}}"{{ (old("thursday_close_time", $thursday->dayend_time) == $time->format('H:i') ? "selected":"") }}>{{$time->format('H:i')}}</option>
													@endforeach
												</select>
											</div>
											<div class="col-4">
												<a href="javaScript:void(0)" onclick="hideStoreTime('thursday')" class="thu-div" {{isset($thursday->daystart_time) && $thursday->daystart_time != NULL ? 'style=display:block;' : 'style=display:none;'}}><i class="fa fa-close" style="margin-top:8px;"></i></a>
												<div id = "thu-open-event" {{isset($thursday->daystart_time) && $thursday->daystart_time != NULL ? 'style=display:none;' : 'style=display:block;'}}>
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
												<select class="form-control  fri-div" name="friday_open_time" {{isset($friday->daystart_time) && $friday->daystart_time != NULL ? 'style=display:block;' : 'style=display:none;'}}>
													@foreach(vendor_store_hours() as $time)
														<option value="{{$time->format('H:i')}}"{{ (old("friday_open_time", $friday->daystart_time) == $time->format('H:i') ? "selected":"") }}>{{$time->format('H:i')}}</option>
													@endforeach
												</select>
												<div id="fri-close" {{isset($friday->daystart_time) && $friday->daystart_time != NULL ? 'style=display:none;' : 'style=display:block;'}}>Closed</div>
												<input type="hidden" name="fri_status" id="fri-status" {{isset($friday->daystart_time) && $friday->daystart_time != NULL ? 'value=open' : 'value=closed'}}>
											</div>
											<div class="col-4">
												<select class="form-control  fri-div" name="friday_close_time" {{isset($friday->daystart_time) && $friday->daystart_time != NULL ? 'style=display:block;' : 'style=display:none;'}}>
													@foreach(vendor_store_hours() as $time)
														<option value="{{$time->format('H:i')}}"{{ (old("friday_close_time", $friday->dayend_time) == $time->format('H:i') ? "selected":"") }}>{{$time->format('H:i')}}</option>
													@endforeach
												</select>
											</div>
											<div class="col-4">
												<a href="javaScript:void(0)" onclick="hideStoreTime('friday')" class="fri-div" {{isset($friday->daystart_time) && $friday->daystart_time != NULL ? 'style=display:block;' : 'style=display:none;'}}><i class="fa fa-close" style="margin-top:8px;"></i></a>
												<div id = "fri-open-event" {{isset($friday->daystart_time) && $friday->daystart_time != NULL ? 'style=display:none;' : 'style=display:block;'}}>
													<a href="javaScript:void(0)" onclick="showStoreTime('friday')"><i class="fa fa-plus" style="margin-top:6px;"></i></a>
												</div>
											</div>
										</div>
									</div>
								</td>
							</tr>
							<tr>
								<td width="20%">Saturday</td>
								<td width="60%">
									<div id="sat-div">
										<div class="row">
											<div class="col-4">
												<select class="form-control  sat-div" name="saturday_open_time" {{isset($saturday->daystart_time) && $saturday->daystart_time != NULL ? 'style=display:block;' : 'style=display:none;'}}>
													@foreach(vendor_store_hours() as $time)
														<option value="{{$time->format('H:i')}}"{{ (old("saturday_open_time", $saturday->daystart_time) == $time->format('H:i') ? "selected":"") }}>{{$time->format('H:i')}}</option>
													@endforeach
												</select>
												<div id="sat-close" {{isset($saturday->daystart_time) && $saturday->daystart_time != NULL ? 'style=display:none;' : 'style=display:block;'}}>Closed</div>
												<input type="hidden" name="sat_status" id="sat-status" {{isset($saturday->daystart_time) && $saturday->daystart_time != NULL ? 'value=open' : 'value=closed'}}>
											</div>
											<div class="col-4">
												<select class="form-control  sat-div" name="saturday_close_time" {{isset($saturday->daystart_time) && $saturday->daystart_time != NULL ? 'style=display:block;' : 'style=display:none;'}}>
													@foreach(vendor_store_hours() as $time)
														<option value="{{$time->format('H:i')}}"{{ (old("saturday_close_time", $saturday->dayend_time) == $time->format('H:i') ? "selected":"") }}>{{$time->format('H:i')}}</option>
													@endforeach
												</select>
											</div>
											<div class="col-4">
												<a href="javaScript:void(0)" onclick="hideStoreTime('saturday')" class="sat-div" {{isset($saturday->daystart_time) && $saturday->daystart_time != NULL ? 'style=display:block;' : 'style=display:none;'}}><i class="fa fa-close" style="margin-top:8px;"></i></a>
												<div id = "sat-open-event" {{isset($saturday->daystart_time) && $saturday->daystart_time != NULL ? 'style=display:none;' : 'style=display:block;'}}>
													<a href="javaScript:void(0)" onclick="showStoreTime('saturday')"><i class="fa fa-plus" style="margin-top:6px;"></i></a>
												</div>
											</div>
										</div>
									</div>
								</td>
							</tr>
						</table>
					</div>
					@else
					<div class="table-responsive">
						<table id="store_tbl" class="table table-borderless">
							<tr>
								<td width="20%">Sunday</td>
								<td width="60%">
									<div id="sun-div">
										<div class="row">
											<div class="col-4">
												<select class="form-control  sun-div" name="sunday_open_time" style="display:none;">
													@foreach(vendor_store_hours() as $time)
														@php $open = '';
															if($time->format('H:i') == "09:00"){
																$open = 'selected="selected"';
															}
														@endphp
														<option value="{{$time->format('H:i')}}"{{$open}}>{{$time->format('H:i')}}</option>
													@endforeach
												</select>
												<div id="sun-close" style="display: block;">Closed</div>
												<input type="hidden" name="sun_status" id="sun-status" value="closed">
											</div>
											<div class="col-4">
												<select class="form-control  sun-div" name="sunday_close_time" style="display:none;">
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
												<a href="javaScript:void(0)" onclick="hideStoreTime('sunday')" class="sun-div" style="display:none;"><i class="fa fa-close" style="margin-top:8px;"></i></a>
												<div id = "sun-open-event" style="display:block;">
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
												<select class="form-control  mon-div" name="monday_open_time" style="display:none;">
													@foreach(vendor_store_hours() as $time)
														@php $open = '';
															if($time->format('H:i') == "09:00"){
																$open = 'selected="selected"';
															}
														@endphp
														<option value="{{$time->format('H:i')}}"{{$open}}>{{$time->format('H:i')}}</option>
													@endforeach
												</select>
												<div id="mon-close" style="display: block;">Closed</div>
												<input type="hidden" name="mon_status" id="mon-status" value="closed">
											</div>
											<div class="col-4">
												<select class="form-control  mon-div" name="monday_close_time" style="display:none;">
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
												<a href="javaScript:void(0)" onclick="hideStoreTime('monday')" class="mon-div" style="display:none;"><i class="fa fa-close" style="margin-top:8px;"></i></a>
												<div id = "mon-open-event" style="display:block;">
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
												<select class="form-control  tue-div" name="tuesday_open_time" style="display:none;">
													@foreach(vendor_store_hours() as $time)
														@php $open = '';
															if($time->format('H:i') == "09:00"){
																$open = 'selected="selected"';
															}
														@endphp
														<option value="{{$time->format('H:i')}}"{{$open}}>{{$time->format('H:i')}}</option>
													@endforeach
												</select>
												<div id="tue-close" style="display: block;">Closed</div>
												<input type="hidden" name="tue_status" id="tue-status" value="closed">
											</div>
											<div class="col-4">
												<select class="form-control  tue-div" name="tuesday_close_time" style="display:none;">
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
												<a href="javaScript:void(0)" onclick="hideStoreTime('tuesday')" class="tue-div" style="display:none;"><i class="fa fa-close" style="margin-top:8px;"></i></a>
												<div id = "tue-open-event" style="display:block;">
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
												<select class="form-control  wed-div" name="wednesday_open_time" style="display:none;">
													@foreach(vendor_store_hours() as $time)
														@php $open = '';
															if($time->format('H:i') == "09:00"){
																$open = 'selected="selected"';
															}
														@endphp
														<option value="{{$time->format('H:i')}}"{{$open}}>{{$time->format('H:i')}}</option>
													@endforeach
												</select>
												<div id="wed-close" style="display: block;">Closed</div>
												<input type="hidden" name="wed_status" id="wed-status" value="closed">
											</div>
											<div class="col-4">
												<select class="form-control  wed-div" name="wednesday_close_time" style="display:none;">
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
												<a href="javaScript:void(0)" onclick="hideStoreTime('wednesday')" class="wed-div" style="display:none;"><i class="fa fa-close" style="margin-top:8px;"></i></a>
												<div id = "wed-open-event" style="display:block;">
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
												<select class="form-control  thu-div" name="thursday_open_time" style="display:none;">
													@foreach(vendor_store_hours() as $time)
														@php $open = '';
															if($time->format('H:i') == "09:00"){
																$open = 'selected="selected"';
															}
														@endphp
														<option value="{{$time->format('H:i')}}"{{$open}}>{{$time->format('H:i')}}</option>
													@endforeach
												</select>
												<div id="thu-close" style="display: block;">Closed</div>
												<input type="hidden" name="thu_status" id="thu-status" value="closed">
											</div>
											<div class="col-4">
												<select class="form-control  thu-div" name="thursday_close_time" style="display:none;">
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
												<a href="javaScript:void(0)" onclick="hideStoreTime('thursday')" class="thu-div" style="display:none;"><i class="fa fa-close" style="margin-top:8px;"></i></a>
												<div id = "thu-open-event" style="display:block;">
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
												<select class="form-control  fri-div" name="friday_open_time" style="display:none;">
													@foreach(vendor_store_hours() as $time)
														@php $open = '';
															if($time->format('H:i') == "09:00"){
																$open = 'selected="selected"';
															}
														@endphp
														<option value="{{$time->format('H:i')}}"{{$open}}>{{$time->format('H:i')}}</option>
													@endforeach
												</select>
												<div id="fri-close" style="display: block;">Closed</div>
												<input type="hidden" name="fri_status" id="fri-status" value="closed">
											</div>
											<div class="col-4">
												<select class="form-control  fri-div" name="friday_close_time" style="display:none;">
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
												<a href="javaScript:void(0)" onclick="hideStoreTime('friday')" class="fri-div" style="display:none;"><i class="fa fa-close" style="margin-top:8px;"></i></a>
												<div id = "fri-open-event" style="display:block;">
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
												<select class="form-control  sat-div" name="saturday_open_time" style="display:none;">
													@foreach(vendor_store_hours() as $time)
														@php $open = '';
															if($time->format('H:i') == "09:00"){
																$open = 'selected="selected"';
															}
														@endphp
														<option value="{{$time->format('H:i')}}"{{$open}}>{{$time->format('H:i')}}</option>
													@endforeach
												</select>
												<div id="sat-close" style="display: block;">Closed</div>
												<input type="hidden" name="sat_status" id="sat-status" value="closed">
											</div>
											<div class="col-4">
												<select class="form-control  sat-div" name="saturday_close_time" style="display:none;">
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
												<a href="javaScript:void(0)" onclick="hideStoreTime('saturday')" class="sat-div" style="display:none;"><i class="fa fa-close" style="margin-top:8px;"></i></a>
												<div id = "sat-open-event" style="display:block;">
													<a href="javaScript:void(0)" onclick="showStoreTime('saturday')"><i class="fa fa-plus" style="margin-top:6px;"></i></a>
												</div>
											</div>
										</div>
									</div>
								</td>
							</tr>
						</table>
					</div>
					@endif
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
<!--End Row-->
<script>
$('#autoclose-datepicker').datepicker({
	autoclose: true,
	todayHighlight: true
});
var countryID = "{{old('country', $vendor_store->country)}}";
var stateID = "{{old('state', $vendor_store->state)}}";
var cityID = "{{old('city', $vendor_store->city)}}";

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
		// $("#abcd").css('display','block');

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

</script>
@endsection
