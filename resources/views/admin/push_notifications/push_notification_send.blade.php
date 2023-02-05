@extends('admin.layout.main')
@section('content')
<div class="row">
	<div class="col-lg-12">
		<div class="card">
			<div class="card-header">
				<div class="left"><span>Send Push Notification</span></div>
			</div>
			<div class="card-body">
				<form id="signupForm" method="post" action="{{ url('/admin/push_notifications/send', $push_notification->id) }}" enctype="multipart/form-data">
					@csrf
					<div class="form-group row">
						<label for="input-10" class="col-sm-2 col-form-label">Title</label>
						<div class="col-sm-10">
							{{$push_notification->title}}
						</div>
					</div>
					<div class="form-group row">
						<label for="input-11" class="col-sm-2 col-form-label">Description</label>
						<div class="col-sm-10" style="text-align: justify;">
							{!! $push_notification->description !!}
						</div>
					</div>
					<div class="form-group row">
						<label for="input-13" class="col-sm-2 col-form-label">User Type<span class="text-danger">*</span></label>
						<div class="col-sm-10">
							<select name="user_type" class="form-control" id="user_type">
								<option value="">Select User Type</option>
								<option value="both" @if(old('user_type') == 'both') selected="selected" @endif>All</option>
								<option value="customer" @if(old('user_type') == 'customer') selected="selected" @endif>Customer</option>
								<option value="vendor" @if(old('user_type') == 'vendor') selected="selected" @endif>Vendor</option>
							</select>
							@if ($errors->has('user_type'))
								<span class="text-danger">{{ $errors->first('user_type') }}</span>
							@endif
						</div>
					</div>
					<div class="form-group row" id="customer" style="display: none;">
						<label for="input-13" class="col-sm-2 col-form-label">Customer<span class="text-danger">*</span></label>
						<div class="col-sm-10">
							<select name="customer[]" class="form-control"  multiple="multiple" id="customer_id">
								@foreach($customers as $customer)
									<option value="{{$customer->id}}">{{$customer->first_name}}</option>
								@endforeach
							</select>
							@if ($errors->has('customer'))
								<span class="text-danger">{{ $errors->first('customer') }}</span>
							@endif
						</div>
					</div>
					<div class="form-group row" id="vendor" style="display: none;">
						<label for="input-13" class="col-sm-2 col-form-label">Vendor<span class="text-danger">*</span></label>
						<div class="col-sm-10">
							<select name="vendor[]" class="form-control" multiple="multiple" id="vendor_id">
								@foreach($vendors as $vendor)
									<option value="{{$vendor->id}}">{{$vendor->name}}</option>
								@endforeach
							</select>
							@if ($errors->has('vendor'))
								<span class="text-danger">{{ $errors->first('vendor') }}</span>
							@endif
						</div>
					</div>
					<center>
						<div class="form-footer">
							<button type="submit" class="btn btn-success"><i class="fa fa-check-square-o"></i> Send</button>
						</div>
					</center>
				</form>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
	var user_type = "{{old('user_type')}}";

	$(document).ready(function() {

		showHideUserType();

    	$('#customer_id').multiselect({
			allSelectedText: 'All',
      		includeSelectAllOption: true,
	        nonSelectedText: 'Select Customer',
	        buttonWidth: '100%',
	        maxHeight: 500,
	        maxWidth: 500,
    	});

    	$('#vendor_id').multiselect({
			allSelectedText: 'All',
      		includeSelectAllOption: true,
	        nonSelectedText: 'Select Vendor',
	        buttonWidth: '100%',
	        maxHeight: 500,
	        maxWidth: 500,
    	});

	    $("#user_type").change(function() {
	        
	        user_type = $(this).val();
	        showHideUserType()
	    });
   	});

	function showHideUserType()
	{
		if(user_type == 'customer'){
        	$('#customer').show();
        	$('#vendor').hide();
        }else if(user_type == 'vendor'){
        	$('#vendor').show();
        	$('#customer').hide();
        }else if(user_type == 'both'){
        	$('#vendor').show();
        	$('#customer').show();
        }
	}
</script>
@endsection 