@extends('vendor.layout.main')

@section('content')

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <div class="left"><span>Allow {{$vendor_name->name}} to access store hours after work hours</span></div>
            </div>
            <div class="card-body">
                <form id="signupForm" method="post" action="{{ url('/vendor/vendors/set-store-permission') }}/{{$id}}" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group row">
                        <label for="input-12" class="col-sm-2 col-form-label">Store</label>
                        <div class="col-sm-4">
                            <label for="input-12" class="col-sm-10 col-form-label">{{$store->name}}</label>
                            <input type="hidden" name="store_id" id="store_id" value="{{$store->id}}">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="input-12" class="col-sm-2 col-form-label">TO<span class="text-danger">*</span></label>
                        <div class="col-sm-4">
                            <input type="text" id="datepicker" class="form-control datepicker" name="to_date" value="@if(!empty($store_permission->to)){{old('to_date',$store_permission->to)}}@else {{old('to_date')}}@endif" placeholder="Enter TO Date">
                            @if ($errors->has('to_date'))
                            <span class="text-danger">{{ $errors->first('to_date') }}</span>
                            @endif
                        </div>
                        <label for="input-12" class="col-sm-2 col-form-label">From<span class="text-danger">*</span></label>
                        <div class="col-sm-4">
                            <input type="text" id="datepicker" class="form-control datepicker" name="from_date" value="@if(!empty($store_permission->from)){{old('from_date',$store_permission->from)}}@else {{old('from_date')}}@endif" placeholder="Enter From Date">
                            @if ($errors->has('from_date'))
                            <span class="text-danger">{{ $errors->first('from_date') }}</span>
                            @endif
                        </div>
                    </div>
                   
                    <center>
                        <div class="form-footer">
                            @if(empty($store_permission->from))
                                <button type="submit" class="btn btn-success"><i class="fa fa-check-square-o"></i> SAVE</button>
                                <a href="{{url('vendor/vendors')}}"><button type="button" class="btn btn-danger"><i class="fa fa-times"></i> CANCEL</button></a>
                            @else
                                <button type="submit" class="btn btn-success"><i class="fa fa-check-square-o"></i> Update</button>
                                <button type="submit" class="btn btn-danger" name="btn" value="btnDelete"><i class="fa fa-times"></i> Delete</button>
                               <!--  <a href="{{url('vendor/vendors')}}"><button type="button" class="btn btn-danger"><i class="fa fa-times"></i> Delete</button></a> -->
                            @endif
                        </div>
                    </center>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
$(function() {

   var date = new Date();
    $('.datepicker').datepicker({ 
        autoclose: true, 
        startDate: date,
        todayHighlight: true
    });

});


</script>
@endsection 