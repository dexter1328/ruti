@extends('admin.layout.main')
@section('content')
<div class="row">
	<div class="col-lg-12">
		<div class="card">
			<div class="card-header">
				<div class="left"><!-- <i class="fa fa-group"></i> --><span>Edit {{ucfirst($membership->type)}} Memership</span>
				</div>
			</div>
			<div class="card-body">
            	<div class="container-fluid">
					<form id="signupForm" method="post" action="{{ route('membership.update',$membership->id) }}" enctype="multipart/form-data">
						@csrf
						@method('PATCH')
						<input type="hidden" name="type" value="{{$membership->type}}">
						<div class="form-group row">
							<label for="input-11" class="col-sm-2 col-form-label">Name<span class="text-danger">*</span></label>
							<div class="col-sm-10">
								<input type="text" class="form-control" name="name" id="name" placeholder="Enter Name" value="{{old('name', $membership->name)}}" readonly="readonly">
								@if ($errors->has('name'))name
									<span class="text-danger">{{ $errors->first('name') }}</span>
								@endif
							</div>
						</div>
						@if($membership->code != 'one_time_setup_fee')
							@include('admin.memberships.membership-feature')
						@endif
						@php /* @endphp
						@if($membership->type == 'vendor' && ($membership->code == 'sprout' || $membership->code == 'blossom'))
							@include('admin.memberships.vendor-membership-feature')
						@elseif($membership->type == 'customer')
							@include('admin.memberships.customer-membership-feature')
						@endif
						@php /* @endphp
						<div class="form-group row">
							<label for="input-11" class="col-sm-2 col-form-label">Description</label>
							<div class="col-sm-10">
								<textarea class="form-control" name="description" placeholder="Enter Description">{{old('description', $membership->description)}}</textarea>
								@if ($errors->has('description'))
									<span class="text-danger">{{ $errors->first('description') }}</span>
								@endif
							</div>
						</div>
						@php */ @endphp
						<div class="form-group row">
							<label for="input-10" class="col-sm-2 col-form-label">Price<span class="text-danger">*</span></label>
							<div class="col-sm-10">
								<input type="text" class="form-control" placeholder="Enter Price" value="{{$membership->price?:0}}" readonly>
							</div>
						</div>
						<center>
							<div class="form-footer">
								<button type="submit" class="btn btn-success"><i class="fa fa-check-square-o"></i> SAVE</button>
								<a href="{{url('admin/membership/list/'.$membership->type)}}"><button type="button" class="btn btn-danger"><i class="fa fa-times"></i> CANCEL</button></a>
							</div>
						</center>
					</form>
                </div>
			</div>
		</div>
	</div>
</div>
@endsection 