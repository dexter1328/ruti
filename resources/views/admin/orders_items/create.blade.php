@extends('admin.layout.main')

@section('content')
<div class="row">
	<div class="col-lg-12">
		<div class="card">
			<div class="card-header">
				<div class="left"><i class="fa fa-address-book-o"></i><span>Orders Items</span></div>
			</div>
			<div class="card-body">
				<form id="signupForm" method="post" action="{{ route('order_items.store') }}" enctype="multipart/form-data">
					@csrf
					<div class="form-group row">
						<label for="input-10" class="col-sm-2 col-form-label">Order</label>
						<div class="col-sm-4">
							<select name="order_id" class="form-control" id="order_id">
								<option value="">Select Vendor</option>
								@foreach($orders as $order)
								<option value="{{$order->id}}" {{ (old("order_id") == $order->id ? "selected":"") }}>{{$order->name}}</option>
								@endforeach
							</select>
							@if ($errors->has('order_id'))
								<span class="text-danger">{{ $errors->first('order_id') }}</span>
							@endif
						</div>
						<label for="input-11" class="col-sm-2 col-form-label">Product</label>
						<div class="col-sm-4">
							<input type="text" class="form-control" id="input-11" name="content" placeholder="Enter Content">
						</div>
					</div>
					<div class="form-group row">
						<label for="input-12" class="col-sm-2 col-form-label">Measurement</label>
						<div class="col-sm-4">
							<input type="file" class="form-control" id="input-8" name="file" required>
						</div>
						<label for="input-13" class="col-sm-2 col-form-label">Quantity</label>
						<div class="col-sm-4">
							<input type="text" class="form-control" id="input-13" name="status" placeholder="Enter Status">
						</div>
					</div>
					<div class="form-group row">
						<label for="input-12" class="col-sm-2 col-form-label">Price</label>
						<div class="col-sm-4">
							<input type="file" class="form-control" id="input-8" name="file" required>
						</div>
						<label for="input-13" class="col-sm-2 col-form-label">Discount</label>
						<div class="col-sm-4">
							<input type="text" class="form-control" id="input-13" name="status" placeholder="Enter Status">
						</div>
					</div>
					<div class="form-group row">
						<label for="input-12" class="col-sm-2 col-form-label">Barcode Tag</label>
						<div class="col-sm-4">
							<input type="file" class="form-control" id="input-8" name="file" required>
						</div>
					</div>
					<center>
						<div class="form-footer">
							<button type="submit" class="btn btn-success"><i class="fa fa-check-square-o"></i> SAVE</button>
						</div>
					</center>
				</form>
			</div>
		</div>
	</div>
</div>

@endsection 