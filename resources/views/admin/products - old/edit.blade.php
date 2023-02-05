@extends('admin.layout.main')
@section('content')
<div class="row">
	<div class="col-lg-12">
		<div class="card">
			<div class="card-header">
				<div class="left"><i class="fa fa-product-hunt"></i><span>Edit Product</span></div>
				<div class="right">
					<button onclick="goBack()" class="btn btn-block btn-primary">Go Back</button>
				</div>
			</div>
			<div class="card-body">
				<form id="signupForm" method="post" action="{{route('products.update',$product->id)}}" enctype="multipart/form-data">
					@csrf
					@method('PATCH')
					<div class="form-group row">
						<label for="input-10" class="col-sm-2 col-form-label">Vendor<span class="text-danger">*</span></label>
						<div class="col-sm-4">
							<select name="vendor_id" class="form-control">
								<option value="">Select Vendor</option>
								@foreach($vendors as $vendor)
								<?PHP $vendor_id = ($vendor->id == $product->vendor_id) ? 'selected="selected"' : ''; ?>
								<option value="{{$vendor->id}}"<?php echo $vendor_id; ?>>{{$vendor->name}}</option>
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
								<?PHP $vendor_store_id = ($vendor_store->id == $product->store_id) ? 'selected="selected"' : ''; ?>
								<option value="{{$vendor_store->id}}"<?php echo $vendor_store_id;?>>{{$vendor_store->name}}</option>
								@endforeach
							</select>
							@if ($errors->has('store_id'))
								<span class="text-danger">{{ $errors->first('store_id') }}</span>
							@endif
						</div>
					</div>
					<div class="form-group row">
						<label for="input-13" class="col-sm-2 col-form-label">Title<span class="text-danger">*</span></label>
						<div class="col-sm-4">
							<input type="text" class="form-control" id="input-13" name="title" placeholder="Enter Name" value="{{$product->title}}">
							@if ($errors->has('title'))
								<span class="text-danger">{{ $errors->first('title') }}</span>
							@endif
						</div>
						<label for="input-12" class="col-sm-2 col-form-label">Description<span class="text-danger">*</span></label>
						<div class="col-sm-4">
							<textarea class="form-control" name="description">{{$product->description}}</textarea>
							@if ($errors->has('description'))
								<span class="text-danger">{{ $errors->first('description') }}</span>
							@endif
						</div>
					</div>
					<div class="form-group row">
						<label for="input-13" class="col-sm-2 col-form-label">Type<span class="text-danger">*</span></label>
						<div class="col-sm-4">
							<select name="type" class="form-control">
								<option value="">Select Type</option>
								<option value="single" @if($product->type =='single') selected="selected" @endif>Enable</option>
								<option value="group" @if($product->type=='group') selected="selected" @endif>Disable</option>
							</select>
							@if ($errors->has('type'))
								<span class="text-danger">{{ $errors->first('type') }}</span>
							@endif
						</div>
						<label for="input-12" class="col-sm-2 col-form-label">Status<span class="text-danger">*</span></label>
						<div class="col-sm-4">
							<select name="status" class="form-control">
								<option value="">Select Status</option>
								<option value="enable" @if($product->status =='enable') selected="selected" @endif>Enable</option>
								<option value="disable" @if($product->status=='disable') selected="selected" @endif>Disable</option>
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
								<?PHP $vendor_categoryid = ($vendor_category->id == $product->category_id) ? 'selected="selected"' : ''; ?>
								<option value="{{$vendor_category->id}}" <?php echo $vendor_categoryid; ?>>{{$vendor_category->name}}</option>
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
								<?PHP $brandid = ($brand->id == $product->brand_id) ? 'selected="selected"' : ''; ?>
								<option value="{{$brand->id}}" <?php echo $brandid; ?>>{{$brand->name}}</option>
								@endforeach
							</select>
							@if ($errors->has('brand_id'))
								<span class="text-danger">{{ $errors->first('brand_id') }}</span>
							@endif
						</div>
					</div>
					<div class="form-group row">
						<input type="hidden" name="id" value="{{$product_variants->id}}">
						<label for="input-10" class="col-sm-2 col-form-label">Sku<span class="text-danger">    * </span>
						</label>
						<div class="col-sm-4">
							<input type="text" name="sku" id="sku" placeholder="Enter Sku" class="form-control" value="{{$product_variants->sku_uniquecode}}">
							@if ($errors->has('sku'))
								<span class="text-danger">{{ $errors->first('sku') }}</span>
							@endif
						</div>
						<label for="input-11" class="col-sm-2 col-form-label">Barcode<span class="text-danger">*</span></label>
						<div class="col-sm-4">
							<input type="text" name="barcode" id="barcode" placeholder="Enter Barcode" value="{{$product_variants->barcode}}" class="form-control">
							@if ($errors->has('barcode'))
								<span class="text-danger">{{ $errors->first('barcode') }}</span>
							@endif
						</div>
					</div>
					<div class="form-group row">
						<label for="input-10" class="col-sm-2 col-form-label">Quantity<span class="text-danger">    * </span>
						</label>
						<div class="col-sm-4">
							<input type="number" name="quantity" id="quantity" placeholder="Enter Quantity" value="{{$product_variants->quantity}}" class="form-control">
							@if ($errors->has('quantity'))
								<span class="text-danger">{{ $errors->first('quantity') }}</span>
							@endif
						</div>
						<label for="input-11" class="col-sm-2 col-form-label">Price<span class="text-danger">*</span></label>
						<div class="col-sm-4">
							<input type="text" name="price" id="price" placeholder="Enter Price" value="{{$product_variants->price}}" class="form-control">
							@if ($errors->has('price'))
								<span class="text-danger">{{ $errors->first('price') }}</span>
							@endif
						</div>
					</div>
					<div class="form-group row">
						<label for="input-10" class="col-sm-2 col-form-label">Discount
						</label>
						<div class="col-sm-4">
							<input type="text" name="discount" id="discount" placeholder="Enter Discount" value="{{$product_variants->discount}}" class="form-control">
						</div>
					</div>
					<center>
						<div class="form-footer">
							<button type="submit" class="btn btn-success"><i class="fa fa-check-square-o"></i> SAVE</button>
							<!-- <button type="submit" class="btn btn-danger"><i class="fa fa-times"></i> CANCEL</button> -->
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