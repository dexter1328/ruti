@extends('admin.layout.main')
@section('content')

<div class="row">
	<div class="col-lg-12">
		<div class="card">
			<div class="card-header">
				<div class="left"><!-- <i class="fa fa-bell-o"></i> --><span>Send Notification</span></div>
			</div>
			<div class="card-body">
            	<div class="container-fluid">
                    @if(session()->get('success'))
                        <div class="alert alert-success alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">X</button>
                            <span><strong>Success!</strong> {{ session()->get('success') }}</span>
                        </div>
                    @endif
                                   
					<form id="signupForm" method="post" action="{{ route('notifications.store') }}" enctype="multipart/form-data">
					@csrf
					<div class="form-group row">
						<label for="input-10" class="col-sm-2 col-form-label">Title<span class="text-danger">*</span></label>
						<div class="col-sm-10">
							<input type="text" class="form-control" id="input-10" name="title" placeholder="Enter Title" value="{{old('title')}}">
							@if ($errors->has('title'))
								<span class="text-danger">{{ $errors->first('title') }}</span>
							@endif
						</div>
					</div>
					<div class="form-group row">
						<label for="input-11" class="col-sm-2 col-form-label">Description<span class="text-danger">*</span></label>
						<div class="col-sm-10">
							<textarea id="input-11" name="description" class="form-control" rows="5" placeholder="Enter Description">{{old('description')}}</textarea>
							@if ($errors->has('description'))
								<span class="text-danger">{{ $errors->first('description') }}</span>
							@endif
						</div>
					</div>
					<div class="form-group row">
						<label for="input-11" class="col-sm-2 col-form-label">Priority</label>
						<div class="col-sm-10">
							<select id="priority" name="priority" class="form-control">
								<option value="DEFAULT" @if(old('priority') == 'DEFAULT') selected="selected" @endif>DEFAULT</option>
								<option value="HIGH" @if(old('priority') == 'HIGH') selected="selected" @endif>HIGH</option>
							</select>
						</div>
					</div>
				
					<div class="form-group row">
						<label for="input-11" class="col-sm-2 col-form-label">Display</label>
						<div class="col-sm-10">
							<select id="display" name="display" class="form-control">
								<option value="DEFAULT" @if(old('display') == 'DEFAULT') selected="selected" @endif>DEFAULT</option>
								<option value="SCHEDULE" @if(old('display') == 'SCHEDULE') selected="selected" @endif>SCHEDULE</option>
							</select>
						</div>
					</div>
					<center>
						<div class="form-footer">
							<button type="submit" class="btn btn-success"><i class="fa fa-check-square-o"></i> SAVE</button>
							<!-- <button type="submit" class="btn btn-danger"><i class="fa fa-times"></i> CANCEL</button> -->
						</div>
					</center>
				</form>
                </div>
			</div>
		</div>
	</div>
</div>
@endsection 