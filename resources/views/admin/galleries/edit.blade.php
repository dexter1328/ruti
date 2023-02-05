@extends('admin.layout.main')
@section('content')
<style type="text/css">
.close{
    display:block;
    float:right;
    width:30px;
    height:29px;
    background:url('{{ asset('public/images/remove_btn.png')}}') no-repeat center center;
}
.image_div{
	width:18%;
	position: relative;
	float: left;
}
</style>
<div class="row">
	<div class="col-lg-12">
		<div class="card">
			<div class="card-header">
				<div class="left"><!-- <i class="fa fa-picture-o"></i> --><span>Edit Gallery</span></div>
			</div>
			<div class="card-body">
            	<div class="container-fluid">
					<form id="signupForm" method="post" action="{{ route('galleries.update',$gallery->id) }}" 
						enctype="multipart/form-data">
					@csrf
					@method('PATCH')
					<input type="hidden" name="gallery_id" id="gallery_id" value="{{$gallery->id}}">
					<div class="form-group row">
						<label for="input-10" class="col-sm-2 col-form-label">Title<span class="text-danger">*</span></label>
						<div class="col-sm-10">
							<input type="text" class="form-control" id="input-10" name="title" placeholder="Enter Title" value="{{old('title',$gallery->gallery_title)}}">
							@if ($errors->has('title'))
								<span class="text-danger">{{ $errors->first('title') }}</span>
							@endif
						</div>
					</div>
					<div class="form-group row">
						<label for="input-10" class="col-sm-2 col-form-label">Image</label>
						<div class="col-sm-10">
							<input type="file" class="form-control" id="input-8" name="image[]" multiple accept="image/*">
						</div>
					</div>
					<div class="form-group row">
						<div class="col-sm-2">
						</div>
						@if($gallery->file)
							<div class="col-sm-10">
								@php
									$images = explode(",",$gallery->file); 
								@endphp
								@foreach($images as $key=> $image)
									<div class="image_div">
										<a href="javascript:void(0);" onclick="RemoveImage(this,'{{$image}}')" class="close"></a>
										<a href="{{asset('public/images/galleries').'/'.$image}}" rel="prettyPhoto['image']">
											<img src="{{asset('public/images/galleries').'/'.$image}}" width="100" height="100">
										</a>
									</div>
								@endforeach
							</div>
						@endif
					</div>
					<div class="form-group row">
						<label for="input-10" class="col-sm-2 col-form-label">Status<span class="text-danger">*</span></label>
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
										if($gallery->status == 'active'){
											$ac_status = 'selected="selected"';
										}elseif($gallery->status == 'deactive'){
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
							<a href="{{url('admin/galleries')}}"><button type="button" class="btn btn-danger"><i class="fa fa-times"></i> CANCEL</button></a>
						</div>
					</center>
				</form>
                </div>
			</div>
		</div>
	</div>
</div>
<!--End Row--> 
<script>
function RemoveImage(e,id)
{
	$.ajax({
		type: "post",
		url: "{{ url('/admin/galleries/remove_image') }}/"+id,
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		},
		data: {
			"galleryID": $( "#gallery_id" ).val()
			},
		success: function (data) {
			e.closest('.image_div').remove();
		}
	});
}
</script>
@endsection 