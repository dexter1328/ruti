@extends('supplier.layout.main')

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <div class="left"><span>Edit Category</span></div>
            </div>
            <div class="card-body">
                <form method="post" action="{{route('supplier_category.update', $item->id)}}" enctype="multipart/form-data">
                    @csrf
                    @method('PATCH')
                    <div class="form-group">
                        <label for="source_id">W2b Category</label>
                        <select name="source_id" class="form-control" id="source_id">
                            <option value="">Select W2b Category</option>
                            @foreach($w2b_categories as $w2b_category)
                                <option value="{{$w2b_category->id}}" {{ (old("source_id", $item->source_id) == $w2b_category->id ? "selected":"") }}>{{$w2b_category->category1}}</option>
                            @endforeach
                        </select>
                        @if ($errors->has('source_id'))
                            <span class="text-danger">{{ $errors->first('source_id') }}</span>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="category">Category Name<span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="category" name="category" value="{{old('category', $item->category1)}}">
                        @if ($errors->has('category'))
                            <span class="text-danger">{{ $errors->first('category') }}</span>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="parent_id">Parent</label>
                        <select id="parent_id" name="parent_id" class="form-control">
                            <option value="">Select Parent Category</option>
                            @foreach($categories as $category)
                                <option value="{{$category->id}}" {{ (old("parent_id", $item->parent_id) == $category->id ? "selected":"") }}>{{$category->category1}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="image">Image</label>
                        <input type="file" class="form-control" id="image" name="image">
                        @if ($errors->has('image'))
                            <span class="text-danger">{{ $errors->first('image') }}</span>
                        @endif
                    </div>
                    <div class="text-center">
                        <button type="submit" class="btn btn-success"><i class="fa fa-check-square-o"></i> SAVE</button>
                        <a href="{{url('supplier/categories')}}"><button type="button" class="btn btn-danger"><i class="fa fa-times"></i> CANCEL</button></a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">

    var store_id = "{{old('store_id', $item->store_id)}}";
    var parent_id = "{{old('parent', $item->parent_id)}}";

    function goBack() {
        window.history.back();
    }

    $(document).ready(function() {


        $("#source_id").change(function() {
            $('#category').val($(this).find('option:selected').text());
        });

    });

</script>
@endsection
