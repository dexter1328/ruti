@extends('admin.layout.main')

@section('content')
<div class="row">
	<div class="col-lg-12">
		<div class="card">
			<div class="card-header">
				<div class="left"><!-- <i class="fa fa-users"></i> --><span>Edit Module</span></div>
			</div>
			<div class="card-body">
            	<div class="container-fluid">
					<form id="signupForm" method="post" action="{{ url('admin/supplier/paid_modules/edit') }}/{{$id}}" enctype="multipart/form-data">
					@csrf
					<div class="form-group row">
						<label for="input-12" class="col-sm-2 col-form-label">Module</label>
						<div class="col-sm-4" style="margin-top:5px;">
							@php echo str_replace("_"," ",$paid_modules->module_name);@endphp
						</div>
						<label for="input-12" class="col-sm-2 col-form-label">Status</label>
						<div class="col-sm-4" style="margin-top:7px;">
							<input type="radio" name="status" value="yes" {{isset($paid_modules->status) && $paid_modules->status == 'yes'?'checked':''}}> Yes
							<input type="radio" name="status" value="no" {{isset($paid_modules->status) && $paid_modules->status == 'no'?'checked':''}}> No
						</div>
					</div>
					<div class="form-group row">
                        <label for="input-12" class="col-sm-2 col-form-label">TO<span class="text-danger">*</span></label>
                        <div class="col-sm-4">
                            <input type="text" id="datepicker" class="form-control datepicker" value="{{$paid_modules->start_date}}" name="to_date" placeholder="Enter TO Date">
                            @if ($errors->has('to_date'))
                            <span class="text-danger">{{ $errors->first('to_date') }}</span>
                            @endif
                        </div>
                        <label for="input-12" class="col-sm-2 col-form-label">From<span class="text-danger">*</span></label>
                        <div class="col-sm-4">
                            <input type="text" id="datepicker" class="form-control datepicker" value="{{$paid_modules->end_date}}" name="from_date">
                            @if ($errors->has('from_date'))
                            <span class="text-danger">{{ $errors->first('from_date') }}</span>
                            @endif
                        </div>
                    </div>
					<center>
						<div class="form-footer">
							<button type="submit" class="btn btn-success"><i class="fa fa-check-square-o"></i> SAVE</button>
							<a href="{{url('admin/supplier')}}"><button type="button" class="btn btn-danger"><i class="fa fa-times"></i> CANCEL</button></a>
						</div>
					</center>
				</form>
                </div>
			</div>
		</div>
	</div>
</div>
<!--End Row-->
<script type="text/javascript">
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
