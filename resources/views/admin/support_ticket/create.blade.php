@extends('admin.layout.main')

@section('content')
<div class="row">
	<div class="col-lg-12">
		<div class="card">
			<div class="card-body">
				<div class="row">
					<div class="col-lg-12">
						<div class="card">
							<div class="card-body">
								<form id="signupForm" method="post" action="{{ route('support_ticket.store') }}" enctype="multipart/form-data">
									@csrf
									<h4 class="form-header text-uppercase">
										<!-- <i class="fa fa-ticket"></i> -->
										Support Tickets
									</h4>
									<div class="form-group row">
										<label for="input-10" class="col-sm-2 col-form-label">Customer<span class="text-danger">*</span></label>
										<div class="col-sm-4">
											<select class="form-control" name="customer_id">
												<option value="">select customer</option>
												@foreach($users as $user)
													@php $selected = ($user->id == old('customer_id') ? 'selected="selected"' : ''); @endphp
												<option value="{{$user->id}}"{{$selected}}>{{$user->first_name}}</option>
												@endforeach
											</select>
											@if ($errors->has('customer_id'))
												<span class="text-danger">{{ $errors->first('customer_id') }}</span>
											@endif
										</div>
										<label for="input-11" class="col-sm-2 col-form-label">Subject<span class="text-danger">*</span></label>
										<div class="col-sm-4">
											<input type="text" class="form-control" id="input-11" name="subject" placeholder="Enter Subject" value="{{old('subject')}}">
											@if ($errors->has('subject'))
												<span class="text-danger">{{ $errors->first('subject') }}</span>
											@endif
										</div>
									</div>
									<div class="form-group row">
										<label for="input-12" class="col-sm-2 col-form-label">Message<span class="text-danger">*</span></label>
										<div class="col-sm-4">
											<textarea class="form-control" name="message">{{old('message')}}</textarea>
											@if ($errors->has('message'))
												<span class="text-danger">{{ $errors->first('message') }}</span>
											@endif
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
				</div><!--End Row-->
			</div>
		</div>
	</div>
</div>

@endsection
