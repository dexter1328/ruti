@extends('admin.layout.main')
@section('content')

<div class="row">
	<div class="col-lg-12">
		<div class="card">
			<div class="card-header">
				<div class="left"><!-- <i class="fa fa-file"></i> --><span>Edit Page</span></div>
			</div>
			<div class="card-body">
            	<div class="container-fluid">
					<form id="signupForm" method="post" action="{{ route('pages.update',$page->id) }}" enctype="multipart/form-data">
					@csrf
					@method('PATCH')
					<div class="form-group row">
						<label for="input-10" class="col-sm-2 col-form-label">Title<span class="text-danger">*</span></label>
						<div class="col-sm-10">
							<input type="text" class="form-control" id="input-10" name="title" placeholder="Enter Title" 
							value="{{old('title',$page->title)}}">
							@if ($errors->has('title'))
								<span class="text-danger">{{ $errors->first('title') }}</span>
							@endif
						</div>
					</div>
					<div class="form-group row">
						<label for="input-11" class="col-sm-2 col-form-label">Content<span class="text-danger">*</span></label>
						<div class="col-sm-10">
							<textarea id="summernoteEditor" name="content">
								{{old('content',$page->content)}}
							</textarea>
							@if ($errors->has('content'))
								<span class="text-danger">{{ $errors->first('content') }}</span>
							@endif
						</div>
					</div>
					<div class="form-group row">
						<label for="input-11" class="col-sm-2 col-form-label">Image</label>
						<div class="col-sm-10">
							<input type="file" class="form-control" id="input-8" name="image" value="{{old('image')}}" accept="image/*">
							@if($page->image)
							<br>
							<a href="{{url('public/images/page/'.$page->image)}}" rel="prettyPhoto">
								<img src="{{url('public/images/page/'.$page->image)}}" style="width: 200px; height: auto;">
							</a>
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
										if($page->status == 'active'){
											$ac_status = 'selected="selected"';
										}elseif($page->status == 'deactive'){
											$de_status = 'selected="selected"';
										}
									}
								@endphp
								<option value="active"{{$ac_status}}>Active</option>
								<option value="deactive"{{$de_status}}}>Deactive</option>
							</select>
							@if ($errors->has('status'))
								<span class="text-danger">{{ $errors->first('status') }}</span>
							@endif
						</div>
					</div>
					<center>
						<div class="form-footer">
							<button type="submit" class="btn btn-success"><i class="fa fa-check-square-o"></i> SAVE</button>
							<a href="{{url('admin/pages')}}"><button type="button" class="btn btn-danger"><i class="fa fa-times"></i> CANCEL</button></a>
						</div>
					</center>
				</form>
                </div>
			</div>
		</div>
	</div>
</div>
@endsection 