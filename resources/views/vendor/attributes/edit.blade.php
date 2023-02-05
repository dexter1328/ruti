@extends('vendor.layout.main')

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <div class="left"><span>Edit Attribute</span></div>
            </div>
            <div class="card-body">
                <form id="editFrm" method="post" action="{{route('vendor.attributes.update', $attribute->id)}}" enctype="multipart/form-data"> 
                    @csrf 
                    @method('PATCH')

                    <div class="form-group">
                        <label for="name">Name<span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="name" name="name" value="{{$attribute->name}}"> 
                        @if ($errors->has('name')) 
                            <span class="text-danger">{{ $errors->first('name') }}</span> 
                        @endif 
                    </div>
                    <div class="form-group">
                        <label for="input-11">Store<span class="text-danger">*</span></label>
                        <select name="store_id" class="form-control" id="vendor_store">
                            <option value="">Select store</option>
                            @foreach($vendor_stores as $vendor_store)
                                <option value="{{$vendor_store->id}}" {{ (old("store_id", $attribute->store_id) == $vendor_store->id ? "selected":"") }}>{{$vendor_store->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea class="form-control" id="description" name="description">{!! $attribute->description !!}</textarea>
                    </div>
                    <div class="form-group">
                        <div class="float-sm-right">        
                            <button type="button" id="add_value" class="btn btn-sm btn-primary">
                                <i class="fa fa-plus"></i> Add Value
                            </button>
                            <div style="height: 10px;"></div>
                        </div>
                    </div>
                    <div class="form-group">
                        <table class="table table-bordered" width="100%">
                            <thead>
                                <tr>
                                    <th width="10%">Defualt</th>
                                    <th width="80%">Value</th>
                                    <th width="10%">&nbsp;</th>
                                </tr>
                            </thead>
                            <tbody id="value_rows">
                                @foreach($attribute_values as $key => $attribute_value)
                                <tr>
                                    <td>
                                        <input type="radio" name="defual_value" value="{{$key}}" @if($attribute_value->is_default=='yes') checked="checked" @endif>
                                    </td>
                                    <td>
                                        <input type="hidden" name="value_ids[{{$key}}]" value="{{$attribute_value->id}}">
                                        <input type="text" name="values[{{$key}}]" class="form-control value" value="{{$attribute_value->name}}">
                                    </td>
                                    <td>
                                        <a href="javascript:void(0);" onclick="delete_value(this,{{$attribute_value->id}});"><i class="icon-trash icons" style="font-size:18px;"></i></a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <span id="values_error" class="text-danger"></span>
                    </div>
                    <center>
                        <button type="button" id="submitBtn" class="btn btn-success"><i class="fa fa-check-square-o"></i> SAVE</button>
                        <a href="{{url('vendor/attributes')}}"><button type="button" class="btn btn-danger"><i class="fa fa-times"></i> CANCEL</button></a> 
                    </center>
                </form>
            </div>
        </div>
    </div>
</div> 
<script type="text/javascript">
    $(document).ready(function () {

        var values_counter = "{{$attribute_values->count()}}";
        $('#add_value').click(function(){
            var str = '';
            str += '<tr>';
                str += '<td>';
                    str += '<input type="radio" name="defual_value" value="'+values_counter+'">';
                str += '</td>';
                str += '<td>';
                    str += '<input type="text" name="values['+values_counter+']" class="form-control value">';
                str += '</td>';
                str += '<td>';
                    str += '<a href="javascript:void(0);" onclick="$(this).closest(\'tr\').remove();"><i class="icon-trash icons" style="font-size:18px;"></i></a>';
                str += '</td>';
            str += '</tr>';
            $("#value_rows").append(str);
            values_counter = values_counter + 1;
        });

        $('#submitBtn').click(function(){

            $('#values_error').html('');
            validate = true;
            values = [];
            $(".value").each(function() {
                if(jQuery.inArray($(this).val(), values) !== -1){
                    validate = false;
                }else{
                    values.push($(this).val());
                }
            });
            if(validate){
                $("#editFrm").submit();
            }else{
                $('#values_error').html('The value must be unique.');
            }
        });
    });

    function delete_value(e,id)
    {
        $.ajax({
            url: "{{ url('/admin/delete-attribute-value') }}/"+id,
            method: 'get',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(result){
                e.closest('tr').remove();
            }
        });
    }
</script>
@endsection 