@extends('admin.layout.main')
@section('content')
<div class="row">
	<div class="col-lg-12">
		<div class="card">
			<div class="card-header">
				<div class="left"><!-- <i class="fa fa-lightbulb-o"></i> --><span>Edit Suggested Place</span></div>
			</div>
			<div class="card-body">
            	<div class="container-fluid">
					<form id="signupForm" method="post" action="{{ route('suggested-place.update',$suggested_place->id) }}" enctype="multipart/form-data">
					@csrf
					@method('PATCH')
					<div class="form-group row">
						<label for="input-10" class="col-sm-2 col-form-label">User</label>
						<div class="col-sm-4">
							<label>{{$suggested_place->first_name}} {{$suggested_place->last_name}}</label>
						</div>
					</div>
					<div class="form-group row">
						<label for="input-10" class="col-sm-2 col-form-label">Store<span class="text-danger">*</span></label>
						<div class="col-sm-10">
							<input type="text" class="form-control" id="input-10" name="store"
							value="{{old('store',$suggested_place->store)}}">
							@if ($errors->has('store'))
								<span class="text-danger">{{ $errors->first('store') }}</span>
							@endif
						</div>
					</div>
					<div class="form-group row">
						<label for="input-11" class="col-sm-2 col-form-label">Address<span class="text-danger">*</span></label>
						<div class="col-sm-10">
							<textarea class="form-control" name="address" placeholder="Enter Email"> {{old('address',$suggested_place->address)}}</textarea>
							@if ($errors->has('address'))
								<span class="text-danger">{{ $errors->first('address') }}</span>
							@endif
						</div>
					</div>
					<div class="form-group row">
						<label for="input-10" class="col-sm-2 col-form-label">Email</label>
						<div class="col-sm-10">
							<input type="email" class="form-control" id="input-10" name="email"
							value="{{old('email',$suggested_place->email)}}">
							@if ($errors->has('email'))
								<span class="text-danger">{{ $errors->first('email') }}</span>
							@endif
						</div>
					</div>
					<div class="form-group row">
						<label for="input-10" class="col-sm-2 col-form-label">Mobile No</label>
						<div class="col-sm-10">
							<input type="text" class="form-control" id="input-10" name="mobile_no"
							value="{{old('mobile_no',$suggested_place->mobile_no)}}">
							@if ($errors->has('mobile_no'))
								<span class="text-danger">{{ $errors->first('mobile_no') }}</span>
							@endif
						</div>
					</div>
					<center>
						<div class="form-footer">
							<button type="submit" class="btn btn-success"><i class="fa fa-check-square-o"></i> SAVE</button>
							<a href="{{url('admin/suggested-place')}}"><button type="button" class="btn btn-danger"><i class="fa fa-times"></i> CANCEL</button></a>
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