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
				<form id="signupForm" method="post" action="{{route('vendor.customer_reviews.update',$customer_review->id)}}" enctype="multipart/form-data">
					@csrf
					@method('PATCH')
					<div class="form-group row">
						<label for="input-11" class="col-sm-2 col-form-label">Store<span class="text-danger">*</span></label>
						<div class="col-sm-4">
							<select name="store_id" class="form-control">
								<option value="">Select store</option>
								@foreach($vendor_stores as $vendor_store)
									<option value="{{$vendor_store->id}}"{{ (old("store_id", $customer_review->store_id) == $vendor_store->id ? "selected":"") }}>{{$vendor_store->name}}</option>
								@endforeach
							</select>
							@if ($errors->has('store_id'))
                                <span class="text-danger">{{ $errors->first('store_id') }}</span>
                            @endif
						</div>
						<label for="input-13" class="col-sm-2 col-form-label">Customer<span class="text-danger">*</span></label>
						<div class="col-sm-4">
							<select name="customer_id" class="form-control">
								<option value="">Select Customer</option>
								@foreach($customers as $customer)
									<option value="{{$customer->id}}"{{ (old("customer_id", $customer_review->customer_id) == $customer->id ? "selected":"") }}>{{$customer->first_name}}</option>
								@endforeach
							</select>
							@if ($errors->has('customer_id'))
                                <span class="text-danger">{{ $errors->first('customer_id') }}</span>
                            @endif
						</div>
					</div>
					<div class="form-group row">
						<label for="input-12" class="col-sm-2 col-form-label">review<span class="text-danger">*</span></label>
						<div class="col-sm-4">
							<textarea class="form-control" name="review">{{old('review',$customer_review->review)}}</textarea>
							@if ($errors->has('review'))
                                <span class="text-danger">{{ $errors->first('review') }}</span>
                            @endif
						</div>
						<label for="input-12" class="col-sm-2 col-form-label">Status<span class="text-danger">*</span></label>
						<div class="col-sm-4">
							<select name="status" class="form-control">
								<option value="">Select Status</option>
								 @php $verified = ''; $unverified = '';
                                    if(old('status')){
                                        if(old('status')=='verified'){
                                            $verified = 'selected="selected"';
                                        }elseif(old('status')=='unverified'){
                                            $unverified = 'selected="selected"';
                                        }
                                    }
                                    else{
                                        if($customer_review->status == 'verified'){
                                            $verified = 'selected="selected"';
                                        }elseif($customer_review->status == 'unverified'){
                                            $unverified = 'selected="selected"';
                                        }
                                    }
                                @endphp
                                <option value="verified"{{$verified}}>Verified</option>
                                <option value="unverified"{{$unverified}}>Un Verified</option>
							</select>
							@if ($errors->has('status'))
                                <span class="text-danger">{{ $errors->first('status') }}</span>
                            @endif
						</div>
					</div>
					<center>
						<div class="form-footer">
							<button type="submit" class="btn btn-success"><i class="fa fa-check-square-o"></i> SAVE</button>
							<a href="{{url('vendor/customer_reviews')}}"><button type="button" class="btn btn-danger"><i class="fa fa-times"></i> CANCEL</button></a> 
						</div>
					</center>
				</form>
			</div>
		</div>
	</div>
</div>
<!--End Row-->
<script>
	function goBack() {
		window.history.back();
	}
</script> 
@endsection 