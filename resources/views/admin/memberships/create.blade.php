@extends('admin.layout.main')
@section('content')
<div class="row">
	<div class="col-lg-12">
		<div class="card">
			<div class="card-header">
				<div class="left">
					<!-- <i class="fa fa-group"></i> --><span>Add {{ucfirst($type)}} Memership</span>
				</div>
			</div>
			<div class="card-body">
            	<div class="container-fluid">
					<form id="signupForm" method="post" action="{{ route('membership.store') }}" enctype="multipart/form-data">
						@csrf
						<input type="hidden" name="type" value="{{$type}}">
						<div class="form-group row">
							<label for="input-13" class="col-sm-2 col-form-label">Membership Type<span class="text-danger">*</span></label>
							<div class="col-sm-10">
								<select name="membership_type" id="membership_type" class="form-control">
									<option value="">Select Membership Type</option>
									@foreach($membership_types as $key => $membership_type)
										<option value="{{$key}}" @if(old('membership_type')==$key) selected="selected" @endif>{{$membership_type}}</option>
									@endforeach
								</select>
								@if ($errors->has('membership_type'))
									<span class="text-danger">{{ $errors->first('membership_type') }}</span>
								@endif
							</div>
						</div>
						<div class="form-group row">
							<label for="input-11" class="col-sm-2 col-form-label">Name<span class="text-danger">*</span></label>
							<div class="col-sm-10">
								<input type="text" class="form-control" id="name" name="name" placeholder="Enter Name" value="{{old('name')}}">
								@if ($errors->has('name'))
									<span class="text-danger">{{ $errors->first('name') }}</span>
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
						<div class="form-group row">
							<label for="input-10" class="col-sm-2 col-form-label">Price<span class="text-danger">*</span></label>
							<div class="col-sm-10">
								<input type="text" class="form-control" name="price" placeholder="Enter Price" value="{{old('price')}}">
								@if ($errors->has('price'))
									<span class="text-danger">{{ $errors->first('price') }}</span>
								@endif
							</div>
						</div>
						<center>
							<div class="form-footer">
								<button type="submit" class="btn btn-success"><i class="fa fa-check-square-o"></i> SAVE</button>
								<a href="{{url('admin/membership/'.$type)}}"><button type="button" class="btn btn-danger"><i class="fa fa-times"></i> CANCEL</button></a>
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
		$('#membership_type').change(function(){
			$('#name').val($(this).find("option:selected").text());
		});
	});
</script>
@endsection 