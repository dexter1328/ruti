@extends('admin.layout.main')

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <div class="left"><!-- <i class="fa fa-list"></i> --><span>Edit Category</span></div>
            </div>
            <div class="card-body">
            	<div class="container-fluid">
	                <form method="post" action="{{route('categories.update', $category->id)}}" enctype="multipart/form-data"> 
                    @csrf 
                    @method('PATCH')
                    <div class="form-group">
                        <label for="input-10">Vendor<span class="text-danger">*</span></label>
                        <select name="vendor_id" class="form-control" id="vendor_id">
                            <option value="">Select Vendor</option>
                            @foreach($vendors as $vendor)
                                <option value="{{$vendor->id}}" {{ (old("vendor_id", $category->vendor_id) == $vendor->id ? "selected":"") }}>{{$vendor->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="input-11">Store<span class="text-danger">*</span></label>
                        <select name="store_id" class="form-control" id="vendor_store">
                            <option value="">Select store</option>
                            @php /* @endphp
                            @foreach($vendor_stores as $vendor_store)
                                <?PHP $vendor_store_id = ($vendor_store->id == $category->store_id) ? 'selected="selected"' : ''; ?>
                                <option value="{{$vendor_store->id}}" {{ (old("store_id", $category->store_id) == $vendor_store->id ? "selected":"") }}{{$vendor_store->name}}</option>
                            @endforeach
                            @php */ @endphp
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="name">Name<span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="name" name="name" value="{{old('name',$category->name)}}"> 
                        @if ($errors->has('name')) 
                            <span class="text-danger">{{ $errors->first('name') }}</span> 
                        @endif 
                    </div>
                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea class="form-control" id="description" name="description">{!! $category->description !!}</textarea>
                    </div>
                    <div class="form-group">
                        <label for="parent">Parent</label>
                        <select id="parent" name="parent" class="form-control">
                            <option value="">Select Parent</option> 
                            @php /* @endphp
                            @foreach($categories as $key => $value) 
                                <option value="{{$value->id}}" {{($value->id == $category->parent ? "selected" : "")}}>{{$value->name}}</option> 
                            @endforeach
                            @php */ @endphp
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="image">Image</label>
                        <input type="file" class="form-control" id="image" name="image"> 
                        @if ($errors->has('image')) 
                            <span class="text-danger">{{ $errors->first('image') }}</span> 
                        @endif
                        @if($category->image)
                            <br>
                            <a href="{{url('public/images/categories/'.$category->image)}}" rel="prettyPhoto">
                                <img src="{{url('public/images/categories/'.$category->image)}}" style="width: 200px; height: auto;">
                            </a>
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

    var vendor_id = "{{old('vendor_id', $category->vendor_id)}}"; 
    var store_id = "{{old('store_id', $category->store_id)}}";
    var parent_id = "{{old('parent', $category->parent)}}";

    function goBack() {
        window.history.back();
    }

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
        }
    }
  
</script>
@endsection 