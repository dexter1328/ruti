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
<div class="success-alert" style="display:none;"></div>
<div class="row">
	<div class="col-lg-12">
		<div class="card">
			<div class="card-header">
				<div class="left"><!-- <i class="fa fa-group"></i> --><span>Membership Coupons</span></div>
				<div class="float-sm-right">        
					<a style="padding-bottom: 3px; padding-top: 4px;" href="{{ route('membership-coupons.create') }}" class="btn btn-outline-primary btn-sm waves-effect waves-light m-1" title="Add Membership Coupon">
						<!-- <i class="fa fa-group" style="font-size: 15px;"></i> --> <span class="name">Add Membership Coupon</span>
					</a>
				</div>
			</div>
			<div class="card-body">
				<div class="table-responsive">
					<table id="example" class="table table-bordered">
						<thead>
							<tr>
								<th>#</th>
								<th>Vendor</th>
								<th>Store</th>
								<th>Coupon</th>
								<th>Term</th>
								<th>Is Used</th>
								<th class="text-center">Action</th>
							</tr>
						</thead>
						<tbody>
							@foreach($membership_coupons as  $key=> $coupon)
								<tr>
									<td>{{$key+1}}</td>
									<td>{{$coupon->vendor_name}}</td>
									<td>{{$coupon->store_name}}</td>
									<td>{{$coupon->name}}</td>
									<td>
										{{$coupon->discount.'% off'}}
										@php /* @endphp
										@if($coupon->type == 'percentage_discount')
											{{$coupon->amount.'% off '}}
										@else
											${{$coupon->amount.' off '}}
										@endif
										@if($coupon->duration == 'repeating')
											for
										@endif
										{{$coupon->duration}}
										@php */ @endphp
									</td>
									<td>{{ucfirst($coupon->is_used)}}</td>
									<td class="action">
										<form id="deletefrm_{{$coupon->id}}" action="{{ route('membership-coupons.destroy', $coupon->id) }}" method="POST" class="delete"  onsubmit="return confirm('Are you sure?');">
											@csrf
											@method('DELETE')
											<a href="javascript:void(0);" onclick="deleteRow('{{$coupon->id}}')" data-toggle="tooltip" data-placement="bottom" title="Delete Membership Coupon"><i class="icon-trash icons"></i></a>
										</form>
									</td>
								</tr>
							@endforeach
						</tbody>
						<tfoot>
							<tr>
								<th>#</th>
								<th>Vendor</th>
								<th>Store</th>
								<th>Coupon</th>
								<th>Term</th>
								<th>Is Used</th>
								<th class="text-center">Action</th>
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
	var table = $('#example').DataTable( {
		lengthChange: false,
		buttons: [
			{
				extend: 'copy',
				title: 'Membership List',
				exportOptions: {
				columns: [ 0, 1, 2, 3, 4, 5]
				}
			},
			{
				extend: 'excelHtml5',
				title: 'Membership List',
				exportOptions: {
				columns: [ 0, 1, 2, 3, 4, 5]
				}
			},
			{
				extend: 'pdfHtml5',
				title: 'Membership List',
				exportOptions: {
				columns: [ 0, 1, 2, 3, 4, 5]
				}
			},
			{
				extend: 'print',
				title: 'Membership List',
				autoPrint: true,
				exportOptions: {
				columns: [ 0, 1, 2, 3, 4, 5]
				}
			},
			'colvis'
		],
		columnDefs: [
			{ "orderable": false, "targets": 6}
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

