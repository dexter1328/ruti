@extends('vendor.layout.main')
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
    height: 397px;
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
                <div class="left"><span>Edit Product</span></div>
            </div>
            <div class="card-body">
                <div class="container-fluid">
                    <form id="signupForm" method="post" action="{{route('vendor.products.update', $product->sku)}}" enctype="multipart/form-data">
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
                                                        @if ($errors->has('title')) <span class="text-danger">{{ $errors->first('title') }}</span> @endif
                                                    </div>
                                                </div>


                                                <div class="form-group row">
                                                    <div class="col-sm-12">
                                                        <label>Description</label>
                                                        <textarea id="summernoteEditor" name="description">{!! old('description', $product->description) !!}</textarea>
                                                        @if ($errors->has('description')) <span class="text-danger"> {{ $errors->first('description') }}</span> @endif
                                                    </div>
                                                </div>


                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group row">
                                                    <div class="col-sm-12">
                                                        <label>Brand</label>
                                                        <input type="text" name="brand" class="form-control" value="{{old('brand', $product->brand)}}" placeholder="Enter Brand">
                                                        @if ($errors->has('brand'))
                                                            <span class="text-danger">{{ $errors->first('brand') }}</span>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-sm-12">
                                                        <label>Category</label>
                                                        <select name="w2b_category_1" id="w2b_category_1" class="form-control">
                                                            <option value="">Select Category</option>
                                                            @foreach($categories as $category)
                                                                <option value="{{ $category->category1 }}" {{ $category->category1 == $product->w2b_category_1 ? 'selected' : '' }}>{{$category->category1}}</option>
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
                                                            <input type="number" name="retail_price" class="form-control" value="{{old('retail_price', $product->retail_price)}}" placeholder="Enter Price">
                                                            @if ($errors->has('retail_price'))
                                                                <span class="text-danger">{{ $errors->first('retail_price') }}</span>
                                                            @endif
                                                        </div>

                                                        <div class="col-xs-12 col-md-6">
                                                            <label for="input-11" >Shipping Price<span class="text-danger">*</span></label>
                                                            <input type="number" name="shipping_price" class="form-control" value="{{old('shipping_price', $product->shipping_price)}}" placeholder="Enter Shipping Price">
                                                            @if ($errors->has('shipping_price'))
                                                                <span class="text-danger">{{ $errors->first('shipping_price') }}</span>
                                                            @endif
                                                        </div>
                                                        <div class="col-xs-12 col-md-6">
                                                            <label for="input-11" >SKU<span class="text-danger">*</span></label>
                                                            <input type="text" name="sku" class="form-control" value="{{old('sku', $product->sku)}}" placeholder="Enter SKU">
                                                            @if ($errors->has('sku'))
                                                                <span class="text-danger">{{ $errors->first('sku') }}</span>
                                                            @endif
                                                        </div>
                                                        <div class="col-xs-12 col-md-6">
                                                            <label for="input-11" >Stock Quantity<span class="text-danger">*</span></label>
                                                            <input type="number" name="stock" class="form-control" value="{{old('stock', $product->stock)}}" placeholder="Enter Quantity">
                                                            @if ($errors->has('stock'))
                                                                <span class="text-danger">{{ $errors->first('stock') }}</span>
                                                            @endif
                                                        </div>
                                                        <div class="col-xs-12 col-md-6">
                                                            <label for="input-11" >Change Images<span class="text-danger">*</span></label>
                                                            <input type="file" class="form-control" name="image[]" multiple="multiple">
                                                            @if ($errors->has('image'))
                                                                <span class="text-danger">{{ $errors->first('image') }}</span>
                                                            @endif
                                                            @if ($product->original_image_url)
                                                                <img src="{{ $product->original_image_url}}" alt="Image" style="width: 15%">
                                                            @endif
                                                            @if ($product->extra_img_1)
                                                                <img src="{{ $product->extra_img_1}}" alt="Image" style="width: 15%">
                                                            @endif
                                                            @if ($product->extra_img_2)
                                                                <img src="{{ $product->extra_img_2}}" alt="Image" style="width: 15%">
                                                            @endif
                                                            @if ($product->extra_img_3)
                                                                <img src="{{ $product->extra_img_3}}" alt="Image" style="width: 15%">
                                                            @endif
                                                            @if ($product->extra_img_4)
                                                                <img src="{{ $product->extra_img_4}}" alt="Image" style="width: 15%">
                                                            @endif
                                                            @if ($product->extra_img_5)
                                                                <img src="{{ $product->extra_img_5}}" alt="Image" style="width: 15%">
                                                            @endif

                                                        </div>
                                                    </div>
                                                    {{-- <div class="row">
                                                        <div class="col-md-12">
                                                            <label for="" >Wholesale Settings</label>

                                                            <div class="row mb-3">
                                                                <div class="col-xs-12 col-md-6">
                                                                    <label for="input-11" >Minimum Wholesale Quantity</label>
                                                                    <input type="number" name="min_wholesale_qty" class="form-control" value="{{old('min_wholesale_qty', $product->min_wholesale_qty)}}" placeholder="Minimum Wholesale Quantity">
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
                                                                @php($wholesale_price_range = json_decode($product->wholesale_price_range ?? '[]', true))
                                                                @if(count($wholesale_price_range)>0)
                                                                    @foreach($wholesale_price_range as $range)
                                                                    <div class="row py-2">
                                                                        <div class="col-md-8">
                                                                            <div class="input-group">
                                                                                <span class="input-group-text">Min Order</span>
                                                                                <input type="number" class="form-control" name="wholesale[min_order_qty][]" placeholder="Min Order Qty" value="{{$range['min_order_qty'] ?? ''}}">
                                                                                <span class="input-group-text">Max Order</span>
                                                                                <input type="number" class="form-control" name="wholesale[max_order_qty][]" placeholder="Max Order Qty" value="{{$range['max_order_qty'] ?? ''}}">
                                                                                <span class="input-group-text">Whole Sale Price</span>
                                                                                <input type="number" class="form-control" name="wholesale[wholesale_price][]" step="any" placeholder="Wholesale price" value="{{$range['wholesale_price'] ?? ''}}">
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-4">
                                                                            @if($loop->index == 0)
                                                                                <button type="button" class="btn btn-sm btn-primary add_attributre" onclick="add_wholesale_step(this);">
                                                                                    <i class="fa fa-plus"></i> Add
                                                                                </button>
                                                                            @else
                                                                                <button type="button" class="btn btn-sm btn-danger px-3" onclick="remove_wholesale_step(this);">
                                                                                    <i class="fa fa-times"></i>
                                                                                </button>
                                                                            @endif

                                                                        </div>
                                                                    </div>
                                                                    @endforeach
                                                                @else
                                                                <div class="row pb-2">
                                                                    <div class="col-md-8">
                                                                        <div class="row">
                                                                            <div class="col-4">
                                                                                <input type="number" class="form-control" name="wholesale[min_order_qty][]" placeholder="Min Order Qty">
                                                                            </div>
                                                                            <div class="col-4">
                                                                                <input type="number" class="form-control" name="wholesale[max_order_qty][]" placeholder="Max Order Qty">
                                                                            </div>
                                                                            <div class="col-4">
                                                                                <input type="number" class="form-control" name="wholesale[wholesale_price][]" step="any" placeholder="Wholesale price">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <button type="button" class="btn btn-sm btn-primary add_attributre" onclick="add_wholesale_step(this);">
                                                                            <i class="fa fa-plus"></i> Add
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div> --}}
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
                    url: "{{ url('/vendor/products/get_attribute_values') }}/"+attribute_id+"/"+lnght,
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
