@extends('admin.layout.main')

@section('content')
<div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header">
        <div class="left"><!-- <i class="fa fa-file"></i> --><span>Add Used Coupon</span></div>
      </div>
      <div class="card-body">
      	<div class="container-fluid">
	        <form id="signupForm" method="post" action="{{route('vendor_coupons_used.store')}}" enctype="multipart/form-data">
          @csrf
          <div class="form-group row">
            <label for="input-10" class="col-sm-2 col-form-label">Customer<span class="text-danger">*</span></label>
            <div class="col-sm-4">
              <select name="user_id" class="form-control" id="user_id">
                <option value="">Select Customer</option>
                @foreach($users as $user)
                <option value="{{$user->id}}" {{ (old("user_id") == $user->id ? "selected":"") }}>{{$user->first_name}}</option>
                @endforeach
              </select>
              @if ($errors->has('user_id'))
                <span class="text-danger">{{ $errors->first('user_id') }}</span>
              @endif
            </div>
            <label for="input-11" class="col-sm-2 col-form-label">Coupon<span class="text-danger">*</span></label>
            <div class="col-sm-4">
              <select name="coupon_id" class="form-control" id="coupon_id">
                <option value="">Select Coupon</option>
                @foreach($vendor_coupons as $vendor_coupon)
                <option value="{{$vendor_coupon->id}}" {{ (old("coupon_id") == $user->id ? "selected":"") }}>{{$vendor_coupon->coupon_code}}</option>
                @endforeach
              </select>
              @if ($errors->has('coupon_id'))
                <span class="text-danger">{{ $errors->first('coupon_id') }}</span>
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