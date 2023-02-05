@extends('vendor.layout.main')
@section('content')
<div class="row">
	<div class="col-lg-12">
		<div class="card">
			<div class="card-header">
				<div class="left"><span>Edit Review</span></div>
				<div class="right">
					<button onclick="goBack()" class="btn btn-block btn-primary">Go Back</button>
				</div>
			</div>
			<div class="card-body">
				<form id="signupForm" method="post" 
				action="{{route('vendor.product_reviews.update',$product_review->id)}}" enctype="multipart/form-data">
					@csrf
					@method('PATCH')
					<div class="form-group row">
						<label for="input-10" class="col-sm-2 col-form-label">Product<span class="text-danger">*</span></label>
						<div class="col-sm-4">
							<select name="product_id" class="form-control" id="product_id">
								<option value="">Select Product</option>
								@foreach($products as $product)
									<option value="{{$product->id}}"{{ (old("product_id", $product_review->product_id) == $product->id ? "selected":"") }}>{{$product->title}}</option>
								@endforeach
							</select>
							@if ($errors->has('product_id'))
								<span class="text-danger">{{ $errors->first('product_id') }}</span>
							@endif
						</div>
						<label for="input-13" class="col-sm-2 col-form-label">Customer<span class="text-danger">*</span></label>
						<div class="col-sm-4">
							<select name="customer_id" class="form-control">
								<option value="">Select Customer</option>
								@foreach($customers as $customer)
									<option value="{{$customer->id}}"{{ (old("customer_id", $product_review->customer_id) == $customer->id ? "selected":"") }}>{{$customer->first_name}}</option>
								@endforeach
							</select>
							@if ($errors->has('customer_id'))
								<span class="text-danger">{{ $errors->first('customer_id') }}</span>
							@endif
						</div>
					</div>
					<div class="form-group row">
						<label for="input-12" class="col-sm-2 col-form-label">Comment</label>
						<div class="col-sm-4">
							<textarea class="form-control" name="comment">{{old('comment',$product_review->comment)}}</textarea>
							@if ($errors->has('comment'))
								<span class="text-danger">{{ $errors->first('comment') }}</span>
							@endif
						</div>
						<label for="input-12" class="col-sm-2 col-form-label">Rating></label>
						<div class="col-sm-4">
							<input type="number" name="rating" class="form-control" value="{{old('rating',$product_review->rating)}}" min="1" max="5">
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
  function goBack() {
    window.history.back();
  }
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