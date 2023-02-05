@extends('vendor.layout.main')

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <div class="left"><span>Add Attribute</span></div>
            </div>
            <div class="card-body">
                <form id="addFrm" method="post" action="{{route('vendor.attributes.store')}}" enctype="multipart/form-data"> 
                    @csrf 
                    <div class="form-group">
                        <label for="name">Name<span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="name" name="name" value="{{old('name')}}"> 
                        @if ($errors->has('name')) 
                            <span class="text-danger">{{ $errors->first('name') }}</span> 
                        @endif 
                    </div>
                    <div class="form-group">
                        <label for="input-11">Store<span class="text-danger">*</span></label>
                        <select name="store_id" class="form-control" id="vendor_store">
                            <option value="">Select store</option>
                            @foreach($vendor_stores as $vendor_store)
                            <option value="{{$vendor_store->id}}" {{ (old("store_id") == $vendor_store->id ? "selected":"") }}>{{$vendor_store->name}}</option>
                            @endforeach
                        </select>
                        @if ($errors->has('store_id'))
                            <span class="text-danger">{{ $errors->first('store_id') }}</span>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea class="form-control" id="description" name="description">{{old('description')}}</textarea>
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
                                <tr>
                                    <td>
                                        <input type="radio" name="defual_value" value="0">
                                    </td>
                                    <td>
                                        <input type="text" name="values[0]" class="form-control value">
                                    </td>
                                    <td>
                                        <a href="javascript:void(0);" onclick="$(this).closest('tr').remove();"><i class="icon-trash icons" style="font-size:18px;"></i></a>
                                    </td>
                                </tr>
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

        var values_counter = 1;
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
                $("#addFrm").submit();
            }else{
                $('#values_error').html('The value must be unique.');
            }
        });
    });
</script>
@endsection 