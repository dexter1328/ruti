@extends('supplier.layout.main')

@section('content')

<div class="row">
	<div class="col-lg-12">
		<div class="card">
			<div class="card-header"><div class="left"><!-- <i class="fa fa-table"></i> --><span>Cancelled Orders</span></div>
		</div>
		<div class="card-body">
			<div class="table-responsive">
				<table id="example" class="table table-bordered">
					<thead>
						<tr>
                            <th>#</th>
                            <th style="width: 15%">Order No</th>
                            <th style="width: 25%">Customer Name</th>
                            <th>Total Price</th>
                            <th>Was Paid</th>
                            <th>Order</th>
                            <th >Action</th>
						</tr>
					</thead>
					<tbody>
						@foreach($cancelled_orders as $cancelled_order)
						<tr>
                            <td>{{$loop->iteration}}</td>
                            <td >{{$cancelled_order->w2bOrder->order_id}}</td>
                            <td >{{$cancelled_order->user->first_name . " " . $cancelled_order->user->last_name}}</td>
                            <td >{{$cancelled_order->w2bOrder->total_price}}</td>
                            <td >{{$cancelled_order->w2bOrder->is_paid}}</td>
                            <td ><a href="{{route('supplier.orders.view_order', $cancelled_order->id)}}" class="btn btn-info">Show</a></td>
                            <td></td>
                        </tr>
						@endforeach
					</tbody>
					<tfoot>
						<tr>
                            <th>#</th>
                            <th style="width: 15%">Order No</th>
                            <th style="width: 25%">Customer Name</th>
                            <th>Total Price</th>
                            <th>Was Paid</th>
                            <th>Order</th>
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
        // buttons: [ 'copy', 'excel', 'pdf', 'print', 'colvis' ],
        buttons: [
        	{
                extend: 'copy',
                title: 'Cancel Order List',
                exportOptions: {
                    columns: [ 0, 1, 2]
                }
            },
            {
                extend: 'excelHtml5',
                title: 'Cancel Order List',
                exportOptions: {
                    columns: [ 0, 1, 2]
                }
            },
            {
                extend: 'pdfHtml5',
                title: 'Cancel Order List',
                exportOptions: {
                    columns: [ 0, 1, 2]
                }
            },
            {
                extend: 'print',
                title: 'Cancel Order List',
                exportOptions: {
                    columns: [ 0, 1, 2]
                }
            },
            'colvis'
        ],
        columnDefs: [
        { "orderable": false, "targets": 3 }
      ]
    });
    table.buttons().container()
      .appendTo( '#example_wrapper .col-md-6:eq(0)' );

    });
 	function deleteRow(id)
    {
        $('#deletefrm_'+id).submit();
    }
</script>
@endsection

