@extends('vendor.layout.main')
@section('content')

<div class="row">
	<div class="col-lg-12">
		<div class="card">
			<div class="card-header">
				<div class="left"><span>Send Newsletter</span></div>
			</div>
			<div class="card-body">
				<form id="signupForm" method="post" action="{{ url('/vendor/newsletters/send', $newsletter->id) }}" enctype="multipart/form-data">
					@csrf
					@if($errors->has('notification_user'))
						<span class="text-danger">{{ $errors->first('notification_user')}}</span>
					@endif
					@if ($errors->has('user'))
						<span class="text-danger">{{ $errors->first('user') }}</span>
					@endif
					<br>
					@if ($errors->has('vendor'))
						<span class="text-danger">{{ $errors->first('vendor') }}</span>
					@endif
					<div class="form-group row">
						<label for="input-10" class="col-sm-2 col-form-label">Subject</label>
						<div class="col-sm-10">
							{{$newsletter->subject_name}}
						</div>
					</div>
					<div class="form-group row">
						<label for="input-11" class="col-sm-2 col-form-label">Description</label>
						<div class="col-sm-10"  style="text-align: justify;">
							{!! $newsletter->description !!}
						</div>
					</div>
					<div class="form-group row">
						<label for="input-13" class="col-sm-2 col-form-label">User<span class="text-danger">*</span></label>
						<div class="col-sm-10">
							<select name="notification_user" class="form-control" id="notification_user">
								<option value="">Select User</option>
								<option value="both">All</option>
								<option value="user">Customer</option>
								<option value="vendor">Vendor</option>
							</select>
						</div>
					</div>
					<div class="form-group row" id="user">
						<label for="input-13" class="col-sm-2 col-form-label">Customer<span class="text-danger">*</span></label>
						<div class="col-sm-10">
							<select name="user[]" class="form-control"  multiple="multiple" id="user_id">
								@foreach($users as $user)
									<option value="{{$user->id}}">{{$user->first_name}}</option>
								@endforeach
							</select>
						</div>
					</div>
					<div class="form-group row" id="vendor">
						<label for="input-13" class="col-sm-2 col-form-label">Vendor<span class="text-danger">*</span></label>
						<div class="col-sm-10">
							<select name="vendor[]" class="form-control" multiple="multiple" id="vendor_id">
								@foreach($vendors as $vendor)
									<option value="{{$vendor->id}}">{{$vendor->name}}</option>
								@endforeach
							</select>
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
	$(document).ready(function() {
    	$('#user_id').multiselect({
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

    	$('#subscribers_id').multiselect({
			allSelectedText: 'All',
      		includeSelectAllOption: true,
	        nonSelectedText: 'Select Subscribers',
	        buttonWidth: '100%',
	        maxHeight: 500,
	        maxWidth: 500,
    	});

    	$('#user').hide();

    	$('#vendor').hide();

    	$("#subscribers").hide();

    $("#notification_user").change(function() {
        var value = $(this).val();

        if(value == 'user'){

        	$('#user').show();
        	$('#vendor').hide();

        }else if(value == 'vendor'){
        	$('#vendor').show();
        	$('#user').hide();
        }else if(value == 'both'){
        	$('#vendor').show();
        	$('#user').show();
        }
    });

   });
</script>
@endsection 