@extends('supplier.layout.main')
@section('content')

<div class="row">
	<div class="col-lg-12">
		<div class="card">
			<div class="card-header">
				<div class="left">
					<span>Add Customer Used Reward Point</span>
				</div>
			</div>
			<div class="card-body">
            	<div class="container-fluid">
					<form id="signupForm" method="post" action="{{route('supplier.customer_used_reward_points.store')}}" enctype="multipart/form-data">
					@csrf
					<div class="form-group row">
						<label for="order" class="col-sm-2 col-form-label">Order<span class="text-danger">*</span></label>
						<div class="col-sm-4">
							<select name="order" id="order" class="form-control">
								<option value="">Select Order</option>
								@foreach($orders as $order)
									<option value="{{$order->id.'||'.$order->customer_id}}" {{ (old("order") == $order->id.'||'.$order->customer_id ? "selected":"") }}>{{'#'.$order->order_no.' - '.$order->first_name}}</option>
								@endforeach
							</select>
							@if ($errors->has('order'))
								<span class="text-danger">{{ $errors->first('order') }}</span>
							@endif
						</div>
						<label for="reward_points" class="col-sm-2 col-form-label">Reward Points<span class="text-danger">*</span></label>
						<div class="col-sm-4">
							<input type="number" class="form-control" name="reward_points" id="reward_points" value="{{old('reward_points')}}" placeholder="Enter Reward Points">
							@if ($errors->has('reward_points'))
								<span class="text-danger">{{ $errors->first('reward_points') }}</span>
							@endif
						</div>
					</div>
					<center>
						<div class="form-footer">
							<button type="submit" class="btn btn-success"><i class="fa fa-check-square-o"></i> SAVE</button>
							<a href="{{url('supplier/customer_used_reward_points')}}"><button type="button" class="btn btn-danger"><i class="fa fa-times"></i> CANCEL</button></a>
						</div>
					</center>
					</form>
                </div>
			</div>
		</div>
	</div>
</div>
@endsection
