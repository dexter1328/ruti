@extends('admin.layout.main')

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

<div class="row">
	<div class="col-lg-12">
		<div class="card">
			<div class="card-header"><div class="left"><!-- <i class="fa fa-shopping-bag"></i> --><span>Instore Orders</span></div>
		</div>
		<div class="card-body">
			<div class="table-responsive">
				<table id="example" class="table table-bordered">
					<thead>
						<tr>
							<th >#</th>
							<th >Vendor</th>
							<th >Store</th>
							<th >Customer</th>
							<th >Type</th>
							<th >Pickup date</th>
							<th >Pickup time</th>
							<th >Status</th>
							<th >Action</th>
						</tr>
					</thead>
					<tbody>
						@foreach($orders as $key =>$order)
							<tr>
								<td>{{$key+1}}</td>
								<td >{{$order->owner_name}}</td>
								<td >{{$order->store_name}}</td>
								<td >{{$order->first_name}}</td>
								<td >{{$order->type}}</td>
								<td >{{$order->pickup_date}}</td>
								<td >{{$order->pickup_time}}</td>
								<td >{{$order->order_status}}</td>
								<td class="action">
									<a href="{{ url('admin/order/inshop_order_view', $order->id) }}" class="edit" data-toggle="tooltip" data-placement="bottom" title="View InstoreOrder">
										<i class="icon-eye icons"></i>
									</a>
								</td>
							</tr>
						@endforeach
					</tbody>
					<tfoot>
						<tr>
							<th >#</th>
							<th >Vendor</th>
							<th >Store</th>
							<th >Customer</th>
							<th >Type</th>
							<th >Pickup date</th>
							<th >Pickup time</th>
							<th >Status</th>
							<th >Action</th>
						</tr>
					</tfoot>
				</table>
			</div>
		</div>
	</div>
</div>

<script>
$(document).ready(function() {
	var table = $('#example').DataTable( {
		lengthChange: false,
			buttons: [
			{
				extend: 'copy',
				title: 'Order List',
				exportOptions: {
				columns: [ 0, 1,2,3,4,5,6,7]
				}
			},
			{
				extend: 'excelHtml5',
				title: 'Order List',
				exportOptions: {
				columns: [ 0, 1, 2,3,4,5,6,7]
				}
			},
			{
				extend: 'pdfHtml5',
				title: 'Order List',
				exportOptions: {
				columns: [ 0, 1, 2,3,4,5,6,7]
				}
			},
			{
				extend: 'print',
				title: 'Order List',
				autoPrint: true,
				exportOptions: {
				columns: [ 0, 1, 2,3,4,5,6,7]
				}
			},
			'colvis'
		],
		//columnDefs: [
			//{ "orderable": false, "targets": 6 }
		//]
		columnDefs: [
            { width: "5%", targets: 0 },
            { width: "12%", targets: 1 },
            { width: "12%", targets: 2 },
            { width: "12%", targets: 3 },
            { width: "12%", targets: 4 },
            { width: "12%", targets: 5 },
            { width: "10%", targets: 6 },
            { width: "10%", targets: 7 },
            { width: "15%","orderable": false, targets: 8 },
        ],
        fixedColumns: true
	});
	table.buttons().container()
	.appendTo( '#example_wrapper .col-md-6:eq(0)' );
} );

	function deleteRow(id)
    {   
        $('#deletefrm_'+id).submit();
    }

</script>
@endsection

