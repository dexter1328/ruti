@extends('supplier.layout.main')

@section('content')
@if(session()->get('success'))
<div class="alert alert-success alert-dismissible" role="alert">
	<button type="button" class="close" data-dismiss="alert">×</button>
		<div class="alert-icon">
			<i class="fa fa-check"></i>
		</div>
		<div class="alert-message">
			<span><strong>Success!</strong> {{ session()->get('success') }}</span>
		</div>
</div>
@endif
@if(session()->get('error'))
<div class="alert alert-danger alert-dismissible" role="alert">
	<button type="button" class="close" data-dismiss="alert">×</button>
		<div class="alert-icon">
			<i class="fa fa-check"></i>
		</div>
		<div class="alert-message">
			<span><strong>Failed!</strong> {{ session()->get('success') }}</span>
		</div>
</div>
@endif



<div class="row">
	<div class="col-lg-12">
		<div class="card">
			<div class="card-header"><div class="left"><span>Orders</span></div>
		</div>
		<div class="card-body">
			<div class="table-responsive">
				<table id="example" class="table table-bordered">
					<thead style="background: black">
						<tr>
                            <th>#</th>
                            <th style="width: 15%">Order No</th>
                            <th style="width: 25%">Buyer Name</th>
                            <th>Is Paid</th>
                            <th>Actions</th>
						</tr>
					</thead>
					<tbody>
                        @foreach ($op as $item)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td>{{$item->order_id}}</td>
                            <td>{{$item->vendor_name}}</td>
                            <td>Yes</td>
                            <td><a href="{{route('supplier.marketplace_orders.view_details', $item->order_id)}}" class="btn btn-info">Details</a></td>
                        </tr>
                        @endforeach

					</tbody>

				</table>
			</div>
		</div>
	</div>
</div>


@endsection
