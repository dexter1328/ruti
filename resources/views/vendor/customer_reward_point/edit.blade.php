@extends('vendor.layout.main')
@section('content')
<div class="row">
	<div class="col-lg-12">
		<div class="card">
			<div class="card-header">
				<div class="left"><span>Edit Customer Reward Point</span></div>
				<div class="right">
					<button onclick="goBack()" class="btn btn-block btn-primary">Go Back</button>
				</div>
			</div>
			<div class="card-body">
				@if ($errors->any())
					<div class="alert alert-danger alert-dismissible">
						<button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
						<ul>
							@foreach ($errors->all() as $error)
								<li>{{ $error }}</li>
							@endforeach
						</ul>
					</div>
				@endif
				<form id="signupForm" method="post" action="{{route('vendor.customer_reward_points.update',$customer_reward_point->id)}}" enctype="multipart/form-data">
					@csrf
					@method('PATCH')
					<div class="form-group row">
						<label for="user" class="col-sm-2 col-form-label">User<span class="text-danger">*</span></label>
						<div class="col-sm-4">
							<select name="user" id="user" class="form-control">
								<option value="">Select User</option>
								@foreach($users as $user)
									<option value="{{$user->id}}" {{ (old("user", $customer_reward_point->user_id) == $user->id ? "selected":"") }}>{{$user->first_name.' '.$user->last_name}}</option>
								@endforeach
							</select>
							@if ($errors->has('user'))
								<span class="text-danger">{{ $errors->first('user') }}</span>
							@endif
						</div>
						<label for="reward_type" class="col-sm-2 col-form-label">Reward Type<span class="text-danger">*</span></label>
						<div class="col-sm-4">
							<select name="reward_type" id="reward_type" class="form-control">
								<option value="">Select Reward Type</option>
								@foreach($reward_types as $reward_type)
									<option value="{{$reward_type->reward_type.'||'.$reward_type->reward_points}}" {{ (old("reward_type", $customer_reward_point->reward_type.'||'.$customer_reward_point->reward_point) == $reward_type->reward_type.'||'.$reward_type->reward_points ? "selected":"") }}>{{$reward_type->reward_type}}</option>
								@endforeach
							</select>
							@if ($errors->has('reward_type'))
								<span class="text-danger">{{ $errors->first('reward_type') }}</span>
							@endif
						</div>
					</div>
					<div class="form-group row">
						<label for="information" class="col-sm-2 col-form-label">Information</label>
						<div class="col-sm-10">
							<textarea class="form-control" name="information" id="information">{{old('information', $customer_reward_point->information)}}</textarea>
							@if ($errors->has('information'))
								<span class="text-danger">{{ $errors->first('information') }}</span>
							@endif
						</div>
					</div>
					<center>
						<div class="form-footer">
							<button type="submit" class="btn btn-success"><i class="fa fa-check-square-o"></i> SAVE</button>
							<a href="{{url('vendor/customer_reward_points')}}"><button type="button" class="btn btn-danger"><i class="fa fa-times"></i> CANCEL</button></a> 
						</div>
					</center>
				</form>
			</div>
		</div>
	</div>
</div>
<!--End Row-->
<script type="text/javascript">
	function goBack() {
		window.history.back();
	}
</script>
@endsection 