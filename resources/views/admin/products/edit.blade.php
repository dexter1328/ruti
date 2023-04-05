@extends('admin.layout.main')
@section('content')

<style type="text/css">
.close{
    display:block;
    float:right;
    width:30px;
    height:29px;
    background:url('{{ asset('public/images/remove_btn.png')}}') no-repeat center center;
}

.image_div {
    width: 150px;
    position: relative;
    float: none;
    display: inline-block;
    height: 150px;
    border: 1px solid #333; margin: 20px 20px 0 0;
}
.image_div a img {
    margin: auto;
    display: block;
    vertical-align: middle;
    position: relative;
}
a.pretty-img {
    position: relative;
    height: 150px;
    vertical-align: middle;
    display: flex;
    width: 100%;
}
.image_div a.del-button{position: absolute; right: -15px; top:-15px;}

.table td, .table th {
    border-top: 1px solid #ffffff;
}
.table thead th {
    border-bottom: 1px solid #ffffff;
}
.product_attributes{
    width:100%;
}
.table label {
    margin: 15px 0 0;
}
.table .btn.btn-sm.btn-primary.add_attributre {
    width: auto;
    padding: 11px;
   /* margin-top: 34px;*/
}
.attributes {
    border: 1px solid #d2d2d2;
    padding: 15px 20px;
    margin: 20px 0;
}
.fa.fa-close {
    position: relative;
    color: #fff !important;
    background: #c00;
    border-radius: 100px;
    width: 30px;
    height: 30px;
    display: block;
    font-size: 15px;
    line-height: 30px;
    text-align: center;
    vertical-align: middle;
}
ul li{ list-style:none; margin:0; padding:0; }
a{text-decoration:none;}
.categorydiv {
    border: 1px solid #ced4da;
    padding:10px;
    height: 482px;
    overflow-y: scroll;
}
.category_heirarchy {
    padding: 0 8px;
}
.category_heirarchy input[type="checkbox"], .category_heirarchy input[type="radio"] {
    margin: 0px 5px 0 0;
}
.category_heirarchy label {
    margin-bottom: 0px;
}
.category_heirarchy ul {
    padding: 0 30px;
}
ul.category-tabs {
    margin: 0; padding:0;
}
#product_catchecklist {
    margin: 10px 0;
    padding: 0;
}
ul.category-tabs li.tabs {
    border: 1px solid #ddd;
    background-color:#efefef;padding: 10px;
}
button .fa {
    font-size: 12px;
    vertical-align: middle;
}
</style>

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <div class="left"><!-- <i class="fa fa-product-hunt"></i> --><span>Edit Product</span></div>
            </div>
            <div class="card-body">
            	<div class="container-fluid">
	                <form id="signupForm" method="post" action="{{route('products.update', $product->id)}}" enctype="multipart/form-data">
                    @csrf
                    @method('PATCH')
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-header">
                                    <div class="left"> Products</div>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-lg-8">
                                            <div class="form-group row">
                                                <div class="col-sm-12">
                                                    <label>Title<span class="text-danger">*</span></label>
                                                    <input type="text" name="title" class="form-control" value="{{old('title', $product->title)}}" placeholder="Enter Title">
                                                    @if ($errors->has('title'))
                                                        <span class="text-danger">{{ $errors->first('title') }}</span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-sm-12">
                                                    <label>Tax</label>
                                                    <input type="text" name="tax" class="form-control" value="{{old('tax' ,$product->tax)}}" placeholder="Enter Tax">
                                                    @if ($errors->has('tax')) <span class="text-danger">{{ $errors->first('tax') }}</span> @endif
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-sm-12">
                                                    <label>Season</label>
                                                    <select name="season" class="form-control" id="season">
                                                        <option value="">Select Season</option>
                                                        @foreach(getSeasons() as $key => $season)
                                                        <option value="{{$key}}" {{$key==old('season',$product->season) ? 'selected="selected"' : ''}}>{{$season['title'] ?? ''}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-sm-12">
                                                    <label>AISLE</label>
                                                    <input type="text" name="aisle" class="form-control" value="{{old('aisle',$product->aisle)}}" placeholder="Enter AISLE">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-sm-12">
                                                    <label>Description</label>
                                                    <textarea id="summernoteEditor" name="description">{{old('description', $product->description)}}</textarea>
                                                    @if ($errors->has('description'))
                                                        <span class="text-danger"> {{ $errors->first('description') }}</span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group row">
                                                <div class="col-sm-12">
                                                    <label>Vendor<span class="text-danger">*</span></label>
                                                    <select name="vendor" class="form-control" id="vendor">
                                                        <option value="">Select Vendor</option>
                                                        @foreach($vendors as $vendor)
                                                        @php $selected = ($vendor->id == old('vendor',$product->vendor_id)) ? 'selected="selected"' : ''; @endphp
                                                        <option value="{{$vendor->id}}" {{$selected}}>{{$vendor->name}}</option>
                                                        @endforeach
                                                    </select>
                                                    @if ($errors->has('vendor'))
                                                        <span class="text-danger">{{ $errors->first('vendor') }}</span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-sm-12">
                                                    <label>Store<span class="text-danger">*</span></label>
                                                    <select name="store" id="store" class="form-control">
                                                        <option value="">Select Store</option>
                                                    </select>
                                                    @if ($errors->has('store'))
                                                        <span class="text-danger">{{ $errors->first('store') }}</span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-sm-12">
                                                    <label>Brand</label>
                                                    <select name="brand" id="brand" class="form-control">
                                                        <option value="">Select Brand</option>
                                                    </select>
                                                    @if ($errors->has('brand'))
                                                        <span class="text-danger">{{ $errors->first('brand') }}</span>
                                                    @endif
                                                </div>
                                            </div>
                                             <div class="form-group row">
                                                <div class="col-sm-12">
                                                    <label>SHELF</label>
                                                    <input type="text" name="shelf" value="{{old('shelf',$product->shelf)}}" class="form-control" placeholder="Enter SHELF">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-sm-12">
                                                    <label>Categories</label>
                                                    <div id="categories" class="categorydiv">
                                                    </div>
                                                    @if($errors->has('categories'))
                                                        <span class="text-danger">{{ $errors->first('categories') }}</span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Tab panes -->
                                    <!-- Tab panes -->
                                           <!--  <button type="button" id="add_attributre_set" class="btn btn-sm btn-primary float-right"><i class="fa fa-plus"></i> Add More Attribute Set</button> -->
                                            <div style="clear:both"></div>
                                            @foreach($product_variants as $key => $product_variant)
                                            <div class="attributes">
                                                <input type="hidden" name="group_product_variants_id" value="{{$product_variant->id}}">
                                                @if($key > 0)
                                                <a href="javaScript:void(0);" class="del-button" onclick="$(this).closest('.attributes').remove();" style="float:right;font-size:30px;"><i class="fa fa-close"></i></a>
                                                @endif
                                                <div style="clear: both;"></div>
                                                <div class="table">
                                                    <div class="row">
                                                        <div class="col-xs-12 col-md-6">
                                                            <label for="input-11" >Attribute</label>
                                                            <select class="form-control attribute" id="attributes">
                                                                <option value="">Select Attribute</option>
                                                                @foreach($attributes as $attribute)
                                                                <option value="{{$attribute->id}}">{{$attribute->name}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="col-xs-12 col-md-6">
                                                            <label for="input-11" >&nbsp;</label>
                                                            <button type="button" class="btn btn-sm btn-primary add_attributre" onclick="add_attribute(this,'{{$key}}');">
                                                            <i class="fa fa-plus"></i> Add Attribute
                                                            </button>
                                                        </div>
                                                    </div>
                                                    @php
                                                    $product_images = \App\ProductImages::where('variant_id',$product_variant->id)
                                                                ->get();
                                                   if($product_variant->attribute_value_id){

                                                    $attribute_values_ids = explode(',', $product_variant->attribute_value_id);
                                                    $attribute_ids = explode(',', $product_variant->attribute_id);

                                                        foreach($attribute_ids as $attribute_id){
                                                            $attribute_values = \App\AttributeValue::select('attributes.name as attribute_name', 'attribute_values.id', 'attribute_values.name', 'attribute_values.attribute_id')
                                                                ->join('attributes', 'attributes.id', 'attribute_values.attribute_id')
                                                                ->where('attribute_id',$attribute_id)
                                                                ->get();
                                                            $first = Arr::first($attribute_values);

                                                        @endphp
                                                        <div class="row">
                                                            <div class="col-xs-12 col-md-6">
                                                                <label>&nbsp;</label>
                                                                <input type="hidden" name="attribute[]" value="{{$first['attribute_id'] ?? ''}}">
                                                                <select class="form-control attribute{{$first['attribute_name'] ?? ''}}" name="attribute_values[]" >
                                                                    <option value="">Select {{$first['attribute_name'] ?? ''}}</option>
                                                                    @foreach ($attribute_values as $attribute_value) {
                                                                        <option value="{{$attribute_value->id}}" @if(in_array($attribute_value->id, $attribute_values_ids)) selected="selected" @endif>{{$attribute_value->name}}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            <div class="col-xs-12 col-md-6">
                                                                <label>&nbsp;</label>
                                                                <a href="javaScript:void(0);" class="del-button" onclick="$(this).closest('.row').remove();">
                                                                    <i class="fa fa-close"></i>
                                                                </a>
                                                            </div>
                                                        </div>
                                                    @php } } @endphp
                                                    <div class="product_attributes"></div>
                                                    <div style="clear: both;"></div>
                                                    <div class="row">
                                                        <div class="col-xs-12 col-md-6">
                                                            <label for="input-11" >Regular Price<span class="text-danger">*</span></label>
                                                            <input type="text" name="regular_price" class="form-control" value="{{old('regular_price',$product_variant->price)}}" placeholder="Enter Price">
                                                            @if ($errors->has('regular_price'))
                                                            <span class="text-danger">{{ $errors->first('regular_price') }}</span>
                                                            @endif
                                                        </div>
                                                        <div class="col-xs-12 col-md-6">
                                                            <label for="input-11" >Discount<span class="text-danger">*</span></label>
                                                            <input type="text" name="discount" class="form-control" value="{{old('discount',$product_variant->discount)}}" placeholder="Enter Discount">
                                                            @if ($errors->has('discount'))
                                                            <span class="text-danger">{{ $errors->first('discount') }}</span>
                                                            @endif
                                                        </div>
                                                        <div class="col-xs-12 col-md-6">
                                                            <label for="input-11" >Sku<span class="text-danger">*</span></label>
                                                            <input type="text" name="sku" class="form-control" value="{{old('sku',$product_variant->sku_uniquecode)}}" placeholder="Enter Sku">
                                                            @if ($errors->has('sku'))
                                                            <span class="text-danger">{{ $errors->first('sku') }}</span>
                                                            @endif
                                                        </div>
                                                        <div class="col-xs-12 col-md-6">
                                                            <label for="input-11" >Quantity<span class="text-danger">*</span></label>
                                                            <input type="number" name="quantity" class="form-control" value="{{old('quantity', $product_variant->quantity)}}" placeholder="Enter Quantity">
                                                            @if ($errors->has('quantity'))
                                                            <span class="text-danger">{{ $errors->first('quantity') }}</span>
                                                            @endif
                                                        </div>
                                                        <div class="col-xs-12 col-md-6">
                                                            <label for="input-11" >Lowstock Threshold<span class="text-danger">*</span></label>
                                                            <input type="text" name="lowstock_threshold" class="form-control" value="{{old('lowstock_threshold', $product_variant->lowstock_threshold)}}" placeholder="Enter Lowstock Threshold">
                                                            @if ($errors->has('lowstock_threshold'))
                                                            <span class="text-danger">{{ $errors->first('lowstock_threshold') }}</span>
                                                            @endif
                                                        </div>
                                                        <div class="col-xs-12 col-md-6">
                                                            <label for="input-11" >Image</label>
                                                            <input type="file" class="form-control" name="image[]" multiple="multiple">
                                                        </div>
                                                        <div class="col-lg-12">
                                                            @if(isset($product_images) && $product_images->isNotEmpty())
                                                                @foreach($product_images as $product_image)
                                                                    <div class="image_div">
                                                                         <a href="javaScript:void(0);" class="del-button" onclick="RemoveImage(this,'{{$product_image->id}}')"><i class="fa fa-close"></i></a>
                                                                        <a href="{{url('public/images/product_images/'.$product_image->image)}}" rel="prettyPhoto[gallery_{{$product_variant->id}}]" class="pretty-img">
                                                                            <img src="{{asset('public/images/product_images').'/'.$product_image->image}}" width="100" height="100">
                                                                        </a>
                                                                    </div>

                                                                @endforeach
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            @endforeach
                                            <!-- <div id="attribute_set"></div> -->

                                </div>
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary"><i class="fa fa-check-square-o"></i> SAVE</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    var attribute_set_length = parseInt('{{$lngth}}');
    $(function() {

        vendor_id = '{{$product->vendor_id}}';
        getStore(vendor_id, '{{$product->store_id}}');

        store_id = '{{$product->store_id}}';
        getBrand(store_id, '{{$product->brand_id}}');
        getCategory(store_id, '{{$product->category_id}}');
        getAttribute(store_id, '{{$product->attribute_id}}');
        var active_tab = '{{$product->type}}';
        if(active_tab == 'single'){
            add_attribute_set(attribute_set_length);
        }

        // $('#categories').select2({
        //  placeholder: "Select Category",
        // });

        $("#vendor").change(function() {
            vendor_id = $(this).val();
            getStore(vendor_id);
        });

        $("#store").change(function() {
            store_id = $(this).val();
            getBrand(store_id);
            getCategory(store_id);
            getAttribute(store_id);
        });

        $('.product_tab').click(function(){
            var tab = $(this).find('span').text();
            if(tab == 'General'){
                var val = 'single';
            }else{
                var val = 'group';
            }
            $('#active_tab').val(val);
        });

        $("#add_attributre_set").on('click',function(){

            attribute_set_length++;
            add_attribute_set(attribute_set_length);
        });
    });

    function getStore(vendor_id, store_id = null){

        $.ajax({
            type: "get",
            url: "{{ url('/get-stores') }}/"+vendor_id,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            dataType: 'json',
            success: function (data) {
                $('#store').empty();
                $("#store").append('<option value="">Select Store</option>');
                $.each(data, function(i, val) {
                    $("#store").append('<option value="'+val.id+'">'+val.name+'</option>');
                });
                if(store_id != null){
                     $('#store').val(store_id);
                }
            },
            error: function (data) {
            }
        });
    }

    function getBrand(store_id, brand_id = null){

        $.ajax({
            type: "get",
            url: "{{ url('/get-brands') }}/"+store_id,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            dataType: 'json',
            success: function (data) {
                $('#brand').empty();
                $("#brand").append('<option value="">Select Brand</option>');
                $.each(data, function(i, val) {
                    $("#brand").append('<option value="'+val.id+'">'+val.name+'</option>');
                });
                if(brand_id != null){
                     $('#brand').val(brand_id);
                }
            },
            error: function (data) {
            }
        });
    }

    function getCategory(store_id, category_id = null ){

        $.ajax({
            type: "get",
            url: "{{ url('/get-categories-hierarchy') }}/"+store_id,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            dataType: 'json',
            success: function (data) {
                $("#categories").html(data.categories);

                if(category_id != null){
                    var category_ids = category_id.split(',');
                    category_ids.forEach(function(id){
                        $('#category_'+id).attr('checked',true);
                    });
                }
            },
            error: function (data) {
            }
        });
    }

    function add_attribute_set(lnght){

        $.ajax({
            type: "GET",
            url: "{{ url('/admin/products/add_attribute_set') }}/"+lnght,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            dataType: 'json',
            success: function (response) {
                $('#attribute_set').append(response.html);
            }
        });
    }

    function add_attribute(e, lnght){

        var attributes = $(e).closest(".attributes");
        var attribute_id = attributes.find(".attribute").val();
        var attribute_name = attributes.find(".attribute option:selected").text();
        if(!attributes.find(".attribute"+attribute_name).is(":visible")){
            if(attribute_id!=''){
                $.ajax({
                    type: "GET",
                    url: "{{ url('/admin/products/get_attribute_values') }}/"+attribute_id+"/"+lnght,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    dataType: 'json',
                    success: function (response) {
                        attributes.find('.product_attributes').append(response.data);
                    }
                });
            }
        }
    }

    function RemoveImage(e, id)
    {
        $.ajax({
            type: "post",
            url: "{{ url('/admin/products/remove_image') }}/"+id,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (data) {

                e.closest('.image_div').remove();
            }
        });
    }

    function getAttribute()
    {
         if(store_id != ''){
            $.ajax({
                type: "get",
                url: "{{ url('/get-attribute') }}/"+store_id,
                headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                dataType: 'json',
                success: function (data) {
                    $('#attributes').empty();
                    $("#attributes").append('<option value="">Select Attribute</option>');
                    $.each(data, function(i, val) {
                        $("#attributes").append('<option value="'+val.id+'">'+val.name+'</option>');
                    });
                },
                error: function (data) {
                }
            });
        }
    }

</script>
@endsection
