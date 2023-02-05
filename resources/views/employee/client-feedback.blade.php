@extends('employee.layout.main')

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <div class="left"><span>Client Feedback</span></div>
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
                    @php //echo '<pre>'; print_r($client_feedback['content']); echo '</pre>'; @endphp
                    <form id="addFrm" method="post" action="{{route('pagemeta.client-feedback')}}" enctype="multipart/form-data"> 
                        @csrf 
                        <div class="form-group">
                            <label for="name">Title</label>
                            <input type="text" class="form-control" id="title" name="title" value="{{old('title', $client_feedback['title'])}}"> 
                            @if ($errors->has('title')) 
                                <span class="text-danger">{{ $errors->first('title') }}</span> 
                            @endif 
                        </div>
                        <div class="form-group">
                            <div class="float-sm-right">        
                                <button type="button" id="add_value" class="btn btn-sm btn-primary">
                                    <i class="fa fa-plus"></i> Add Feedback
                                </button>
                                <div style="height: 10px;"></div>
                            </div>
                        </div>
                        <div class="form-group">
                            <input type="hidden" id="total_content" value="{{isset($client_feedback['content']) ? count($client_feedback['content']) : 1}}">
                            <table class="table table-bordered" width="100%">
                                <thead>
                                    <tr>
                                        <th width="20%" valign="top">Image</th>
                                        <th width="20%">Name</th>
                                        <th width="20%">State</th>
                                        <th width="35%">Description</th>
                                        <th width="5%">&nbsp;</th>
                                    </tr>
                                </thead>
                                <tbody id="value_rows">
                                    @foreach($client_feedback['content'] as $key => $content)
                                    <tr>
                                        <td>
                                            <input type="file" name="client_feedback[{{$key}}][image]">
                                            @if($content->image!='')
                                                <input type="hidden" name="client_feedback[{{$key}}][exist_image]" value="{{$content->image}}">
                                                <br>
                                                <a href="{{asset('public/images/pagemeta/'.$content->image)}}" target="_blank">Click here</a> to view image
                                            @endif
                                        </td>
                                        <td>
                                            <input type="text" name="client_feedback[{{$key}}][name]" class="form-control" value="{{$content->name}}">
                                        </td>
                                        <td>
                                            <input type="text" name="client_feedback[{{$key}}][state]" class="form-control" value="{{$content->state}}">
                                        </td>
                                        <td>
                                            <textarea name="client_feedback[{{$key}}][description]" class="form-control" rows="5">{{$content->description}}</textarea>
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
                            <!-- <a href="#"><button type="button" class="btn btn-danger"><i class="fa fa-times"></i> CANCEL</button></a> -->
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
                    row += '<input type="file" name="client_feedback['+values_counter+'][image]">';
                row += '</td>';
                row += '<td>';
                    row += '<input type="text" name="client_feedback['+values_counter+'][name]" class="form-control" value="">';
                row += '</td>';
                row += '<td>';
                    row += '<input type="text" name="client_feedback['+values_counter+'][state]" class="form-control" value="">';
                row += '</td>';
                row += '<td>';
                    row += '<textarea name="client_feedback['+values_counter+'][description]" class="form-control" rows="5"></textarea>';
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
                url: "{{ url('employee/remove-client-feedback') }}/"+id,
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