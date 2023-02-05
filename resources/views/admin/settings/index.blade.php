@extends('admin.layout.main')
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
					<form id="signupForm" method="post" action="{{ route('settings.store') }}" enctype="multipart/form-data">
					@csrf
					<div class="form-group row">
						<label class="col-sm-12 col-form-label">Reward Points</label>
					</div>
					<div class="form-group row">
						<label for="input-13" class="col-sm-2 col-form-label">Reward point max % per order<span class="text-danger">*</span></label>
						<div class="col-sm-10">
							<input type="text" class="form-control" id="input-8" name="setting[reward_point_max_per_order]" value="{{isset($setting['reward_point_max_per_order'])?$setting['reward_point_max_per_order']:''}}">
							@if ($errors->has('setting.reward_point_max_per_order')) 
								<span class="text-danger">{{ $errors->first('setting.reward_point_max_per_order') }}</span> 
							@endif 
						</div>
					</div>
					<div class="form-group row">
						<label class="col-sm-12 col-form-label">Suspend Customer Account</label>
					</div>
					<div class="form-group row">
						<label for="input-13" class="col-sm-2 col-form-label">Cancel/Return Order Limit<span class="text-danger">*</span></label>
						<div class="col-sm-10">
							<input type="text" class="form-control" id="input-8" name="setting[cancel_return_order_limit]" value="{{isset($setting['cancel_return_order_limit'])?$setting['cancel_return_order_limit']:''}}">
							@if ($errors->has('setting.cancel_return_order_limit')) 
								<span class="text-danger">{{ $errors->first('setting.cancel_return_order_limit') }}</span> 
							@endif 
						</div>
					</div>
					<div class="form-group row">
						<label class="col-sm-12 col-form-label">Price Drop Alert</label>
					</div>
					<div class="form-group row">
						<label for="input-13" class="col-sm-2 col-form-label">Price Drop Alert %<span class="text-danger">*</span></label>
						<div class="col-sm-10">
							<input type="text" class="form-control" id="input-8" name="setting[price_drop_alert]" value="{{isset($setting['price_drop_alert'])?$setting['price_drop_alert']:''}}">
							@if ($errors->has('setting.price_drop_alert')) 
								<span class="text-danger">{{ $errors->first('setting.price_drop_alert') }}</span> 
							@endif 
						</div>
					</div>
					<div class="form-group row">
						<label class="col-sm-12 col-form-label">Customer Near By Store Radius Limit</label>
					</div>
					<div class="form-group row">
						<label for="input-13" class="col-sm-2 col-form-label">Customer Store Radius (miles)<span class="text-danger">*</span></label>
						<div class="col-sm-10">
							<input type="text" class="form-control" id="input-8" name="setting[customer_store_radius]" value="{{isset($setting['customer_store_radius'])?$setting['customer_store_radius']:''}}">
							@if ($errors->has('setting.customer_store_radius')) 
								<span class="text-danger">{{ $errors->first('setting.customer_store_radius') }}</span> 
							@endif 
						</div>
					</div>
					<center>
					@if(has_permission(Auth::user()->role_id,'setting','write') )
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