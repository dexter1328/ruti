@extends('admin.layout.main')
@section('content')
<div class="row">
	<div class="col-lg-12">
		<div class="card">
			<div class="card-header">
				<div class="left"><!-- <i class="fa fa-address-book-o"></i> --><span>Edit Admin</span></div>
			</div>
			<div class="card-body">
            	<div class="container-fluid">
					<form id="signupForm" method="post" action="{{ route('admins.update',$admin->id) }}" enctype="multipart/form-data">
					@csrf
					@method('PATCH')
					<div class="form-group row">
						<label for="input-10" class="col-sm-2 col-form-label">Name<span class="text-danger">*</span></label>
						<div class="col-sm-4">
							<input type="text" class="form-control" id="input-10" name="name" placeholder="Enter Name" 
							value="{{old('name',$admin->name)}}">
							@if ($errors->has('name'))
								<span class="text-danger">{{ $errors->first('name') }}</span>
							@endif
						</div>
						<label for="input-11" class="col-sm-2 col-form-label">Email<span class="text-danger">*</span></label>
						<div class="col-sm-4">
							<input type="email" class="form-control" id="input-11" name="email" placeholder="Enter Email" value="{{old('email',$admin->email)}}">
							@if ($errors->has('email'))
								<span class="text-danger">{{ $errors->first('email') }}</span>
							@endif
						</div>
					</div>
					<div class="form-group row">
						<label for="input-8" class="col-sm-2 col-form-label">Image</label>
						<div class="col-sm-4">
							<input type="file" class="form-control" id="input-8" name="image" value="">
							@if($admin->image)
								@php $image = asset('public/images/'.$admin->image); @endphp
								<br>
								<img class="img-responsive" id="imagePreview" src="{{$image}}" height="100" width="100">
							@endif
						</div>
						<label for="role_id" class="col-sm-2 col-form-label">Role<span class="text-danger">*</span></label>
                        <div class="col-sm-4">
                            @php $roles = DB::table('admin_roles')->get(); @endphp
                            <select class="form-control" id="role_id" name="role_id">
                                <option value="">Select Role</option>
                                @foreach($roles as $role)
                                	@php if(old('role_id')){
                                		$selected = ($role->id == old('role_id') ? 'selected="selected"' : ''); 
                                	}else{
                                		$selected = ($role->id == $admin->role_id ? 'selected="selected"' : '');
                                	} @endphp
                                	<option value="{{$role->id}}" {{$selected}}>{{$role->role_name}}</option>
                                @endforeach
                            </select>
                            @if ($errors->has('role_id'))
								<span class="text-danger">{{ $errors->first('role_id') }}</span>
							@endif
                        </div>
					</div>
					<div class="form-group row">
						<label for="input-13" class="col-sm-2 col-form-label">Status<span class="text-danger">*</span></label>
						<div class="col-sm-10">
							<select name="status" class="form-control">
								<option value="">Select Status</option>
									@php $ac_status = ''; $de_status = '';
										if(old('status')){
											if(old('status')=='active'){
												$ac_status = 'selected="selected"';
											}elseif(old('status')=='deactive'){
												$de_status = 'selected="selected"';
											}
										}else{
											if($admin->status == 'active'){
												$ac_status = 'selected="selected"';
											}elseif($admin->status == 'deactive'){
												$de_status = 'selected="selected"';
											}
										}
									@endphp
								<option value="active"{{$ac_status}}>Active</option>
								<option value="deactive"{{$de_status}}>Deactive</option>
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
@endsection 