@extends('supplier.layout.main')
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
					<form id="signupForm" method="post" action="{{ route('supplier.settings.store') }}" enctype="multipart/form-data"> 
						@csrf
						<!-- <div class="form-group row">
							<label class="col-sm-12 col-form-label">Suspend Customer Account</label>
						</div> -->
						<div class="form-group row">
							<label for="input-13" class="col-sm-3 col-form-label">Inventory Update Reminder<span class="text-danger">*</span></label>
							<div class="col-sm-6">
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
							<div class="col-sm-3 text-center">
								@if(vendor_has_permission(Auth::user()->role_id,'setting','write') )
							
										<button type="submit" class="btn btn-success"><i class="fa fa-check-square-o"></i> SAVE</button>
							
								@endif
							</div>
						</div>
					</form>
                </div>

				{{-- for supplier type --}}
	
				<table class="table table-bordered">
					<thead>
					  <tr>
						<th colspan="3" >Current Fullfill type: <span style="font-weight: bold; color:darkgoldenrod; font-size:15px;"> {{Auth::user()->fullfill_type}}</span></th>
					  </tr>
					</thead>
					<form action="{{route('fullfill_type_change',$fullfill_type->id)}}" enctype="multipart/form-data" method="post">
						@csrf
					<tbody>
					  <tr>
						<td style="width: 25%" ><input type="radio" id="full-fill" name="fullfill_type" value="seller_fullfill" {{$fullfill_type->fullfill_type == 'seller_fullfill' ? "checked" : ""}} required> Seller Fullfill</td>
						<td>Seller fulfill means wholesalers product will be shipped to Seller designated location.</td>
						<td rowspan="2" class="text-center"><button type="submit" class="btn btn-success"><i class="fa fa-check-square-o"></i> Change Type</button></td>
					  </tr>
					  <tr>
						<td style="width: 25%" ><input type="radio" id="full-fill" name="fullfill_type" value="ruti_fullfill" {{$fullfill_type->fullfill_type == 'ruti_fullfill' ? "checked" : ""}} required> Ruti Fullfill</td>
						<td>Ruti fulfill comes with a cost at $39 per month. And wholesalers will ship to Ruti warehouse. Ruti will distribute seller products to customer/buyer when they buy</td>
					  </tr>
					</tbody>
					</form>
				  </table>
				
				<div class="mt-5">
					<form id="signupForm" method="post" action="{{ route('setReminderToBuyer') }}" enctype="multipart/form-data"> 
						@csrf
						<div class="form-group row">
							<label for="input-13" class="col-sm-3 col-form-label">Buyer purchasing Reminder<span class="text-danger">*</span></label>
							<div class="col-sm-6">
								<div class="input-group mb-3">
									<select class="form-control" name="dayValue" required>
										<option value="">Select Day</option>
										@foreach(weekdays() as $value)
											<option value="{{$value}}">{{$value}}</option>
										@endforeach
									</select>
									<input type="time" class="form-control" name="timeValue" required>
								</div>
							</div>
							<div class="col-sm-3 text-center">
								@if(vendor_has_permission(Auth::user()->role_id,'setting','write') )
								<button type="submit" class="btn btn-success"><i class="fa fa-check-square-o"></i> SAVE</button>
								@endif
							</div>
						</div>
					</form>
                </div>

			</div>
		</div>
	</div>
</div>
<!--End Row-->
@endsection
