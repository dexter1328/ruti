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
					<thead>
						<tr>
                            <th>#</th>
                            <th style="width: 15%">Order No</th>
                            <th style="width: 25%">Customer Name</th>
                            <th>Total Price</th>
                            <th>Is Paid</th>
                            <th>Status</th>
                            <th>Products</th>
                            <th>Actions</th>
						</tr>
					</thead>
					<tbody>
                        @foreach ($op as $item)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td>{{$item->order_id}}</td>
                            <td>{{$item->user_name}}</td>
                            <td>{{$item->price}}</td>
                            <td>{{$item->is_paid}}</td>
                            <td>{{$item->status}}</td>
                            <td>{{$item->title}}</td>
                            <td><a href="{{route('supplier.supplier_shippo',['user_id'=>$item->user_id,'product_sku'=>$item->sku,'supplier_id'=>$item->supplier_id])}}" class="btn btn-info">Ship</a></td>
                        </tr>
                        @endforeach

					</tbody>
					<tfoot>
						<tr>
                            <th>#</th>
                            <th style="width: 15%">Order No</th>
                            <th style="width: 25%">Customer Name</th>
                            <th>Total Price</th>
                            <th>Is Paid</th>
                            <th>Status</th>
                            <th>Products</th>
                            <th>Actions</th>
						</tr>
					</tfoot>
				</table>
			</div>
		</div>
	</div>
</div>

{{-- <script>
$(document).ready(function() {
	const table = $('#example').DataTable( {
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
        "processing": true,
        "serverSide": true,
        "ajax":{
            "url": "{{ url()->current() }}",
            "dataType": "json",
            "data":{ _token: "{{csrf_token()}}"}
        },
        "columns": [
            { "data": "DT_RowIndex", "orderable": false, "searchable": false },
            { "data": "w2b_order.order_id", "name": "w2bOrder.order_id" },
            { "data": "user.first_name" },
            { "data": "w2b_order.total_price", "name": "w2bOrder.total_price" },
            { "data": "w2b_order.order_notes", "name": "w2bOrder.order_notes" },
            { "data": "w2b_order.is_paid", "name": "w2bOrder.is_paid" },
            { "data": "w2b_order.status", "name": "w2bOrder.status" },
            { "data": "show", "orderable": false, "searchable": false },
            { "data": "action", "orderable": false, "searchable": false },
        ],
        "dom" : 'Bfrtip',
		columnDefs: [
			{ "orderable": false }
		]
	});
	table.buttons().container().appendTo( '#example_wrapper .col-md-6:eq(0)' );
} );
function updateStatus1(id,$this) {
    $.ajax({
        method: "POST",
        url: "{{ url()->current() }}/"+id,
        data: {
            _token: "{{ csrf_token() }}",
            _method: "PUT",
            status: $this.val()
        }
    }).done(function(res) {
        console.log(res)
        location.reload();
    });
}
</script> --}}
@endsection

