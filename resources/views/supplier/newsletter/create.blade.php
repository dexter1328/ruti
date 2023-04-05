@extends('supplier.layout.main')
@section('content')

<div class="row">
	<div class="col-lg-12">
		<div class="card">
			<div class="card-header">
				<div class="left"><span>Add Newsletter</span></div>
			</div>
			<div class="card-body">
            	<div class="container-fluid">
					<form id="signupForm" method="post" action="{{ route('supplier.newsletters.store') }}" enctype="multipart/form-data">
					@csrf
					<div class="form-group row">
						<label for="input-10" class="col-sm-2 col-form-label">Subject<span class="text-danger">*</span></label>
						<div class="col-sm-10">
							<input type="text" class="form-control" id="input-10" name="subject" placeholder="Enter Subject" value="{{old('subject')}}">
							@if ($errors->has('subject'))
								<span class="text-danger">{{ $errors->first('subject') }}</span>
							@endif
						</div>
					</div>
					<div class="form-group row">
						<label for="input-11" class="col-sm-2 col-form-label">Description<span class="text-danger">*</span></label>
						<div class="col-sm-10">
							<textarea id="summernoteEditor" name="description">
								{{old('description')}}
							</textarea>
							@if ($errors->has('description'))
								<span class="text-danger">{{ $errors->first('description') }}</span>
							@endif
						</div>
					</div>
					<div class="form-group row">
						<label for="input-13" class="col-sm-2 col-form-label">Status<span class="text-danger">*</span></label>
						<div class="col-sm-10">
							<select name="status" class="form-control">
								<option value="">Select Status</option>
								<option value="active" @if(old('status')=='active') selected="selected" @endif>Active</option>
								<option value="deactive" @if(old('status')=='deactive') selected="selected" @endif>Deactive</option>
							</select>
							@if ($errors->has('status'))
								<span class="text-danger">{{ $errors->first('status') }}</span>
							@endif
						</div>
					</div>
					<center>
						<div class="form-footer">
							<button type="submit" class="btn btn-success"><i class="fa fa-check-square-o"></i> SAVE</button>
							<a href="{{url('supplier/newsletters')}}"><button type="button" class="btn btn-danger"><i class="fa fa-times"></i> CANCEL</button></a>
						</div>
					</center>
				</form>
                </div>
			</div>
		</div>
	</div>
</div>
<!-- <script type="text/javascript">
	$(document).ready(function() {
    	$('.multiple-select').select2();
   });
</script> -->
@endsection
