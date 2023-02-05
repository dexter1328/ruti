@extends('admin.layout.main')
@section('content')
<div class="row">
	<div class="col-lg-12">
		<div class="card">
			<div class="card-header">
				<div class="left"><i class="fa fa-product-hunt"></i><span>Add Product</span></div>
			</div>
			<div class="card-body">
				<form id="signupForm" method="post" action="{{route('products.store')}}" enctype="multipart/form-data">
					@csrf
					<div class="form-group row">
						<label for="input-10" class="col-sm-2 col-form-label">Vendor<span class="text-danger">    * </span>
						</label>
						<div class="col-sm-4">
							<select name="vendor_id" class="form-control">
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
							<select name="store_id" class="form-control">
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
						<label for="input-13" class="col-sm-2 col-form-label">Type<span class="text-danger">*</span></label>
						<div class="col-sm-4">
							<select name="type" class="form-control">
								<option value="">Select Type</option>
								<option value="single" @if(old('type')=='single') selected="selected" @endif>Single</option>
								<option value="group" @if(old('type')=='group') selected="selected" @endif>Group</option>
							</select>
							@if ($errors->has('type'))
								<span class="text-danger">{{ $errors->first('type') }}</span>
							@endif
						</div>
						<label for="input-12" class="col-sm-2 col-form-label">Description<span class="text-danger">*</span></label>
						<div class="col-sm-4">
							<textarea class="form-control" name="description">{{old('description')}}</textarea>
							@if ($errors->has('description'))
								<span class="text-danger">{{ $errors->first('description') }}</span>
							@endif
						</div>
					</div>
					<div class="form-group row">
						<label for="input-13" class="col-sm-2 col-form-label">Title<span class="text-danger">*</span></label>
						<div class="col-sm-4">
							<input type="text" class="form-control" id="input-13" name="title" value="{{old('title')}}" placeholder="Enter Title">
							@if ($errors->has('title'))
								<span class="text-danger">{{ $errors->first('title') }}</span>
							@endif
						</div>
						<label for="input-12" class="col-sm-2 col-form-label">Status<span class="text-danger">*</span></label>
						<div class="col-sm-4">
							<select name="status" class="form-control">
								<option value="">Select Status</option>
								<option value="enable" @if(old('status')=='enable') selected="selected" @endif>Enable</option>
								<option value="disable" @if(old('status')=='disable') selected="selected" @endif>Disable</option>
							</select>
							@if ($errors->has('status'))
								<span class="text-danger">{{ $errors->first('status') }}</span>
							@endif
						</div>
					</div>
					<div class="form-group row">
						<label for="input-13" class="col-sm-2 col-form-label">Category<span class="text-danger">*</span></label>
						<div class="col-sm-4">
							<select name="category_id" class="form-control">
								<option value="">Select Category</option>
								@foreach($vendor_categories as $vendor_category)
								<option value="{{$vendor_category->id}}" {{ (old("category_id") == $vendor_category->id ? "selected":"") }}>{{$vendor_category->name}}</option>
								@endforeach
							</select>
							@if ($errors->has('category_id'))
								<span class="text-danger">{{ $errors->first('category_id') }}</span>
							@endif
						</div>
						<label for="input-13" class="col-sm-2 col-form-label">Brand<span class="text-danger">*</span></label>
						<div class="col-sm-4">
							<select name="brand_id" class="form-control">
								<option value="">Select Brand</option>
								@foreach($brands as $brand)
								<option value="{{$brand->id}}" {{ (old("brand_id") == $brand->id ? "selected":"") }}>{{$brand->name}}</option>
								@endforeach
							</select>
							@if ($errors->has('brand_id'))
								<span class="text-danger">{{ $errors->first('brand_id') }}</span>
							@endif
						</div>
					</div>
					<div class="form-group row">
						<label for="input-10" class="col-sm-2 col-form-label">Sku<span class="text-danger">    * </span>
						</label>
						<div class="col-sm-4">
							<input type="text" name="sku" id="sku" placeholder="Enter Sku" value="{{old('sku')}}" class="form-control">
							@if ($errors->has('sku'))
								<span class="text-danger">{{ $errors->first('sku') }}</span>
							@endif
						</div>
						<label for="input-11" class="col-sm-2 col-form-label">Barcode<span class="text-danger">*</span></label>
						<div class="col-sm-4">
							<input type="text" name="barcode" id="barcode" placeholder="Enter Barcode" value="{{old('barcode')}}" class="form-control">
							@if ($errors->has('barcode'))
								<span class="text-danger">{{ $errors->first('barcode') }}</span>
							@endif
						</div>
					</div>
					<div class="form-group row">
						<label for="input-10" class="col-sm-2 col-form-label">Quantity<span class="text-danger">    * </span>
						</label>
						<div class="col-sm-4">
							<input type="number" name="quantity" id="quantity" placeholder="Enter Quantity" value="{{old('quantity')}}" class="form-control">
							@if ($errors->has('quantity'))
								<span class="text-danger">{{ $errors->first('quantity') }}</span>
							@endif
						</div>
						<label for="input-11" class="col-sm-2 col-form-label">Price<span class="text-danger">*</span></label>
						<div class="col-sm-4">
							<input type="text" name="price" id="price" placeholder="Enter Price" value="{{old('price')}}" class="form-control">
							@if ($errors->has('price'))
								<span class="text-danger">{{ $errors->first('price') }}</span>
							@endif
						</div>
					</div>
					<div class="form-group row">
						<label for="input-10" class="col-sm-2 col-form-label">Discount
						</label>
						<div class="col-sm-4">
							<input type="text" name="discount" id="discount" placeholder="Enter Discount" value="{{old('discount')}}" class="form-control">
						</div>
					</div>
					<center>
						<div class="form-footer">
							<button type="submit" class="btn btn-success"><i class="fa fa-check-square-o"></i> SAVE</button>
							<!--  <button type="submit" class="btn btn-danger"><i class="fa fa-times"></i> CANCEL</button> -->
						</div>
					</center>
				</form>
			</div>
		</div>
	</div>
</div>
<!--End Row--> 


@endsection 