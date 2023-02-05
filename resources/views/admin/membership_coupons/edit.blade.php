@extends('admin.layout.main')
@section('content')
<div class="row">
	<div class="col-lg-12">
		<div class="card">
			<div class="card-header">
				<div class="left"><!-- <i class="fa fa-group"></i> --><span>Edit Memership Coupon</span>
				</div>
			</div>
			<div class="card-body">
            	<div class="container-fluid">
					<form id="signupForm" method="post" action="{{ route('membership-coupons.update',$coupon->id) }}" enctype="multipart/form-data">
						@csrf
						@method('PATCH')
						<div class="form-group row">
							<label for="input-13" class="col-sm-2 col-form-label">Coupon Code<span class="text-danger">*</span></label>
							<div class="col-sm-10">
								<select name="coupon_code" id="coupon_code" class="form-control" disabled>
									<option value="">Select Coupon Code</option>
									@foreach($membership_coupons as $key => $membership_coupon)
										<option value="{{$key}}" @if($coupon->code==$key) selected="selected" @endif>{{$membership_coupon}}</option>
									@endforeach
								</select>
								@if ($errors->has('coupon_code'))
									<span class="text-danger">{{ $errors->first('coupon_code') }}</span>
								@endif
							</div>
						</div>
						<div class="form-group row">
							<label for="input-11" class="col-sm-2 col-form-label">Name<span class="text-danger">*</span></label>
							<div class="col-sm-10">
								<input type="text" class="form-control" id="name" name="name" placeholder="Enter Name" value="{{$coupon->name}}">
								@if ($errors->has('name'))
									<span class="text-danger">{{ $errors->first('name') }}</span>
								@endif
							</div>
						</div>
						<div class="form-group row">
							<label for="input-11" class="col-sm-2 col-form-label">Type<span class="text-danger">*</span></label>
							<div class="col-sm-10">
								<select name="type" id="type" class="form-control" disabled>
									<option value="">Select Type</option>
										<option value="percentage_discount" @if($coupon->type=='percentage_discount') selected="selected" @endif>Percentage discount</option>
										<option value="fixed_amount_discount" @if($coupon->type=='fixed_amount_discount') selected="selected" @endif>Fixed amount discount</option>
								</select>
								@if ($errors->has('type'))
									<span class="text-danger">{{ $errors->first('type') }}</span>
								@endif
							</div>
						</div>
						<div class="form-group row">
							<label for="input-10" class="col-sm-2 col-form-label">Amount<span class="text-danger">*</span></label>
							<div class="col-sm-10">
								<input type="text" class="form-control" name="amount" placeholder="Enter value based on type" value="{{$coupon->amount}}" readonly>
								@if ($errors->has('amount'))
									<span class="text-danger">{{ $errors->first('amount') }}</span>
								@endif
							</div>
						</div>
						<div class="form-group row">
							<label for="input-11" class="col-sm-2 col-form-label">Duration<span class="text-danger">*</span></label>
							<div class="col-sm-10">
								<select name="duration" id="duration" class="form-control" disabled>
									<option value="">Select Duration</option>
										<option value="forever" @if($coupon->duration=='forever') selected="selected" @endif>Forever</option>
										<option value="once" @if($coupon->duration=='once') selected="selected" @endif>Once</option>
										<option value="repeating" @if($coupon->duration=='repeating') selected="selected" @endif>Multiple months</option>
								</select>
								@if ($errors->has('duration'))
									<span class="text-danger">{{ $errors->first('duration') }}</span>
								@endif
							</div>
						</div>
						<div class="form-group row" id="number_of_month_div" @if($coupon->duration!='repeating') style="display: none;" @endif>
							<label for="input-10" class="col-sm-2 col-form-label">Number of month(s)<span class="text-danger">*</span></label>
							<div class="col-sm-10">
								<input type="text" class="form-control" name="number_of_month" placeholder="Enter number of month(s)" value="{{$coupon->number_of_month}}" readonly>
								@if ($errors->has('number_of_month'))
									<span class="text-danger">{{ $errors->first('number_of_month') }}</span>
								@endif
							</div>
						</div>
						<center>
							<div class="form-footer">
								<button type="submit" class="btn btn-success"><i class="fa fa-check-square-o"></i> SAVE</button>
								<a href="{{url('admin/membership-coupons/')}}"><button type="button" class="btn btn-danger"><i class="fa fa-times"></i> CANCEL</button></a>
							</div>
						</center>
					</form>
                </div>
			</div>
		</div>
	</div>
</div>
@endsection 