@extends('vendor.layout.main')
@section('content')
<div class="row">
	<div class="col-lg-12">
		<div class="card">
			<div class="card-header">
				<div class="left"><span>Edit Brand</span></div>
				<div class="right">
					<!-- <button onclick="goBack()" class="btn btn-block btn-primary">Go Back</button> -->
				</div>
			</div>
			<div class="card-body">
				<form id="signupForm" method="post" action="{{route('vendor.brand.update',$brand->id)}}" enctype="multipart/form-data">
					@csrf
					@method('PATCH')
					<div class="form-group row">
						<label for="input-13" class="col-sm-2 col-form-label">Store<span class="text-danger">*</span></label>
						<div class="col-sm-4">
							<select name="store_id" id="store_id" class="form-control">
								<option value="">Select Store</option>
									@foreach($vendor_stores as $vendor_store)
										<option value="{{$vendor_store->id}}" {{ (old("store_id", $brand->store_id) == $vendor_store->id ? "selected":"") }}>{{$vendor_store->name}}</option>
									@endforeach
							</select>
							@if ($errors->has('store_id')) 
								<span class="text-danger">{{ $errors->first('store_id') }}</span> 
							@endif 
						</div>
						<label for="input-13" class="col-sm-2 col-form-label">Name<span class="text-danger">*</span></label>
						<div class="col-sm-4">
							<input type="text" class="form-control" id="input-13" name="name" placeholder="Enter Name" value="{{old('name',$brand->name)}}">
							@if ($errors->has('name'))
								<span class="text-danger">{{ $errors->first('name') }}</span>
							@endif
						</div>
					</div>
					<div class="form-group row">
						<label for="input-12" class="col-sm-2 col-form-label">Description<span class="text-danger">*</span></label>
						<div class="col-sm-4">
							<textarea class="form-control" name="description">{{old('description',$brand->description)}}</textarea>
							@if ($errors->has('description'))
								<span class="text-danger">{{ $errors->first('description') }}</span>
							@endif
						</div>
						<label for="input-12" class="col-sm-2 col-form-label">Status<span class="text-danger">*</span></label>
						<div class="col-sm-4">
							<select name="status" class="form-control">
								<option value="">Select Status</option>
								@php $ac_status = ''; $de_status = '';
									if(old('status')){
										if(old('status')=='enable'){
											$ac_status = 'selected="selected"';
										}elseif(old('status')=='disable'){
											$de_status = 'selected="selected"';
										}
									}
									else{
										if($brand->status == 'enable'){
											$ac_status = 'selected="selected"';
										}elseif($brand->status == 'disable'){
											$de_status = 'selected="selected"';
										}
									}
								@endphp
								<option value="enable"{{$ac_status}}>Enable</option>
								<option value="disable"{{$de_status}}>Disable</option>
							</select>
							@if ($errors->has('status'))
								<span class="text-danger">{{ $errors->first('status') }}</span>
							@endif
						</div>
					</div>
					<div class="form-group row">
						<label for="input-13" class="col-sm-2 col-form-label">Image</label>
						<div class="col-sm-4">
							<input type="file" class="form-control" id="input-13" name="image">
							@if($brand->image)
	                            <br>
	                            <a href="{{url('public/images/brands/'.$brand->image)}}" rel="prettyPhoto">
	                                <img src="{{url('public/images/brands/'.$brand->image)}}" style="width: 150px; height: auto;">
	                            </a>
	                        @endif
						</div>
					</div>
					<center>
						<div class="form-footer">
							<button type="submit" class="btn btn-success"><i class="fa fa-check-square-o"></i> SAVE</button>
							<a href="{{url('vendor/brand')}}"><button type="button" class="btn btn-danger"><i class="fa fa-times"></i> CANCEL</button></a> 
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