@extends('vendor.layout.main')

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
						@foreach($cancelled_orders as $key => $cancelled_order)
						<tr>
                            <td>{{$key+1}}</td>
                            <td >{{$cancelled_order->owner_name}}</td>
                            <td >{{$cancelled_order->store_name}}</td>
                            <td >{{$cancelled_order->first_name}}</td>
                            <td >{{$cancelled_order->type}}</td>
                            <td >{{$cancelled_order->pickup_date}}</td>
                            <td >{{$cancelled_order->pickup_time}}</td>
                            <td >{{$cancelled_order->order_status}}</td>
                            <td class="action">
                                <a href="{{ route('vendor.cancelled_orders.show', $cancelled_order->id) }}" class="edit" data-toggle="tooltip" data-placement="bottom" title="View CancelOrder">
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

