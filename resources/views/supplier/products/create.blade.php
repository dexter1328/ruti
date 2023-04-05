@extends('supplier.layout.main')
@section('content')
<style type="text/css">
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
button .fa {
    font-size: 12px;
    vertical-align: middle;
}
/*.attributes {
    border: 1px solid #d2d2d2;
    padding: 15px 20px;
    margin: 20px 0;
}*/
.card-footer{padding:.75rem 1.02rem}
#signupForm .card-footer i {
    font-size: 12px;
    margin: 0 4px 0 0;
}
#signupForm  .btn {
    padding: 10px;
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
    height: 456px;
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
</style>
@if(session()->get('success'))
<div class="alert alert-success alert-dismissible" role="alert">
	<button type="button" class="close" data-dismiss="alert">×</button>
	<div class="alert-icon">
		<i class="fa fa-check"></i>
	</div>
	<div class="alert-message">
		<span><strong>Success!</strong> {{ session()->get('success') }}</span>
	</div>
</div>
@elseif(session()->get('error'))
<div class="alert alert-danger alert-dismissible" role="alert">
	<button type="button" class="close" data-dismiss="alert">×</button>
	<div class="alert-icon">
		<i class="fa fa-check"></i>
	</div>
	<div class="alert-message">
		<span><strong>Success!</strong> {{ session()->get('error') }}</span>
	</div>
</div>
@endif
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <div class="left"><!-- <i class="fa fa-product-hunt"></i> --><span>Add Product</span></div>
            </div>
            <div class="card-body">
                <div class="container-fluid">
                    <form id="signupForm" method="post" action="{{route('supplier.products.store')}}" enctype="multipart/form-data">
                    @csrf
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
                                                        <input type="text" name="title" class="form-control" value="{{old('title')}}" placeholder="Enter Title">
                                                        @if ($errors->has('title')) <span class="text-danger">{{ $errors->first('title') }}</span> @endif
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-sm-12">
                                                        <label>Meta Title<span class="text-danger">*</span></label>
                                                        <input type="text" name="meta_title" class="form-control" value="{{old('meta_title')}}" placeholder="Enter Meta Title">
                                                        @if ($errors->has('meta_title')) <span class="text-danger">{{ $errors->first('meta_title') }}</span> @endif
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <div class="col-sm-12">
                                                        <label>Description</label>
                                                        <textarea id="summernoteEditor" name="description">{{old('description')}}</textarea>
                                                        @if ($errors->has('description')) <span class="text-danger"> {{ $errors->first('description') }}</span> @endif
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-sm-12">
                                                        <label>Meta Description</label>
                                                        <textarea name="meta_description" class="form-control">{{old('meta_description')}}</textarea>
                                                        @if ($errors->has('meta_description')) <span class="text-danger"> {{ $errors->first('meta_description') }}</span> @endif
                                                    </div>
                                                </div>

                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group row">
                                                    <div class="col-sm-12">
                                                        <label>Brand</label>
                                                        <select name="brand" id="brand" class="form-control">
                                                            <option value="">Select Brand</option>
                                                            @foreach($brands as $brand)
                                                                <option value="{{$brand->name}}">{{$brand->name}}</option>
                                                            @endforeach
                                                        </select>
                                                        @if ($errors->has('brand'))
                                                        <span class="text-danger">{{ $errors->first('brand') }}</span>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-sm-12">
                                                        <label>Category</label>
                                                        <select name="category" id="category" class="form-control">
                                                            <option value="">Select Category</option>
                                                            @foreach($categories as $category)
                                                                <option value="{{$category->id}}">{{$category->category1}}</option>
                                                            @endforeach
                                                        </select>
                                                        @if ($errors->has('brand'))
                                                            <span class="text-danger">{{ $errors->first('brand') }}</span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="attributes row">
                                        <div style="clear: both;"></div>
                                            <div class="col-lg-12">
                                                <div class="table">
                                                    <div style="clear: both;"></div>
                                                    <div class="row">
                                                        <div class="col-xs-12 col-md-6">
                                                            <label for="input-11" >Regular Price<span class="text-danger">*</span></label>
                                                            <input type="text" name="retail_price" class="form-control" value="{{old('retail_price')}}" placeholder="Enter Price">
                                                            @if ($errors->has('retail_price'))
                                                            <span class="text-danger">{{ $errors->first('retail_price') }}</span>
                                                            @endif
                                                        </div>
                                                        <div class="col-xs-12 col-md-6">
                                                            <label for="input-11" >Wholesale Price<span class="text-danger">*</span></label>
                                                            <input type="text" name="wholesale_price" class="form-control" value="{{old('wholesale_price')}}" placeholder="Enter Wholesale price">
                                                            @if ($errors->has('wholesale_price'))
                                                            <span class="text-danger">{{ $errors->first('wholesale_price') }}</span>
                                                            @endif
                                                        </div>
                                                        <div class="col-xs-12 col-md-6">
                                                            <label for="input-11" >Shipping Price<span class="text-danger">*</span></label>
                                                            <input type="text" name="shipping_price" class="form-control" value="{{old('shipping_price')}}" placeholder="Enter Shipping price">
                                                            @if ($errors->has('shipping_price'))
                                                            <span class="text-danger">{{ $errors->first('shipping_price') }}</span>
                                                            @endif
                                                        </div>
                                                        <div class="col-xs-12 col-md-6">
                                                            <label for="input-11" >SKU<span class="text-danger">*</span></label>
                                                            <input type="text" name="sku" class="form-control" value="{{old('sku')}}" placeholder="Enter SKU">
                                                            @if ($errors->has('sku'))
                                                            <span class="text-danger">{{ $errors->first('sku') }}</span>
                                                            @endif
                                                        </div>
                                                        <div class="col-xs-12 col-md-6">
                                                            <label for="input-11" >Stock Quantity<span class="text-danger">*</span></label>
                                                            <input type="number" name="stock" class="form-control" value="{{old('stock')}}" placeholder="Enter Quantity">
                                                            @if ($errors->has('stock'))
                                                            <span class="text-danger">{{ $errors->first('stock') }}</span>
                                                            @endif
                                                        </div>
                                                        <div class="col-xs-12 col-md-6">
                                                            <label for="input-11" >Image<span class="text-danger">*</span></label>
                                                            <input type="file" class="form-control" name="image[]" multiple="multiple">
                                                            @if ($errors->has('image'))
                                                            <span class="text-danger">{{ $errors->first('image') }}</span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <label for="" >Wholesale Settings</label>

                                                            <div class="row mb-3">
                                                                <div class="col-xs-12 col-md-6">
                                                                    <label for="input-11" >Minimum Wholesale Quantity</label>
                                                                    <input type="number" name="min_wholesale_qty" class="form-control" value="{{old('min_wholesale_qty')}}" placeholder="Minimum Wholesale Quantity">
                                                                    @if ($errors->has('min_wholesale_qty'))
                                                                        <span class="text-danger">
                                                                        {{ $errors->first('min_wholesale_qty') }}
                                                                        </span>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-8">
                                                                    <div class="row">
                                                                        <div class="col-4">
                                                                            <label for="input-11" >Min Order</label>
                                                                        </div>
                                                                        <div class="col-4">
                                                                            <label for="input-11" >Max Order</label>
                                                                        </div>
                                                                        <div class="col-4">
                                                                            <label for="input-11" >Whole Sale Price</label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div id="wholesale_container">
                                                                <div class="row pb-2">
                                                                    <div class="col-md-8">
                                                                        <div class="row">
                                                                            <div class="col-4">
                                                                                <input type="number" class="form-control" name="wholesale[min_order_qty][]" id="" placeholder="Min Order Qty">
                                                                            </div>
                                                                            <div class="col-4">
                                                                                <input type="number" class="form-control" name="wholesale[max_order_qty][]" id="" placeholder="Max Order Qty">
                                                                            </div>
                                                                            <div class="col-4">
                                                                                <input type="number" class="form-control" name="wholesale[wholesale_price][]" step="any" id="" placeholder="Wholesale price">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <button type="button" class="btn btn-sm btn-primary add_attributre" onclick="add_wholesale_step(this);">
                                                                            <i class="fa fa-plus"></i> Add
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer">
                                        <button type="submit" value="close" name = "btnSubmit" class="btn btn-primary"><i class="fa fa-check-square-o"></i><span>SAVE & Close</span> </button>
                                        <button type="submit" value="new" name = "btnSubmit" class="btn btn-primary"><i class="fa fa-plus-square"></i> SAVE & New</button>
                                        <button type="submit" value="edit" name = "btnSubmit" class="btn btn-primary"><i class="fa fa-pencil-square-o"></i> SAVE & Edit</button>
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
    // var attribute_set_length = 0;
var store_id = "{{old('store')}}";
var vendor_id = "{{old('vendor')}}";
var brand_id = "{{old('brand')}}";
var category_id = {!! json_encode(old('category')) !!};
var attribute_id = {!! json_encode(old('attributes')) !!};
var attribute_values = {!! json_encode(old('attribute_values'))!!}

$(function() {


    setTimeout(function(){ getBrands(); }, 500);
    setTimeout( function() { getCategories(); }, 500);

    $("#vendor").change(function() {
        vendor_id = $(this).val();
        getStores();
    });

    $("#store").change(function() {
        store_id = $(this).val();
        getBrands();
        getCategories();
        getAttribute();
     });

    $('.product_tab').click(function(){
        $('#active_tab').val($(this).find('span').text());
    });
});

function add_attribute(e, lnght){

    var attributes = $(e).closest(".attributes");
    var attribute_id = attributes.find(".attribute").val();
    var attribute_name = attributes.find(".attribute option:selected").text();
    if(!attributes.find(".attribute"+attribute_name).is(":visible")){
        if(attribute_id!=''){
            $.ajax({
                type: "GET",
                url: "{{ url('/supplier/products/get_attribute_values') }}/"+attribute_id+"/"+lnght,
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

function add_wholesale_step(){
    $("#wholesale_container").append(
        `<div class="row py-2">
            <div class="col-md-8">
                <div class="row">
                    <div class="col-4">
                        <input type="number" class="form-control" name="wholesale[min_order_qty][]" id="" placeholder="Min Order Qty">
                    </div>
                    <div class="col-4">
                        <input type="number" class="form-control" name="wholesale[max_order_qty][]" id="" placeholder="Max Order Qty">
                    </div>
                    <div class="col-4">
                        <input type="number" class="form-control" name="wholesale[wholesale_price][]" step="any" id="" placeholder="Wholesale price">
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <button type="button" class="btn btn-sm btn-danger px-3" onclick="remove_wholesale_step(this);">
                    <i class="fa fa-times"></i>
                </button>
            </div>
        </div>`
    )
}

function remove_wholesale_step(el) {
    $(el).parent().parent().remove();
}


function getBrands(){
    if(store_id != ''){
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
                if($("#brand option[value='"+brand_id+"']").length > 0){
                    $('#brand').val(brand_id);
                }
            },
            error: function (data) {
            }
        });
    }
}

function getCategories()
{
    if(store_id != ''){
        $.ajax({
            type: "get",
            url: "{{ url('/get-categories-hierarchy') }}/"+store_id,
            headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            dataType: 'json',
            success: function (data) {
                $("#categories").html(data.categories);
                if(category_id != null && category_id != ''){
                    $.each(category_id, function(index, value){
                        $("#category_"+value).prop('checked', true);
                    });
                }
            },
            error: function (data) {
            }
        });
    }
}

</script>
@endsection
