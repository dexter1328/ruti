@extends('employee.layout.main')

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <div class="left"><span>Privacy Policy</span></div>
            </div>
            <div class="card-body">
            	<div class="container-fluid">
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
                    @endif
                    <div id="ajaxMsg"></div>
                    @php //echo '<pre>'; print_r($privacy_policy['content']); echo '</pre>'; @endphp
                    <form id="addFrm" method="post" action="{{route('pagemeta.privacy-policy')}}" enctype="multipart/form-data"> 
                        @csrf 
                        <div class="form-group">
                            <label for="title">Title</label>
                            <input type="text" class="form-control" id="title" name="title" value="{{old('title', isset($privacy_policy['title']) ? $privacy_policy['title'] : '')}}"> 
                            @if ($errors->has('title')) 
                                <span class="text-danger">{{ $errors->first('title') }}</span> 
                            @endif 
                        </div>
                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea class="form-control" id="description" name="description" rows="10">{{old('description', isset($privacy_policy['description']) ? $privacy_policy['description'] : '')}}</textarea>
                            @if ($errors->has('description')) 
                                <span class="text-danger">{{ $errors->first('description') }}</span> 
                            @endif 
                        </div>
                        <div class="form-group">
                            <div class="float-sm-right">        
                                <button type="button" id="add_value" class="btn btn-sm btn-primary">
                                    <i class="fa fa-plus"></i> Add Content
                                </button>
                                <div style="height: 10px;"></div>
                            </div>
                        </div>
                        <div class="form-group">
                            <input type="hidden" id="total_content" value="{{isset($privacy_policy['content']) ? count($privacy_policy['content']) : 1}}">
                            <table class="table table-bordered" width="100%">
                                <thead>
                                    <tr>
                                        <th width="35%">Title</th>
                                        <th width="60%">Description</th>
                                        <th width="5%">&nbsp;</th>
                                    </tr>
                                </thead>
                                <tbody id="value_rows">
                                    @foreach($privacy_policy['content'] as $key => $content)
                                    <tr>
                                        <td>
                                            <input type="text" name="privacy_policy[{{$key}}][title]" class="form-control" value="{{$content->title}}">
                                        </td>
                                        <td>
                                            <textarea name="privacy_policy[{{$key}}][description]" class="form-control" rows="5">{{$content->description}}</textarea>
                                        </td>
                                        <td class="action">
                                            <a href="javascript:void(0);" onclick="removeContent(this,'{{$content->id}}')">
                                                <i class="icon-trash icons" style="font-size:18px;"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <span id="values_error" class="text-danger"></span>
                        </div>
                        <center>
                            <button type="button" id="submitBtn" class="btn btn-success"><i class="fa fa-check-square-o"></i> SAVE</button>
                        </center>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function () {

        var values_counter = $('#total_content').val();
        $('#add_value').click(function(){

            var row = '';
            row += '<tr>';
                row += '<td>';
                    row += '<input type="text" name="privacy_policy['+values_counter+'][title]" class="form-control" value="">';
                row += '</td>';
                row += '<td>';
                    row += '<textarea name="privacy_policy['+values_counter+'][description]" class="form-control" rows="5"></textarea>';
                row += '</td>';
                row += '<td>';
                    row += '<a href="javascript:void(0);" onclick="$(this).closest(\'tr\').remove();">';
                        row += '<i class="icon-trash icons" style="font-size:18px;"></i>';
                    row += '</a>';
                row += '</td>';
            row += '</tr>';

            $("#value_rows").append(row);
            values_counter = values_counter + 1;
        });

        $('#submitBtn').click(function(){

            /*$('#values_error').html('');
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
            }*/
            $("#addFrm").submit();
        });
    });

    function removeContent(e, id)
    {
        var r = confirm("Are you sure want to delete!");
        if (r == true) {
            $.ajax({
                type: "GET",
                url: "{{ url('employee/remove-privacy-policy') }}/"+id,
                data: {"_token": "{{ csrf_token() }}"},
                success: function (data) {
                    if(data.status == 200){
                        $('.alert').remove();
                        $('#ajaxMsg').html('<div class="alert alert-success alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert">×</button><div class="alert-icon"><i class="fa fa-check"></i></div><div class="alert-message"><span><strong>Success!</strong> '+data.msg+'</span></div></div>');
                        $(e).closest('tr').remove();
                    }
                },
                error: function (data) {
                    console.log('Error:', data);
                }
            });
        }
    }
</script>
@endsection 