@extends('supplier.layout.main')
@section('content')
<div class="row">
	<div class="col-lg-12">
		<div class="card">
			<div class="card-header">
				<div class="left">
					<span>Edit Push Notification</span>
				</div>
			</div>
			<div class="card-body">
				<div class="container-fluid">
					<form id="signupForm" method="post"
					action="{{ route('supplier.push_notifications.update',$push_notification->id) }}" enctype="multipart/form-data">
						@csrf
						@method('PATCH')
						<div class="form-group row">
							<label for="input-10" class="col-sm-2 col-form-label">Title<span class="text-danger">*</span></label>
							<div class="col-sm-10">
								<input type="text" class="form-control" id="input-10" name="title" placeholder="Enter Subject" value="{{old('title',$push_notification->title)}}">
								@if ($errors->has('title'))
									<span class="text-danger">{{ $errors->first('title') }}</span>
								@endif
							</div>
						</div>
						<div class="form-group row">
							<label for="input-11" class="col-sm-2 col-form-label">Description<span class="text-danger">*</span></label>
							<div class="col-sm-10">
								<textarea class="form-control" name="description">{{old('description',$push_notification->description)}}</textarea>
								@if ($errors->has('description'))
									<span class="text-danger">{{ $errors->first('description') }}</span>
								@endif
							</div>
						</div>
						<center>
							<div class="form-footer">
								<button type="submit" class="btn btn-success"><i class="fa fa-check-square-o"></i> SAVE</button>
								<a href="{{url('supplier/push_notifications')}}"><button type="button" class="btn btn-danger"><i class="fa fa-times"></i> CANCEL</button></a>
							</div>
						</center>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
<script>
function goBack() {
	window.history.back();
}
</script>
@endsection
