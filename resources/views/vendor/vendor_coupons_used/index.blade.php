@extends('vendor.layout.main')

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
			<div class="card-header">
				<div class="left">
					<span>Used Coupons</span>
				</div>
			</div>
			<div class="card-body">
				<div class="table-responsive">
					<table id="example1" class="table table-bordered">
						<thead>
							<tr>
								<th>Order Number</th>
								<th>Customer</th>
								<th>Coupon Code</th>
								<th>Discount</th>
								<th>Discount Type</th>
								<!-- <th>Actions</th> -->
							</tr>
						</thead>
						<tbody>
							@foreach($vendor_coupans as $key => $vendor_coupan)
								<tr>
									<td>{{$vendor_coupan->order_no}}</td>
									<td>{{$vendor_coupan->first_name}}</td>
									<td>{{$vendor_coupan->copon_code}}</td>
									<td>{{$vendor_coupan->discount}}</td>
									<td>{{$vendor_coupan->type}}</td>
									@php /* @endphp
									<td class="action">
										<form id="deletefrm_{{$vendor_coupan->id}}" action="{{ route('vendor.vendor_coupons_used.destroy', $vendor_coupan->id) }}" method="POST" class="delete"  onsubmit="return confirm('Are you sure?');">
										@csrf
										@method('DELETE')
										<a href="{{ route('vendor.vendor_coupons_used.edit', $vendor_coupan->id) }}" class="edit">
										<i class="icon-note icons"></i>
										</a>
										<a href="javascript:void(0);" onclick="deleteRow('{{$vendor_coupan->id}}')"><i class="icon-trash icons"></i></a>
										</form>
									</td>
									@php */ @endphp
								</tr>
							@endforeach
						</tbody>
						<tfoot>
							<tr>
								<th>Order Number</th>
								<th>Customer</th>
								<th>Coupon Code</th>
								<th>Discount</th>
								<th>Discount Type</th>
								<!-- <th>Actions</th> -->
							</tr>
						</tfoot>
					</table>
				</div>
			</div>
		</div>
	</div>
</div><!-- End Row-->
<script>
$(document).ready(function() {

var table = $('#example1').DataTable( {
	lengthChange: false,
	buttons: [
	{
		extend: 'copy',
		title: 'Coupon List',
		exportOptions: {
		columns: [ 0, 1, 2, 3]
	}
	},
	{
		extend: 'excelHtml5',
		title: 'Coupon List',
		exportOptions: {
		columns: [ 0, 1, 2, 3]
	}
	},
	{
		extend: 'pdfHtml5',
		title: 'Coupon List',
		exportOptions: {
		columns: [ 0, 1, 2, 3]
	}
	},
	{
		extend: 'print',
		title: 'Coupon List',
		autoPrint: true,
		exportOptions: {
		columns: [ 0, 1, 2, 3]
	}
	},
		'colvis'
	],
		columnDefs: [
		{ "orderable": false, "targets": 4 }
		]
	});

	table.buttons().container()
	.appendTo( '#example1_wrapper .col-md-6:eq(0)' );

} );
function deleteRow(id)
{   
$('#deletefrm_'+id).submit();
}
</script>
@endsection

