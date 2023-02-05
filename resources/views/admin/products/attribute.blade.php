<div class="attributes">
	@if($lngth > 0)
	<a href="javaScript:void(0);" class="del-button" onclick="$(this).closest('.attributes').remove();" style="float:right;font-size:30px;"><i class="fa fa-close"></i></a>
	@endif
	<div style="clear: both;"></div>
	<div class="table">
		<div class="row">
			<div class="col-xs-12 col-md-6">
				<label for="input-11" >Attribute</label>
				<select class="form-control attribute">
					<option value="">Select Attribute</option>
					@foreach($attributes as $attribute)
					<option value="{{$attribute->id}}">{{$attribute->name}}</option>
					@endforeach
				</select>
			</div>
			<div class="col-xs-12 col-md-6">
				<label for="input-11" >&nbsp;</label>
				<button type="button" class="btn btn-sm btn-primary add_attributre" onclick="add_attribute(this,'{{$lngth}}');">
				<i class="fa fa-plus"></i> Add Attribute
				</button>
			</div>
		</div>
		<div class="product_attributes"></div>
		<div style="clear: both;"></div>
		<div class="row">   
			<div class="col-xs-12 col-md-6">
				<label for="input-11" >Regular Price</label>
				<input type="text" name="p_regular_price[{{$lngth}}]" class="form-control" value="{{old('p_regular_price')}}" placeholder="Enter Price">
				@if ($errors->has('regular_price'))
				<span class="text-danger">{{ $errors->first('regular_price') }}</span>
				@endif
			</div>
			<div class="col-xs-12 col-md-6">
				<label for="input-11" >Discount</label>
				<input type="text" name="p_discount[{{$lngth}}]" class="form-control" value="{{old('p_discount')}}" placeholder="Enter Discount">
				@if ($errors->has('p_discount'))
				<span class="text-danger">{{ $errors->first('p_discount') }}</span>
				@endif
			</div>
			<div class="col-xs-12 col-md-6">
				<label for="input-11" >Sku</label>
				<input type="text" name="p_sku[{{$lngth}}]" class="form-control" value="{{old('p_sku')}}" placeholder="Enter Sku">
				@if ($errors->has('sku'))
				<span class="text-danger">{{ $errors->first('sku') }}</span>
				@endif
			</div>
			<div class="col-xs-12 col-md-6">
				<label for="input-11" >Quantity</label>
				<input type="number" name="p_quantity[{{$lngth}}]" class="form-control" value="{{old('p_quantity')}}" placeholder="Enter Quantity">
				@if ($errors->has('quantity'))
				<span class="text-danger">{{ $errors->first('quantity') }}</span>
				@endif
			</div>
			<div class="col-xs-12 col-md-6">
				<label for="input-11" >Lowstock Threshold</label>
				<input type="text" name="p_lowstock_threshold[{{$lngth}}]" class="form-control" value="{{old('p_lowstock_threshold')}}" placeholder="Enter Lowstock Threshold">
				@if ($errors->has('lowstock_threshold'))
				<span class="text-danger">
				{{ $errors->first('lowstock_threshold') }}
				</span>
				@endif
			</div>
			<div class="col-xs-12 col-md-6">
				<label for="input-11" >Image</label>
				<input type="file" class="form-control" name="att_image[{{$lngth}}][]" multiple="multiple">
				@if ($errors->has('image'))
				<span class="text-brand">{{ $errors->first('image') }}</span>
				@endif
			</div>
		</div>
	</div>
</div>
