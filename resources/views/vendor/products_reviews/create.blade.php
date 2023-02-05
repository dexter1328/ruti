@extends('vendor.layout.main')
@section('content')

<div class="row">
	<div class="col-lg-12">
		<div class="card">
			<div class="card-header">
				<div class="left">
					<span>Add Review</span>
				</div>
			</div>
			<div class="card-body">
				<form id="signupForm" method="post" action="{{route('vendor.product_reviews.store')}}" enctype="multipart/form-data">
					@csrf
					<div class="form-group row">
						<label for="input-10" class="col-sm-2 col-form-label">Product<span class="text-danger">*</span></label>
						<div class="col-sm-4">
							<select name="product_id" class="form-control" id="vendor_id">
								<option value="">Select Product</option>
								@foreach($products as $product)
								<option value="{{$product->id}}" {{ (old("product_id") == $product->id ? "selected":"") }}>{{$product->title}}</option>
								@endforeach
							</select>
							@if ($errors->has('product_id'))
								<span class="text-danger">{{ $errors->first('product_id') }}</span>
							@endif
						</div>
						<label for="input-13" class="col-sm-2 col-form-label">Customer<span class="text-danger">*</span></label>
						<div class="col-sm-4">
							<select name="customer_id" class="form-control">
								<option value="">Select customer</option>
								@foreach($customers as $customer)
								<option value="{{$customer->id}}" {{ (old("customer_id") == $customer->id ? "selected":"") }}>{{$customer->first_name}}</option>
								@endforeach
							</select>
							@if ($errors->has('customer_id'))
								<span class="text-danger">{{ $errors->first('customer_id') }}</span>
							@endif
						</div>
					</div>
					<div class="form-group row">
						<label for="input-12" class="col-sm-2 col-form-label">Comment<span class="text-danger">*</span></label>
						<div class="col-sm-4">
							<textarea class="form-control" name="comment">{{old('comment')}}</textarea>
							@if ($errors->has('comment'))
								<span class="text-danger">{{ $errors->first('comment') }}</span>
							@endif
						</div>
						<label for="input-12" class="col-sm-2 col-form-label">Rating<span class="text-danger">*</span></label>
						<div class="col-sm-4">
							<input type="number" name="rating" class="form-control" min="1" max="5" value="{{old('rating')}}">
							@if ($errors->has('rating'))
								<span class="text-danger">{{ $errors->first('rating') }}</span>
							@endif
						</div>
					</div>
					<center>
						<div class="form-footer">
							<button type="submit" class="btn btn-success"><i class="fa fa-check-square-o"></i> SAVE</button>
							<a href="{{url('vendor/product_reviews')}}"><button type="button" class="btn btn-danger"><i class="fa fa-times"></i> CANCEL</button></a> 
						</div>
					</center>
				</form>
			</div>
		</div>
	</div>
</div>
<!--End Row--> 
<script type="text/javascript">
  $(function() {
    $("#vendor_id").change(function() {
      var vendor_id = $(this).val();
      $.ajax({
        type: "post",
        url: "{{ url('/admin/products/store_data') }}",
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: {
          "vendor_id": vendor_id
        },
        dataType: 'json',
        success: function (data) {
          $('#vendor_store').empty();
          $.each(data, function(i, val) {
            $("#vendor_store").append('<option value=' +val.id + '>' + val.name + '</option>');
          });
        },
        error: function (data) {
        }
      });
    });
  });
</script> 
@endsection 