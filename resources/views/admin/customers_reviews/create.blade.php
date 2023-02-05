@extends('admin.layout.main')
@section('content')

<div class="row">
	<div class="col-lg-12">
		<div class="card">
			<div class="card-header">
				<div class="left">
					<!-- <i class="fa fa-star"></i> --><span>Add Review</span>
				</div>
			</div>
			<div class="card-body">
            	<div class="container-fluid">
					<form id="signupForm" method="post" action="{{route('customer_reviews.store')}}" enctype="multipart/form-data">
					@csrf
					<div class="form-group row">
						<label for="input-10" class="col-sm-2 col-form-label">Vendor<span class="text-danger">*</span></label>
						<div class="col-sm-4">
							<select name="vendor_id" class="form-control" id="vendor_id">
								<option value="">Select Vendor</option>
								@foreach($vendors as $vendor)
								<option value="{{$vendor->id}}" {{ (old("vendor_id") == $vendor->id ? "selected":"") }}>{{$vendor->name}}</option>
								@endforeach
							</select>
							@if ($errors->has('vendor_id'))
								<span class="text-danger">{{ $errors->first('vendor_id') }}</span>
							@endif
						</div>
						<label for="input-11" class="col-sm-2 col-form-label">Store<span class="text-danger">*</span></label>
						<div class="col-sm-4">
							<select name="store_id" class="form-control" id="vendor_store">
								<option value="">Select store</option>
								@foreach($vendor_stores as $vendor_store)
								<option value="{{$vendor_store->id}}" {{ (old("store_id") == $vendor->id ? "selected":"") }}>{{$vendor_store->name}}</option>
								@endforeach
							</select>
							@if ($errors->has('store_id'))
								<span class="text-danger">{{ $errors->first('store_id') }}</span>
							@endif
						</div>
					</div>
					<div class="form-group row">
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
						<label for="input-12" class="col-sm-2 col-form-label">Review<span class="text-danger">*</span></label>
						<div class="col-sm-4">
							<textarea class="form-control" name="review">{{old('review')}}</textarea>
							@if ($errors->has('review'))
								<span class="text-danger">{{ $errors->first('review') }}</span>
							@endif
						</div>
					</div>
					<div class="form-group row">
						<label for="input-12" class="col-sm-2 col-form-label">Status<span class="text-danger">*</span></label>
						<div class="col-sm-4">
							<select name="status" class="form-control">
								<option value="">Select Status</option>
								<option value="verified" @if(old('status')=='verified') selected="selected" @endif>Verified</option>
								<option value="unverified" @if(old('status')=='unverified') selected="selected" @endif>Un Verified</option>
							</select>
							@if ($errors->has('status'))
								<span class="text-danger">{{ $errors->first('status') }}</span>
							@endif
						</div>
					</div>
					<center>
						<div class="form-footer">
							<button type="submit" class="btn btn-success"><i class="fa fa-check-square-o"></i> SAVE</button>
							<a href="{{url('admin/customer_reviews')}}"><button type="button" class="btn btn-danger"><i class="fa fa-times"></i> CANCEL</button></a>
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
var vendor_id = "{{old('vendor_id')}}"; 
var store_id = "{{old('store_id')}}";

$(function() {
  	setTimeout(function(){ getStores(); }, 500);

    $("#vendor_id").change(function() {
      vendor_id = $(this).val();
      getStores();

    });
});

function getStores(){

	if(vendor_id != ''){
		$.ajax({
			type: "get",
			 url: "{{ url('/get-stores') }}/"+vendor_id,
			headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
			dataType: 'json',
			success: function (data) {
				$('#vendor_store').empty();
				$.each(data, function(i, val) {
					$("#vendor_store").append('<option value=' +val.id + '>' + val.name + '</option>');
				});
				if($("#vendor_store option[value='"+store_id+"']").length > 0){
                    $('#vendor_store').val(store_id);
                }
			},
			error: function (data) {
			}
		});
	}else{
		$("#vendor_id").val('');
	}
}
</script> 
@endsection 