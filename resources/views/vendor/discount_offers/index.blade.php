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
				<div class="left"><span>Discount Offers</span></div>
				<div class="float-sm-right">        
					<a style="padding-bottom: 3px; padding-top: 4px;" 
					href="{{ route('vendor.discount_offers.create') }}" class="btn btn-outline-primary btn-sm waves-effect waves-light m-1" title="Add Offer">
						<span class="name">Add Offers</span>
					</a>
				</div>
			</div>
			<div class="card-body">
				<div class="table-responsive">
					<table id="example" class="table table-bordered">
						<thead>
							<tr>
								<th>#</th>
								<th>Title</th>
								<th>Store</th>
								<th>Image</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
							@foreach($discount_offers as $key => $discount_offer)
								<tr>
									<td>{{$key+1}}</td>
									<td>{{$discount_offer->title}}</td>
									<td>{{$discount_offer->store_name}}</td>
								<!-- 	<td>{{$discount_offer->title}}</td> -->
									<td><img src="{{asset('public/images').'/'.$discount_offer->image}}" width="50" height="50"></td>
									<td class="action">
									<form id="deletefrm_{{$discount_offer->id}}" action="{{ route('vendor.discount_offers.destroy', $discount_offer->id) }}" method="POST" class="delete"  onsubmit="return confirm('Are you sure?');">
									@csrf
									@method('DELETE')
									<a href="{{ route('vendor.discount_offers.edit', $discount_offer->id) }}" class="edit">
									<i class="icon-note icons"></i>
									</a>
									<a href="javascript:void(0);" onclick="deleteRow('{{$discount_offer->id}}')"><i class="icon-trash icons"></i></a></form>
									</td>
								</tr>
							@endforeach
						</tbody>
						<tfoot>
							<tr>
								<th>#</th>
								<th>Title</th>
								<th>Store</th>
								<th>Image</th>
								<th>Action</th>
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
				title: 'Discount Offer List',
				exportOptions: {
				columns: [ 0, 1, 2, 3]
				}
			},
			{
				extend: 'excelHtml5',
				title: 'Discount Offer List',
				exportOptions: {
				columns: [ 0, 1, 2, 3]
				}
			},
			{
				extend: 'pdfHtml5',
				title: 'Discount Offer List',
				exportOptions: {
				columns: [ 0, 1, 2, 3]
				}
			},
			{
				extend: 'print',
				title: 'Discount Offer List',
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
	} );
	table.buttons().container()
	.appendTo( '#example_wrapper .col-md-6:eq(0)' );
} );
function deleteRow(id)
{   
    $('#deletefrm_'+id).submit();
}
</script>
@endsection

