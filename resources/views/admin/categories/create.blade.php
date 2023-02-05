@extends('admin.layout.main')

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <div class="left"><!-- <i class="fa fa-list"></i> --><span>Add Category</span></div>
            </div>
            <div class="card-body">
            	<div class="container-fluid">
	                <form method="post" action="{{route('categories.store')}}" enctype="multipart/form-data"> 
                    @csrf 
                    <div class="form-group">
                        <label for="input-10">Vendor<span class="text-danger">*</span></label>
                        <select name="vendor_id" class="form-control" id="vendor_id">
                            <option value="">Select Vendor</option>
                            @foreach($vendors as $vendor)
                                <option value="{{$vendor->id}}" {{ (old("vendor_id") == $vendor->id ? "selected":"") }}>{{$vendor->name}}</option>
                            @endforeach
                        </select>
                        @if ($errors->has('vendor_id'))
                            <span class="text-danger">{{ $errors->first('vendor_id') }}</span>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="input-11">Store<span class="text-danger">*</span></label>
                        <select name="store_id" class="form-control" id="vendor_store">
                            <option value="">Select store</option>
                        </select>
                        @if ($errors->has('store_id'))
                            <span class="text-danger">{{ $errors->first('store_id') }}</span>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="name">Name<span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="name" name="name" value="{{old('name')}}"> 
                        @if ($errors->has('name')) 
                            <span class="text-danger">{{ $errors->first('name') }}</span> 
                        @endif 
                    </div>
                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea class="form-control" id="description" name="description">{{old('description')}}</textarea>
                    </div>
                    <div class="form-group">
                        <label for="parent">Parent</label>
                        <select id="parent" name="parent" class="form-control">
                            <option value="">Select Parent</option> 
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="image">Image</label>
                        <input type="file" class="form-control" id="image" name="image"> 
                        @if ($errors->has('image')) 
                            <span class="text-danger">{{ $errors->first('image') }}</span> 
                        @endif
                    </div>
                    <center>
                        <button type="submit" class="btn btn-success"><i class="fa fa-check-square-o"></i> SAVE</button>
                        <a href="{{url('admin/categories')}}"><button type="button" class="btn btn-danger"><i class="fa fa-times"></i> CANCEL</button></a>
                    </center>
                </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">

    var vendor_id = "{{old('vendor_id')}}"; 
    var store_id = "{{old('store_id')}}";
    var parent_id = "{{old('parent')}}";


    $(document).ready(function() {
    
        setTimeout(function(){ getStores(); }, 500);
        setTimeout(function(){ getCategoriesDropDown(); }, 700);

        $("#vendor_id").change(function() {
            vendor_id = $(this).val();
            getStores();
        });

        $("#vendor_store").change(function() {
            store_id = $(this).val();
            getCategoriesDropDown();
        });

        $("#parent").change(function() {
            parent_id = $(this).val();
        });
    });

    function getStores(){

        if(vendor_id != ''){

            $.ajax({
                type: "get",
                url: "{{ url('/get-stores') }}/"+vendor_id,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                dataType: 'json',
                success: function (data) {
                    $('#vendor_store').empty();
                    $("#vendor_store").append('<option value="">Select Store</option>');
                    $.each(data, function(i, val) {
                        $("#vendor_store").append('<option value="'+val.id+'">'+val.name+'</option>');
                    });
                    if($("#vendor_store option[value='"+store_id+"']").length > 0){
                        $('#vendor_store').val(store_id);
                    }
                },
                error: function (data) {
                }
            });
        }else{
    
            $("#vendor_id").val('');
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
                   console.log(data);
                    $('#parent').empty();
                    $("#parent").append('<option value="">Select Parent</option>');
                    $("#parent").append(data.categories);
                    if($("#parent option[value='"+parent_id+"']").length > 0){
                        $('#parent').val(parent_id);
                    }
                },
                error: function (data) {
                }
            });
        }else{
    
            $("#vendor_store").val('');
        }
    }
</script> 
@endsection 