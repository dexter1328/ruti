@extends('vendor.layout.main')

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <div class="left"><span>Edit {{$role->role_name}} Permissions</span></div>
            </div>
            <div class="card-body">
                <form class="form-horizontal" method="post" action="{{ route('vendor.vendor_roles.update',$vendor_role->id) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PATCH')
                    <!-- <div class="form-group row">
                        <label for="role_name" class="col-sm-2 col-form-label">Role Name</label>
                        <div class="col-sm-10">
                            <label class="col-sm-10 col-form-label">{{$role->role_name}}</label>
                            
                        </div>
                    </div> -->
                    <!-- <div class="form-group row">
                        <label for="status" class="col-sm-2 col-form-label">Status<span class="text-danger">*</span></label>
                        <div class="col-sm-10">
                            <select class="form-control" id="status" name="status">
                                <option value="">Select Status</option>
                                <option value="active" @if(old('status')) @if(old('status')=='active') selected="selected" @endif @else @if($vendor_role->status=='active') selected="selected" @endif @endif>Active</option>
                                <option value="deactive" @if(old('status')) @if(old('status')=='deactive') selected="selected" @endif @else @if($vendor_role->status=='deactive') selected="selected" @endif @endif>Deactive</option>
                            </select>
                            @if ($errors->has('status'))
                                <span class="text-danger">{{ $errors->first('status') }}</span>
                            @endif
                        </div>
                    </div> -->
                    <!-- <h4 class="form-header">
                        <i class="fa fa-file-text-o"></i> PERMISSIONS   
                    </h4> -->
                    <h5 style="margin-top:20px;margin-bottom: 20px;">Web Module</h5>
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
                                @foreach(vendor_modules() as $key => $module)
                                <tr>
                                    <td>{{$module}}</td>
                                    <td align="center">
                                        <div class="icheck-material-primary">
                                            <input type="checkbox" id="read-{{$key}}" class="read_chk" name="permision[{{$key}}][read]" value="yes" @if(isset($permisions[$key]['read']) && $permisions[$key]['read'] == 'yes') checked="checked" @endif> 
                                            <label for="read-{{$key}}"></label>
                                        </div>
                                    </td>
                                    <td align="center">
                                        <div class="icheck-material-primary">
                                            <input type="checkbox" id="write-{{$key}}" class="write_chk" name="permision[{{$key}}][write]" value="yes" @if(isset($permisions[$key]['write']) && $permisions[$key]['write'] == 'yes') checked="checked" @endif> 
                                            <label for="write-{{$key}}"></label>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <h5 style="margin-top:20px;margin-bottom: 20px;">Mobile Module</h5>
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
                                                        <input type="checkbox" class="chkallread_mobile">
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
                                                        <input type="checkbox" class="chkallwrite_mobile">
                                                    </label>
                                                </div>
                                            </span>
                                        </div>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach(vendor_mobile_modules() as $key => $module)
                                <tr>
                                    <td>{{$module}}</td>
                                    <td align="center">
                                        <div class="icheck-material-primary">
                                            <input type="checkbox" id="read-mobile-{{$key}}" class="read_chk_mobile" name="permision[{{$key}}][read]" value="yes" @if(isset($permisions[$key]['read']) && $permisions[$key]['read'] == 'yes') checked="checked" @endif> 
                                            <label for="read-mobile-{{$key}}"></label>
                                        </div>
                                    </td>
                                    <td align="center">
                                        <div class="icheck-material-primary">
                                            <input type="checkbox" id="write-mobile-{{$key}}" class="write_chk_mobile" name="permision[{{$key}}][write]" value="yes" @if(isset($permisions[$key]['write']) && $permisions[$key]['write'] == 'yes') checked="checked" @endif> 
                                            <label for="write-mobile-{{$key}}"></label>
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
                            <a href="{{url('vendor/vendor_roles')}}"><button type="button" class="btn btn-danger"><i class="fa fa-times"></i> CANCEL</button></a>
                        </center>
                    </div>
                </form>
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

        // mobile
        var flag1_mobile = true;
        $('.read_chk_mobile').each(function() {
            if ($(this).prop("checked") == false){
                flag1_mobile = false;
            }
        });
        $('.chkallread_mobile').prop('checked', flag1);

        var flag2_mobile = true;
        $('.write_chk_mobile').each(function() {
            if ($(this).prop("checked") == false){
                flag2_mobile = false;
            }
        });
        $('.chkallwrite_mobile').prop('checked', flag2);
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

        // mobile module
        $('.chkallread_mobile').on('click', function() { 
            if($(this).prop("checked") == false && $('.chkallwrite_mobile').prop("checked") == true){
                $(this).prop('checked', true); 
                $('.write_chk_mobile').each(function() {
                    var id_arr = $(this).attr('id').split('-');
                    $('#read-mobile-'+id_arr[1]).prop("checked", $(this).prop("checked"));
                });
            }else if($(this).prop("checked") == false && $('.chkallwrite_mobile').prop("checked") == false){
                $('.write_chk_mobile').each(function() {
                    var id_arr = $(this).attr('id').split('-');
                    $('#read-mobile-'+id_arr[1]).prop("checked", $(this).prop("checked"));
                });
            }else{
                $('.read_chk_mobile').prop('checked', $(this).prop("checked"));  
            } 
        });

        $('.read_chk_mobile').on('click', function() {

            var id_arr = $(this).attr('id').split('-');
            if($(this).prop("checked") == false && $('.chkallread_mobile').prop("checked") == true && $('#write-mobile-'+id_arr[1]).prop("checked") == false){
                $('.chkallread_mobile').prop('checked', $(this).prop("checked")); 
            }else if($(this).prop("checked") == false && $('.chkallread_mobile').prop("checked") == false && $('#write-mobile-'+id_arr[1]).prop("checked") == false){
                $(this).prop('checked', false); 
            }else{
                $(this).prop('checked', true); 
            }

            var flag = true;
            $('.read_chk_mobile').each(function() {
                if ($(this).prop("checked") == false){
                    flag = false;
                }
            });
            $('.chkallread_mobile').prop('checked', flag);
        });

        $('.chkallwrite_mobile').on('click', function() {     
            $('.write_chk_mobile').prop('checked', $(this).prop("checked")); 

            if($(this).prop("checked") == true){
                $('.chkallread_mobile').prop('checked', $(this).prop("checked")); 
                $('.read_chk_mobile').prop('checked', $(this).prop("checked"));      
            }    
        });

        $('.write_chk_mobile').on('click', function() {

            var id_arr = $(this).attr('id').split('-');
            if($('#read-mobile-'+id_arr[1]).prop("checked") == false){
                $('#read-mobile-'+id_arr[1]).prop('checked', $(this).prop("checked"));
            }

            if($(this).prop("checked") == false && $('.chkallwrite_mobile').prop("checked") == true){
                $('.chkallwrite_mobile').prop('checked', $(this).prop("checked")); 
            }

            var flag2 = true;
            $('.write_chk_mobile').each(function() {
                if ($(this).prop("checked") == false){
                    flag2 = false;
                }
            });
            $('.chkallwrite_mobile').prop('checked', flag2);

            var flag1 = true;
            $('.read_chk_mobile').each(function() {
                if ($(this).prop("checked") == false){
                    flag1 = false;
                }
            });
            $('.chkallread_mobile').prop('checked', flag1);
        });
    });
</script>
@endsection