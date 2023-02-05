@extends('vendor.layout.main')

@section('content')

<div class="row">
	<div class="col-lg-12">
		<div class="card">
			<div class="card-header">
				<div class="left"><i class="fa fa-shopping-bag"></i><span>Add Order</span></div>
			</div>
			<div class="card-body">
				<form id="signupForm" method="post" action="{{ route('vendor.orders.store') }}" enctype="multipart/form-data">
					@csrf
					<div class="form-group row">
						<label for="input-10" class="col-sm-2 col-form-label">Store<span class="text-danger">*</span></label>
						<div class="col-sm-4">
							<select name="store_id" class="form-control" id="store">
								<option value="">Select store</option>
								@foreach($vendor_stores as $vendor_store)
								<option value="{{$vendor_store->id}}" {{ (old("store_id") == $vendor_store->id ? "selected":"") }}>{{$vendor_store->name}}</option>
								@endforeach
							</select>
							@if ($errors->has('store_id'))
								<span class="text-danger">{{ $errors->first('store_id') }}</span>
							@endif
						</div>
						<label for="input-10" class="col-sm-2 col-form-label">Customer<span class="text-danger">*</span></label>
						<div class="col-sm-4">
							<select name="customer_id" class="form-control" id="customer_id">
								<option value="">Select Customer</option>
								@foreach($users as $user)
								<option value="{{$user->id}}" {{ (old("user_id") == $user->id ? "selected":"") }}>{{$user->first_name}}</option>
								@endforeach
							</select>
							@if ($errors->has('vendor_id'))
								<span class="text-danger">{{ $errors->first('vendor_id') }}</span>
							@endif
						</div>
					</div>
					<div class="form-group row">
						<label for="input-12" class="col-sm-2 col-form-label">Type<span class="text-danger">*</span></label>
						<div class="col-sm-4">
							<select name="type" class="form-control" id="type">
								<option value="">Select Type</option>
								<option value="pickup" @if(old('type')=='pickup') selected="selected" @endif>Pickup</option>
								<option value="inshop" @if(old('type')=='inshop') selected="selected" @endif>Inshop</option>
							</select>
							@if ($errors->has('type'))
								<span class="text-danger">{{ $errors->first('type') }}</span>
							@endif
						</div>
						<label for="input-10" class="col-sm-2 col-form-label">Product<span class="text-danger">*</span></label>
						<div class="col-sm-4">
							<select name="product_id[]" class="form-control multiple-select" id="product_id" multiple="multiple">
								<option value="">Select Product</option>
								@foreach($products as $product)
								<option value="{{$product->id}}" {{ (old("product_id") == $product->id ? "selected":"") }}>{{$product->title}}</option>
								@endforeach
							</select>
							@if ($errors->has('product_id'))
								<span class="text-danger">{{ $errors->first('product_id') }}</span>
							@endif
						</div>	
					</div>
					<div class="form-group row">
						<label for="input-13" class="col-sm-2 col-form-label date_time"  style="display:none;">Pickup Time</label>
						<div class="col-sm-4 date_time" id="date_time" style="display:none;">
							<input type="text" id ="autoclose-datepicker1" name="date" class="form-control" value="{{old('website_link')}}">
							<input type="time" name="time" class="form-control">
						</div>
						<label for="input-13" class="col-sm-2 col-form-label">Order Status<span class="text-danger">*</span></label>
						<div class="col-sm-4">
							<select name="order_status" class="form-control">
								<option value="">Select Order Status</option>
								<option value="completed" @if(old('order_status')=='completed') selected="selected" @endif>Completed</option>
								<option value="cancel" @if(old('order_status')=='cancel') selected="selected" @endif>Cancel</option>
								<option value="return" @if(old('order_status')=='return') selected="selected" @endif>Return</option>
							</select>
							@if ($errors->has('order_status'))
								<span class="text-danger">{{ $errors->first('order_status') }}</span>
							@endif
						</div>
					</div>
					<div class="form-group row">
						
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

<script type="text/javascript">
  $(function() {
   
    $("#type").change(function() {

     	var type = $(this).val();
     	if(type == 'pickup')
     	{
     		$(".date_time").show();
     	}else{
     		$(".date_time").hide();
     	}
    });

  });

  	$(function() {

		$("#store").change(function() {
			var store_id = $(this).val();
			$.ajax({
				type: "get",
				url: "{{ url('/get-categories') }}/"+store_id,
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				},
				dataType: 'json',
				success: function (data) {
					$('#categories').empty();
					$.each(data, function(i, val) {
						$("#categories").append('<option value="'+val.id+'">'+val.name+'</option>');
					});
					$('#categories').multiselect('rebuild');
				},
				error: function (data) {
				}
			});
		});

	});
 $(document).ready(function() {
    $('.multiple-select').select2();
   });

</script>
@endsection 