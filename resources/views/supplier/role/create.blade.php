@extends('supplier.layout.main')

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <div class="left"><span>Add New Role</span></div>
            </div>
            <div class="card-body">
                <form id="personal-info" method="post" action="{{ route('supplier.supplier_roles.store') }}">
                    @csrf
                    <div class="form-group row">
                        <label for="role_name" class="col-sm-2 col-form-label">Role Name<span class="text-danger">*</span></label>
                        <div class="col-sm-10">
                            <!-- <input type="text" class="form-control error" id="role_name" name="role_name" value="{{old('role_name')}}"> -->
                            <select class="form-control" name="role_id">
                                <option value="">Select Role</option>
                                @foreach($vendor_roles as $vendor_role)
                                    <option value="{{$vendor_role->id}}" {{ (old("role_id") == $vendor_role->id ? "selected":"") }}>{{$vendor_role->role_name}}</option>
                                @endforeach
                            </select>
                            @if ($errors->has('role_id'))
                                <span class="text-danger">{{ $errors->first('role_id') }}</span>
                            @endif
                        </div>
                    </div>
                    <!-- <div class="form-group row">
                        <label for="status" class="col-sm-2 col-form-label">Status<span class="text-danger">*</span></label>
                        <div class="col-sm-10">
                            <select class="form-control" id="status" name="status">
                                <option value="">Select Status</option>
                                <option value="active" @if(old('status')=='active' ) selected="selected" @endif>Active</option>
                                <option value="deactive" @if(old('status')=='deactive' ) selected="selected" @endif>Deactive</option>
                            </select>
                            @if ($errors->has('status'))
                                <span class="text-danger">{{ $errors->first('status') }}</span>
                            @endif
                        </div>
                    </div> -->
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
                                @foreach(supplier_modules() as $key => $module)
                                    <tr>
                                        <td>{{$module}}</td>
                                        <td align="center">
                                            <div class="icheck-material-primary">
                                                <input type="checkbox" id="read-{{$key}}" name="permision[{{$key}}][read]" value="yes" class="read_chk" @if(isset(old('permision')[$key]['read'])) checked="checked" @endif>
                                                <label for="read-{{$key}}"></label>
                                            </div>
                                        </td>
                                        <td align="center">
                                            <div class="icheck-material-primary">
                                                <input type="checkbox" class="write_chk" id="write-{{$key}}" name="permision[{{$key}}][write]" value="yes" @if(isset(old('permision')[$key]['write'])) checked="checked" @endif>
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
                            <a href="{{url('supplier/supplier_roles')}}"><button type="button" class="btn btn-danger"><i class="fa fa-times"></i> CANCEL</button></a>
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
