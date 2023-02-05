@extends('admin.layout.main')
@section('content')
<div class="row">
	<div class="col-lg-12">
		<div class="card">
			<div class="card-header">
				<div class="left">
					<!-- <i class="fa fa-group"></i> --><span>Add {{ucfirst($type)}} Checklist</span>
				</div>
			</div>
			<div class="card-body">
            	<div class="container-fluid">
					<form id="signupForm" method="post" action="{{ route('checklist.store') }}" enctype="multipart/form-data">
						@csrf
						<input type="hidden" name="type" value="{{$type}}">
						<div class="form-group row">
							<label for="input-13" class="col-sm-2 col-form-label">Checklist Type<span class="text-danger">*</span></label>
							<div class="col-sm-10">
								<select name="checklist_type" id="checklist_type" class="form-control">
									<option value="">Select Checklist Type</option>
									@foreach($checklist as $key => $item)
										<option value="{{$key}}" @if(old('checklist_type')==$key) selected="selected" @endif>{{$item}}</option>
									@endforeach
								</select>
								@if ($errors->has('checklist_type'))
									<span class="text-danger">{{ $errors->first('checklist_type') }}</span>
								@endif
							</div>
						</div>
						<div class="form-group row">
							<label for="input-11" class="col-sm-2 col-form-label">Title<span class="text-danger">*</span></label>
							<div class="col-sm-10">
								<input type="text" class="form-control" name="title" id="title" placeholder="Enter Title" value="{{old('title')}}">
								@if ($errors->has('title'))
									<span class="text-danger">{{ $errors->first('title') }}</span>
								@endif
							</div>
						</div>
						<div class="form-group row">
							<label for="input-11" class="col-sm-2 col-form-label">Description</label>
							<div class="col-sm-10">
								<textarea class="form-control" name="description" placeholder="Enter Description">{{old('description')}}</textarea>
								@if ($errors->has('description'))
									<span class="text-danger">{{ $errors->first('description') }}</span>
								@endif
							</div>
						</div>
						<center>
							<div class="form-footer">
								<button type="submit" class="btn btn-success"><i class="fa fa-check-square-o"></i> SAVE</button>
								<a href="{{url('admin/checklist/'.$type)}}"><button type="button" class="btn btn-danger"><i class="fa fa-times"></i> CANCEL</button></a>
							</div>
						</center>
					</form>
                </div>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
	$(document).ready(function(){
		$('#checklist_type').change(function(){
			$('#title').val($(this).find("option:selected").text());
		});
	});
</script>
@endsection 