@extends('admin.layout.main')
@section('content')
<style type="text/css">
	.place{
		margin-top: 7px;
	}
</style>
<div class="row">
	<div class="col-lg-12">
		<div class="card">
			<div class="card-header">
				<div class="left"><!-- <i class="fa fa-lightbulb-o"></i> --><span>Suggested Place</span></div>
				<div class="right">
					
				</div>
			</div>
			<div class="card-body">
            	<div class="container-fluid">
            		<form id="signupForm" method="post" action="{{ url('/admin/suggested-place/send', $suggested_place->id) }}" enctype="multipart/form-data">
					@csrf
	            		<div class="form-group row">
							<label for="input-10" class="col-sm-2 col-form-label">User</label>
							<div class="col-sm-10">
								<label class="place">{{$suggested_place->first_name}} {{$suggested_place->last_name}}</label>
							</div>
						</div>
						<div class="form-group row">
							<label for="input-10" class="col-sm-2 col-form-label">Store</label>
							<div class="col-sm-10">
								<label class="place">{{$suggested_place->store}}</label>
							</div>
						</div>
						<div class="form-group row">
							<label for="input-10" class="col-sm-2 col-form-label">Address</label>
							<div class="col-sm-10">
								<label class="place" style="text-align:justify;">{{$suggested_place->address}}</label>
							</div>
						</div>
						<div class="form-group row">
							<label for="input-10" class="col-sm-2 col-form-label">Email</label>
							<div class="col-sm-10">
								<label class="place">{{$suggested_place->email}} </label>
							</div>
						</div>
						<div class="form-group row">
							<label for="input-10" class="col-sm-2 col-form-label">Mobile No</label>
							<div class="col-sm-10">
								<label class="place">{{$suggested_place->mobile_no}}</label>
							</div>
						</div>
						<div class="form-group row">
							<label for="input-10" class="col-sm-2 col-form-label">Send Email</label>
							<div class="col-sm-10">
								<select name="user[]" class="form-control"  multiple="multiple" id="user_id">
									@foreach($users as $user)
										<option value="{{$user->id}}">{{$user->first_name}}</option>
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
</div>
<!--End Row-->
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
    });
</script> 
@endsection 