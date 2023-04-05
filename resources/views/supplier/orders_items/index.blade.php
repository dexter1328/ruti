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

<div class="row">
	<div class="col-lg-12">
		<div class="card">
			<div class="card-header"><div class="left"><i class="fa fa-shopping-bag"></i><span>Orders</span></div>
			<div class="float-sm-right">
			</div>
		</div>
		<div class="card-body">
			<div class="table-responsive">
				<table id="example" class="table table-bordered">
					<thead>
						<tr>
							<th>#</th>
							<th>Product</th>
							<th>Price</th>
							<th>Discount</th>
							<th>Barcode</th>
							<th>Quantity</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
						@foreach($order_items as $key =>$order_item)
							<tr>
								<td>{{$key+1}}</td>
								<td>{{$order->title}}</td>
								<td>{{$order->price}}</td>
								<td>{{$order->discount}}</td>
								<td>{{$order->barcode_tag}}</td>
								<td>{{$order->quantity}}</td>
								<td class="action">
									<form id="deletefrm_{{$order_item->id}}" action="{{ route('order_return.destroy', $order_item->id) }}" method="POST" class="delete"  onsubmit="return confirm('Are you sure return order');">
									@csrf
									@method('DELETE')
									<a href="javascript:void(0);" onclick="deleteRow('{{$order_item->id}}')"><i class="icon-trash icons"></i></a>
									</form>
								</td>
							</tr>
						@endforeach
					</tbody>
					<tfoot>
						<tr>
							<th>#</th>
							<th>Product</th>
							<th>Price</th>
							<th>Discount</th>
							<th>Barcode</th>
							<th>Quantity</th>
							<th>Action</th>
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
		columnDefs: [
			{ "orderable": false, "targets": 8 }
		]
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

