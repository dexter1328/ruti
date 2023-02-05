@extends('admin.layout.main')
@section('content')

<div class="row">
	<div class="col-lg-12">
		<div class="card">
			<div class="card-header">
				<div class="left"><!-- <i class="fa fa-address-book-o"></i> --><span>Add Admin</span></div>
			</div>
			<div class="card-body">
            	<div class="container-fluid">
					<form id="signupForm" method="post" action="{{ route('admins.store') }}" enctype="multipart/form-data">
					@csrf
					<div class="form-group row">
						<label for="input-10" class="col-sm-2 col-form-label">Name<span class="text-danger">*</span></label>
						<div class="col-sm-4">
							<input type="text" class="form-control" id="input-10" name="name" placeholder="Enter Name" value="{{old('name')}}">
							@if ($errors->has('name'))
								<span class="text-danger">{{ $errors->first('name') }}</span>
							@endif
						</div>
						<label for="input-10" class="col-sm-2 col-form-label">Email<span class="text-danger">*</span></label>
						<div class="col-sm-4">
							<input type="email" class="form-control" id="input-11" name="email" placeholder="Enter Email" value="{{old('email')}}">
							@if ($errors->has('email'))
								<span class="text-danger">{{ $errors->first('email') }}</span>
							@endif
						</div>
					</div>
					<div class="form-group row">
						<label for="input-13" class="col-sm-2 col-form-label">Password<span class="text-danger">*</span></label>
						<div class="col-sm-4">
							<input type="password" class="form-control" id="input-13" name="password" placeholder="Enter password" value="{{old('password')}}">
							@if ($errors->has('password'))
								<span class="text-danger">{{ $errors->first('password') }}</span>
							@endif
						</div>
						<label for="input-12" class="col-sm-2 col-form-label">Image</label>
						<div class="col-sm-4">
							<input type="file" class="form-control" id="input-8" name="image" value="{{old('image')}}">
							@if ($errors->has('image'))
								<span class="text-danger">{{ $errors->first('image') }}</span>
							@endif
						</div>
					</div>
					<div class="form-group row">
						<label for="role_id" class="col-sm-2 col-form-label">Role<span class="text-danger">*</span></label>
						<div class="col-sm-4">
							@php $roles = DB::table('admin_roles')->get(); @endphp
							<select class="form-control" id="role_id" name="role_id">
								<option value="">Select Role</option>
								@foreach($roles as $role)
									@php $selected = ($role->id == old('role_id') ? 'selected="selected"' : ''); @endphp
									<option value="{{$role->id}}" {{$selected}}>{{$role->role_name}}</option>
								@endforeach
							</select>
							@if ($errors->has('role_id'))
								<span class="text-danger">{{ $errors->first('role_id') }}</span>
							@endif
						</div>
						<label for="input-13" class="col-sm-2 col-form-label">Status<span class="text-danger">*</span></label>
						<div class="col-sm-4">
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
							<a href="{{url('admin/admins')}}"><button type="button" class="btn btn-danger"><i class="fa fa-times"></i> CANCEL</button></a>
						</div>
					</center>
				</form>
                </div>
			</div>
		</div>
	</div>
</div>
<!--End Row--> 

<script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script> 

@endsection 