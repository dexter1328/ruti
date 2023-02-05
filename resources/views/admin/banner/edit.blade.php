@extends('admin.layout.main')
@section('content')
<div class="row">
	<div class="col-lg-12">
		<div class="card">
			<div class="card-header">
				<div class="left"><!-- <i class="fa fa-picture-o"></i> --><span>Edit Banner</span></div>
			</div>
			<div class="card-body">
            	<div class="container-fluid">
					<form id="signupForm" method="post" action="{{ route('banners.update',$banner->id) }}" enctype="multipart/form-data">
					@csrf
					@method('PATCH')
					<div class="form-group row">
						<label for="input-10" class="col-sm-2 col-form-label">Title<span class="text-danger">*</span></label>
						<div class="col-sm-4">
							<input type="text" class="form-control" id="input-10" name="title" placeholder="Enter Title" 
							value="{{old('title',$banner->banner_title)}}">
							@if ($errors->has('title'))
								<span class="text-danger">{{ $errors->first('title') }}</span>
							@endif
						</div>
						<label for="input-11" class="col-sm-2 col-form-label">Position<span class="text-danger">*</span></label>
						<div class="col-sm-4">
							<select name="position" class="form-control">
								<option value="">Select Position</option>
								@php $top_selected = ''; $bottom_selected = '';
									if(old('position')){
										if(old('position')=='Top'){
											$top_selected = 'selected="selected"';
										}elseif(old('position')=='Bottom'){
											$bottom_selected = 'selected="selected"';
										}
									}else{
										if($banner->position == 'Top'){
											$top_selected = 'selected="selected"';
										}elseif($banner->position == 'Bottom'){
											$bottom_selected = 'selected="selected"';
										}
									}
								@endphp
								<option value="Top" {{$top_selected}}>Top</option>
								<option value="Bottom" {{$bottom_selected}}>Bottom</option>
							</select>
							@if ($errors->has('position'))
								<span class="text-danger">{{ $errors->first('position') }}</span>
							@endif
						</div>
					</div>
					<div class="form-group row">
						<label for="input-12" class="col-sm-2 col-form-label">Image</label>
						<div class="col-sm-4">
							<input type="file" class="form-control" id="input-8" name="image" value="{{old('image')}}" accept="image/*">
							@if($banner->image)
							<br>
							<a href="{{url('public/images/banners/'.$banner->image)}}" rel="prettyPhoto">
								<img src="{{url('public/images/banners/'.$banner->image)}}" style="width: 200px; height: auto;">
							</a>
							@endif
						</div>
						<label for="input-13" class="col-sm-2 col-form-label">Status<span class="text-danger">*</span></label>
						<div class="col-sm-4">
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
										if($banner->status == 'active'){
											$ac_status = 'selected="selected"';
										}elseif($banner->status == 'deactive'){
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
							<a href="{{url('admin/banners')}}"><button type="button" class="btn btn-danger"><i class="fa fa-times"></i> CANCEL</button></a>
						</div>
					</center>
				</form>
                </div>
			</div>
		</div>
	</div>
</div>
@endsection 