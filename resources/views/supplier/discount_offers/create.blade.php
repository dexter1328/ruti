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
    width: 33%;
    padding: 11px;
    margin-top: 34px;
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
    height: 485px;
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

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <div class="left"><span>Add Offers</span></div>
            </div>
            <div class="card-body">
                <div class="container-fluid">
                    <form id="signupForm" method="post" action="{{route('supplier.discount_offers.store')}}" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <!-- <div class="card-header">
                                    <div class="left"> Products</div>
                                </div> -->
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group row">
                                                <div class="col-sm-12">
                                                    <label>Title<span class="text-danger">*</span></label>
                                                    <input type="text" name="title" class="form-control" value="{{old('title')}}" placeholder="Enter Title">
                                                    @if ($errors->has('title')) <span class="text-danger">{{ $errors->first('title') }}</span> @endif
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-sm-12">
                                                    <label>Image</label>
                                                    <input type="file" name="image" class="form-control" value="{{old('image')}}">
                                                    @if ($errors->has('image')) <span class="text-danger">{{ $errors->first('image') }}</span> @endif
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-sm-12">
                                                    <label>Categories</label>
                                                    <select class="form-control" name="categories[]" id="categories" multiple="multiple">
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group row">
                                                <div class="col-sm-12">
                                                    <label>Store<span class="text-danger">*</span></label>
                                                    <select name="store" id="store" class="form-control">
                                                        <option value="">Select Store</option>
                                                            @foreach($vendor_stores as $vendor_store)
                                                                <option value="{{$vendor_store->id}}" {{ (old("store") == $vendor_store->id ? "selected":"") }}>{{$vendor_store->name}}</option>
                                                            @endforeach
                                                    </select>
                                                    @if ($errors->has('store'))
                                                    <span class="text-danger">{{ $errors->first('store') }}
                                                    </span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-sm-12">
                                                    <label>Discount</label>
                                                    <input type="text" name="discount" class="form-control" value="{{old('discount')}}">
                                                    @if ($errors->has('discount'))
                                                        <span class="text-danger">{{ $errors->first('discount') }}</span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-sm-12">
                                                    <label>Product</label>
                                                    <select name="product[]" id="product" class="form-control" multiple="multiple">
                                                        <!-- <option value="">Select Product</option> -->
                                                    </select>
                                                    @if ($errors->has('product'))
                                                    <span class="text-danger">{{ $errors->first('product') }}
                                                    </span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="form-group row">
                                                <div class="col-lg-12">
                                                    <label>Description</label>
                                                    <textarea name="description" class="form-control">{{old('description')}}</textarea>
                                                    @if ($errors->has('description')) <span class="text-danger"> {{ $errors->first('description') }}</span> @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-success"><i class="fa fa-check-square-o"></i> SAVE</button>
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
var category_ids = {!! json_encode(old('categories')) !!};
var store_id = "{{old('store')}}";
var product_ids = {!! json_encode(old('product')) !!};

$(document).ready(function() {
    setTimeout(function(){ getCategoriesDropDown(); }, 500);
    setTimeout(function(){ getProductsDropdown(); }, 500);

    $('#categories').multiselect({
        includeSelectAllOption: true,
        nonSelectedText: 'Select Categories',
        buttonWidth: '100%',
        maxHeight: 500,
    });

    $('#product').multiselect({
        includeSelectAllOption: true,
        nonSelectedText: 'Select Product',
        buttonWidth: '100%',
        maxHeight: 500,
    });

    $("#store").change(function() {
        store_id = $(this).val();
        getCategoriesDropDown();
        getProductsDropdown();
    });
});

function getProductsDropdown(){
    if(store_id != ''){
        $.ajax({
            type: "get",
            url: "{{ url('/get-product') }}/"+store_id,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            dataType: 'json',
            success: function (data) {
                $('#product').empty();
                $("#product").append(data.products);
                if(product_ids != null && product_ids != ''){
                    $.each(product_ids, function(index, value){
                        if($("#product option[value='"+value+"']").length > 0){
                            $("#product option[value='" + value + "']").prop("selected", true);
                        }
                    });
                }
                $('#product').multiselect('rebuild');
            },
            error: function (data) {
            }
        });

    }else{

        $("#store").val('');
    }

}

function getCategoriesDropDown(){

    if(store_id != ''){

        $.ajax({
            type: "get",
            url: "{{ url('/get-categories-dropdown') }}/"+store_id,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            dataType: 'json',
            success: function (data) {
                console.log(data.categories);
                $('#categories').empty();
                $("#categories").append(data.categories);
                if(category_ids != null && category_ids != ''){
                    $.each(category_ids, function(index, value){
                        if($("#categories option[value='"+value+"']").length > 0){
                            $("#categories option[value='" + value + "']").prop("selected", true);
                        }
                    });
                }
                $('#categories').multiselect('rebuild');
            },
            error: function (data) {
            }
        });
    }else{

        $("#store_id").val('');
    }
}

</script>
@endsection
