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
				<div class="left"><!-- <i class="fa fa-cog"></i> --><span>Settings</span></div>
			</div>
			<div class="card-body">
            	<div class="container-fluid">
					<form id="signupForm" method="post" action="{{ route('vendor.settings.store') }}" enctype="multipart/form-data">
						@csrf
						<!-- <div class="form-group row">
							<label class="col-sm-12 col-form-label">Suspend Customer Account</label>
						</div> -->
						<div class="form-group row">
							<label for="input-13" class="col-sm-3 col-form-label">Inventory Update Reminder<span class="text-danger">*</span></label>
							<div class="col-sm-9">
								<div class="input-group mb-3">
									<select class="form-control" name="setting[inventory_update_reminder_day]">
										<option value="">Select Day</option>
										@foreach(weekdays() as $value)
											@php $selected = '';
											if(isset($setting['inventory_update_reminder_day']) && $value == $setting['inventory_update_reminder_day']) {
												$selected = 'selected="selected"';
											} @endphp
											<option value="{{$value}}" {{$selected}}>{{$value}}</option>
										@endforeach
									</select>
									<select class="form-control" name="setting[inventory_update_reminder_time]">
										<option value="">Select Time</option>
										@foreach(vendor_store_hours() as $time)
											@php $selected = '';
											if(isset($setting['inventory_update_reminder_time']) && $time->format('H:i') == $setting['inventory_update_reminder_time']) {
												echo $selected = 'selected="selected"';
											} @endphp
											<option value="{{$time->format('H:i')}}" {{$selected}}>{{$time->format('H:i')}}</option>
										@endforeach
									</select>
								</div>
								@if ($errors->has('setting.inventory_update_reminder_day') || $errors->has('setting.inventory_update_reminder_time')) 
									<span class="text-danger">Inventory update reminder day and time fields are required.</span> 
								@endif 
							</div>
						</div>
						@if(vendor_has_permission(Auth::user()->role_id,'setting','write') )
						<center>
							<div class="form-footer">
								<button type="submit" class="btn btn-success"><i class="fa fa-check-square-o"></i> SAVE</button>
							</div>
						</center>
						@endif
					</form>
                </div>
			</div>
		</div>
	</div>
</div>
<!--End Row--> 
@endsection 