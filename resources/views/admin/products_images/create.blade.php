@extends('admin.layout.main')

@section('content')
<div class="row">
	<div class="col-lg-12">
		<div class="card">
			<div class="card-header">
				<div class="left"><!-- <i class="fa fa-picture-o"></i> --><span>Product Image</span></div>
			</div>
			<div class="card-body">
				@if ($errors->any())
					<div class="alert alert-danger alert-dismissible">
						<button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
						<ul>
							@foreach ($errors->all() as $error)
							<li>{{ $error }}</li>
							@endforeach
						</ul>
					</div>
				@endif
				<form id="signupForm" method="post" action="{{route('product_images.store')}}" enctype="multipart/form-data">
					@csrf
					<input type="hidden" name="product_id" value="{{$product->id}}">
					<div class="form-group row">
						<label for="input-13" class="col-sm-2 col-form-label">Image<span class="text-danger">*</span></label>
						<div class="col-sm-4">
							<input type="file" class="form-control" id="input-13" name="image[]" multiple>
						</div>
					</div>
					<center>
						<div class="form-footer">
							<button type="submit" class="btn btn-success"><i class="fa fa-check-square-o"></i> SAVE</button>
							<button type="submit" class="btn btn-danger"><i class="fa fa-times"></i> CANCEL</button>
						</div>
					</center>
				</form>
			</div>
		</div>
	</div>
</div>
<!--End Row--> 
@endsection 