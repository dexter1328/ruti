@extends('admin.layout.main')

@section('content')
<div class="row">
	<div class="col-lg-12">
		<div class="card">
			<div class="card-header">
				<div class="left"><!-- <i class="fa fa-users"></i> --><span>Add Module</span></div>
			</div>
			<div class="card-body">
            	<div class="container-fluid">
					<form id="signupForm" method="post" action="{{ url('admin/vendor/paid_modules/create') }}/{{$id}}" enctype="multipart/form-data">
					@csrf
					<div class="form-group row">
						<label for="input-12" class="col-sm-2 col-form-label">Module<span class="text-danger">*</span></label>
						<div class="col-sm-4">
							<select class="form-control" name="module_name">
								<option value="">Select Module</option>
								@foreach(vendor_paid_modules() as $key => $vendor_paid_module)
									<option value="{{$vendor_paid_module}}"{{ (old("module_name") == $vendor_paid_module ? "selected":"") }}>@php echo str_replace("_"," ",$vendor_paid_module);@endphp</option>
								@endforeach
							</select>
							
							@if ($errors->has('module_name'))
							<span class="text-danger">{{ $errors->first('module_name') }}</span>
							@endif
						</div>
						<label for="input-12" class="col-sm-2 col-form-label">Status<span class="text-danger">*</span></label>
						<div class="col-sm-4" style="margin-top:7px;">
							<input type="radio" name="status" value="yes"{{ (old("status") == 'yes' ? "checked":"") }}> Yes
							<input type="radio" name="status" value="no"{{ (old("status") == 'no' ? "checked":"") }}> No
							@if ($errors->has('status'))
                            	<span class="text-danger">{{ $errors->first('status') }}</span>
                            @endif
						</div>
					</div>
					<div class="form-group row">
                        <label for="input-12" class="col-sm-2 col-form-label">TO<span class="text-danger">*</span></label>
                        <div class="col-sm-4">
                            <input type="text" id="datepicker" class="form-control datepicker" name="to_date" value="{{old('to_date')}}" placeholder="Enter TO Date">
                            @if ($errors->has('to_date'))
                            <span class="text-danger">{{ $errors->first('to_date') }}</span>
                            @endif
                        </div>
                        <label for="input-12" class="col-sm-2 col-form-label">From<span class="text-danger">*</span></label>
                        <div class="col-sm-4">
                            <input type="text" id="datepicker" class="form-control datepicker" name="from_date" value="{{old('from_date')}}" placeholder="Enter FROM Date">
                            @if ($errors->has('from_date'))
                            <span class="text-danger">{{ $errors->first('from_date') }}</span>
                            @endif
                        </div>
                    </div>
					<center>
						<div class="form-footer">
							<button type="submit" class="btn btn-success"><i class="fa fa-check-square-o"></i> SAVE</button>
							<a href="{{url('admin/vendor')}}"><button type="button" class="btn btn-danger"><i class="fa fa-times"></i> CANCEL</button></a>
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