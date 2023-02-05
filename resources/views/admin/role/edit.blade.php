@extends('admin.layout.main')

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <div class="left"><!-- <i class="fa fa-edit"></i> --><span>Edit Role</span></div>
            </div>
            <div class="card-body">
            	<div class="container-fluid">
	                <form class="form-horizontal" method="post" action="{{ route('admin_roles.update',$admin_role->id) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PATCH')
                    <div class="form-group row">
                        <label for="role_name" class="col-sm-2 col-form-label">Role Name<span class="text-danger">*</span></label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control error" id="role_name" name="role_name" value="{{old('role_name', $admin_role->role_name)}}">
                            @if ($errors->has('role_name'))
                                <span class="text-danger">{{ $errors->first('role_name') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="status" class="col-sm-2 col-form-label">Status<span class="text-danger">*</span></label>
                        <div class="col-sm-10">
                            <select class="form-control" id="status" name="status">
                                <option value="">Select Status</option>
                                <option value="active" @if(old('status')) @if(old('status')=='active') selected="selected" @endif @else @if($admin_role->status=='active') selected="selected" @endif @endif>Active</option>
                                <option value="deactive" @if(old('status')) @if(old('status')=='deactive') selected="selected" @endif @else @if($admin_role->status=='deactive') selected="selected" @endif @endif>Deactive</option>
                            </select>
                            @if ($errors->has('status'))
                                <span class="text-danger">{{ $errors->first('status') }}</span>
                            @endif
                        </div>
                    </div>
                    @if ($errors->has('permision'))
                        <span class="text-danger">{{ $errors->first('permision') }}</span>
                    @endif
                    <h4 class="form-header">
                        <i class="fa fa-file-text-o"></i> PERMISSIONS   
                    </h4>
                    <div class="table-responsive">
                        <table id="default-datatable" class="table table-bordered">
                            <thead>
                                <tr style="text-align: center;">
                                    <th>Module Name</th>
                                     <th>Read
                                        <div class="checkbox-th table-right-tick">
                                            <span class="bmd-form-group is-filled">
                                                <div class="checkbox">
                                                    <label>
                                                        <input type="checkbox" class="chkallread">
                                                    </label>
                                                </div>
                                            </span>
                                        </div>
                                    </th>
                                    <th>Write
                                        <div class="checkbox-th table-right-tick">
                                            <span class="bmd-form-group is-filled">
                                                <div class="checkbox">
                                                    <label>
                                                        <input type="checkbox" class="chkallwrite">
                                                    </label>
                                                </div>
                                            </span>
                                        </div>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach(admin_modules() as $key => $module)
                                @php
                                    $check_read = '';
                                    $check_write = '';
                                    if(old('permision')){
                                        if(array_key_exists($key,old('permision')) && array_key_exists('read', old('permision')[$key])){
                                            $check_read = 'checked';
                                        }
                                        if(array_key_exists($key,old('permision')) && array_key_exists('write', old('permision')[$key])){
                                            $check_write = 'checked';
                                        }
                                    }else{
                                        if(isset($permisions[$key]['read']) && $permisions[$key]['read'] == 'yes'){
                                            $check_read = 'checked';
                                        }
                                        if(isset($permisions[$key]['write']) && $permisions[$key]['write'] == 'yes'){
                                            $check_write = 'checked';
                                        }
                                    }
                                @endphp
                                <tr>
                                    <td>{{$module}}</td>
                                    <td align="center">
                                        <div class="icheck-material-primary">
                                            <input type="checkbox" id="read-{{$key}}" class="read_chk" name="permision[{{$key}}][read]" value="yes"{{$check_read}}> 
                                            <label for="read-{{$key}}"></label>
                                        </div>
                                    </td>
                                    <td align="center">
                                        <div class="icheck-material-primary">
                                            <input type="checkbox" id="write-{{$key}}" class="write_chk" name="permision[{{$key}}][write]" value="yes"{{$check_write}}> 
                                            <label for="write-{{$key}}"></label>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="form-footer">
                        <center>
                            <button type="submit" class="btn btn-success"><i class="fa fa-check-square-o"></i> SAVE</button>
                            <a href="{{url('admin/admin_roles')}}"><button type="button" class="btn btn-danger"><i class="fa fa-times"></i> CANCEL</button></a>
                        </center>
                    </div>
                </form>
                </div>
            </div>
        </div>
    </div>
</div>
@if(old('permision'))

<script>
    $(document).ready(function(){

        var flag1 = true;
        $('.read_chk').each(function() {
            if ($(this).prop("checked") == false){
                flag1 = false;
            }
        });
        $('.chkallread').prop('checked', flag1);

        var flag2 = true;
        $('.write_chk').each(function() {
            if ($(this).prop("checked") == false){
                flag2 = false;
            }
        });
        $('.chkallwrite').prop('checked', flag2);

    });
</script>
@endif
<script>
    $(document).ready(function(){

        $('.chkallread').on('click', function() { 
            if($(this).prop("checked") == false && $('.chkallwrite').prop("checked") == true){
                $(this).prop('checked', true); 
                $('.write_chk').each(function() {
                    var id_arr = $(this).attr('id').split('-');
                    $('#read-'+id_arr[1]).prop("checked", $(this).prop("checked"));
                });
            }else if($(this).prop("checked") == false && $('.chkallwrite').prop("checked") == false){
                $('.write_chk').each(function() {
                    var id_arr = $(this).attr('id').split('-');
                    $('#read-'+id_arr[1]).prop("checked", $(this).prop("checked"));
                });
            }else{
                $('.read_chk').prop('checked', $(this).prop("checked"));  
            }
            /*if($('.chkallwrite').prop("checked") == false){
                console.log('heere');
                $('.write_chk').each(function() {
                    $('.read_chk').prop('checked', $(this).prop("checked")); 
                });
                //$('.read_chk').prop('checked', $(this).prop("checked"));              
            }else{
                $(this).prop('checked', true); 
            }*/   
        });

        $('.read_chk').on('click', function() {

            var id_arr = $(this).attr('id').split('-');
            if($(this).prop("checked") == false && $('.chkallread').prop("checked") == true && $('#write-'+id_arr[1]).prop("checked") == false){
                $('.chkallread').prop('checked', $(this).prop("checked")); 
            }else if($(this).prop("checked") == false && $('.chkallread').prop("checked") == false && $('#write-'+id_arr[1]).prop("checked") == false){
                $(this).prop('checked', false); 
            }else{
                $(this).prop('checked', true); 
            }

            var flag = true;
            $('.read_chk').each(function() {
                if ($(this).prop("checked") == false){
                    flag = false;
                }
            });
            $('.chkallread').prop('checked', flag);
        });

        $('.chkallwrite').on('click', function() {     
            $('.write_chk').prop('checked', $(this).prop("checked")); 

            if($(this).prop("checked") == true){
                $('.chkallread').prop('checked', $(this).prop("checked")); 
                $('.read_chk').prop('checked', $(this).prop("checked"));      
            }    
        });

        $('.write_chk').on('click', function() {

            var id_arr = $(this).attr('id').split('-');
            if($('#read-'+id_arr[1]).prop("checked") == false){
                $('#read-'+id_arr[1]).prop('checked', $(this).prop("checked"));
            }

            if($(this).prop("checked") == false && $('.chkallwrite').prop("checked") == true){
                $('.chkallwrite').prop('checked', $(this).prop("checked")); 
            }

            var flag2 = true;
            $('.write_chk').each(function() {
                if ($(this).prop("checked") == false){
                    flag2 = false;
                }
            });
            $('.chkallwrite').prop('checked', flag2);

            var flag1 = true;
            $('.read_chk').each(function() {
                if ($(this).prop("checked") == false){
                    flag1 = false;
                }
            });
            $('.chkallread').prop('checked', flag1);
        });
    });
</script>
@endsection