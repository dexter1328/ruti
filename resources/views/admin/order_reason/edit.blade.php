@extends('admin.layout.main')
@section('content')

<div class="row">
	<div class="col-lg-12">
		<div class="card">
			<div class="card-header">
				<div class="left"><!-- <i class="fa fa-address-book-o"></i> --><span>Edit Return/Cancel Order Reasons</span></div>
			</div>
			<div class="card-body">
            	<div class="container-fluid">
					<form id="signupForm" method="post" action="{{ route('order_reason.update',$order_reason->id) }}" enctype="multipart/form-data">
					@csrf
					@method('PATCH')
					<div class="form-group row">
						<label for="input-13" class="col-sm-2 col-form-label">Type<span class="text-danger">*</span></label>
						<div class="col-sm-10">
							<select name="type" class="form-control">
								<option value="">Select Type</option>
								@php $return = ''; $cancel = '';
									if(old('status')){
										if(old('type')=='return'){
											$return = 'selected="selected"';
										}elseif(old('type')=='cancel'){
											$cancel = 'selected="selected"';
										}
									}else{
										if($order_reason->type == 'return'){
											$return = 'selected="selected"';
										}elseif($order_reason->type == 'cancel'){
											$cancel = 'selected="selected"';
										}
									}
								@endphp
								<option value="return" {{$return}}>Return</option>
								<option value="cancel" {{$cancel}}>Cancel</option>
							</select>
							@if ($errors->has('type'))
								<span class="text-danger">{{ $errors->first('type') }}</span>
							@endif
						</div>
					</div>
					<div class="form-group row">
						<label for="input-12" class="col-sm-2 col-form-label">Reason<span class="text-danger">*</span></label>
						<div class="col-sm-10">
							<input type="text" name="reason" class="form-control" value="{{old('reason',$order_reason->reason)}}">
							@if ($errors->has('reason'))
								<span class="text-danger">{{ $errors->first('reason') }}</span>
							@endif
						</div>
					</div>
					<center>
						<div class="form-footer">
							<button type="submit" class="btn btn-success"><i class="fa fa-check-square-o"></i> SAVE</button>
							<a href="{{url('admin/order_reason')}}"><button type="button" class="btn btn-danger"><i class="fa fa-times"></i> CANCEL</button></a>
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