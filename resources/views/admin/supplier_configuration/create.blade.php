@extends('admin.layout.main')

@section('content')

<div class="row">
	<div class="col-lg-12">
		<div class="card">
			<div class="card-header">
				<div class="left"><!-- <i class="fa fa-cog"></i> --><span>Add Configuration</span></div>
			</div>
			<div class="card-body">
            	<div class="container-fluid">
					<form id="signupForm" method="post" action="{{ route('vendor_configuration.store') }}" enctype="multipart/form-data">
					@csrf
					<div class="form-group row">
						<label for="input-10" class="col-sm-2 col-form-label">Vendor<span class="text-danger">*</span></label>
						<div class="col-sm-4">
							<select class="form-control" name="vendor_id">
								<option value="">Select vendor</option>
								@foreach($vendors as $vendor)
									<option value="{{$vendor->id}}" {{ (old("vendor_id") == $vendor->id ? "selected":"") }}>{{$vendor->name}}</option>
								@endforeach
							</select>
							@if ($errors->has('vendor_id'))
								<span class="text-danger">{{ $errors->first('vendor_id') }}</span>
							@endif	
						</div>
						<label for="input-11" class="col-sm-2 col-form-label">Payment gateway<span class="text-danger">*</span></label>
						<div class="col-sm-4">
							<input type="text" class="form-control" id="input-11" name="payment_gateway" placeholder="Enter Payment Gateway" value="{{old('payment_gateway')}}">
							@if ($errors->has('payment_gateway'))
								<span class="text-danger">{{ $errors->first('payment_gateway') }}</span>
							@endif
						</div>
					</div>
					<div class="form-group row">
						<label for="input-12" class="col-sm-2 col-form-label">Client Id<span class="text-danger">*</span></label>
						<div class="col-sm-4">
							<input type="text" class="form-control" id="input-13" name="client_id" placeholder="Enter Client Id" value="{{old('client_id')}}">
							@if ($errors->has('client_id'))
								<span class="text-danger">{{ $errors->first('client_id') }}</span>
							@endif
						</div>
						<label for="input-13" class="col-sm-2 col-form-label">Client Secret<span class="text-danger">*</span></label>
						<div class="col-sm-4">
							<input type="text" class="form-control" id="input-13" name="client_secret" placeholder="Enter Clioent Secret" value="{{old('client_secret')}}">
							@if ($errors->has('client_secret'))
								<span class="text-danger">{{ $errors->first('client_secret') }}</span>
							@endif
						</div>
					</div>
					<center>
						<div class="form-footer">
							<button type="submit" class="btn btn-success"><i class="fa fa-check-square-o"></i> SAVE</button>
						</div>
					</center>
				</form>
                </div>
			</div>
		</div>
	</div>
</div>
<!--End Row--> 

@endsection 