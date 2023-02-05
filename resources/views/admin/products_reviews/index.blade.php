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
			<div class="card-header">
				<div class="left"><!-- <i class="fa fa-star"></i> --><span>Reviews</span></div>
				<div class="float-sm-right">        
					<a style="padding-bottom: 3px; padding-top: 4px;" href="{{ route('product_reviews.create') }}" class="btn btn-outline-primary btn-sm waves-effect waves-light m-1" title="Add Review">
						<!-- <i class="fa fa-star" style="font-size:15px;"></i> --> <span class="name">Add Review</span>
					</a>
				</div>
			</div>
			<div class="card-body">
				<div class="table-responsive">
					<table id="example" class="table table-bordered">
						<thead>
							<tr>
								<th>#</th>
								<th>Product</th>
								<th>Customer</th>
								<th>Comment</th>
								<th>Rating</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
							@foreach($product_reviews as $key=> $product_review)
								<tr>
									<td>{{$key+1}}</td>
									<td>{{$product_review->product}}</td>
									<td>{{$product_review->first_name}}</td>
									<td>{{$product_review->comment}}</td>
									<td>{{$product_review->rating}}</td>
									<td class="action">
									<form id="deletefrm_{{$product_review->id}}" action="{{ route('product_reviews.destroy', $product_review->id) }}" method="POST" class="delete"  onsubmit="return confirm('Are you sure?');">
									@csrf
									@method('DELETE')
									<a href="{{ route('product_reviews.edit', $product_review->id) }}" class="edit" data-toggle="tooltip" data-placement="bottom" title="Edit Review">
									<i class="icon-note icons"></i>
									</a>
									<a href="javascript:void(0);" onclick="deleteRow('{{$product_review->id}}')" data-toggle="tooltip" data-placement="bottom" title="Delete Review"><i class="icon-trash icons"></i></a>
									</form>
									</td>
								</tr>
							@endforeach
						</tbody>
						<tfoot>
							<tr>
								<th>#</th>
								<th>Product</th>
								<th>Customer</th>
								<th>Comment</th>
								<th>Rating</th>
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
				title: 'Review List',
				exportOptions: {
				columns: [ 0, 1,2,3,4]
				}
			},
			{
				extend: 'excelHtml5',
				title: 'Review List',
				exportOptions: {
				columns: [ 0, 1, 2,3,4]
				}
			},
			{
				extend: 'pdfHtml5',
				title: 'Review List',
				exportOptions: {
				columns: [ 0, 1, 2,3,4]
				}
			},
			{
				extend: 'print',
				title: 'Review List',
				autoPrint: true,
				exportOptions: {
				columns: [ 0, 1, 2,3,4]
				}
			},
			'colvis'
		],
		//columnDefs: [
			//{ "orderable": false, "targets": 6 }
		//]
		columnDefs: [
            { width: "5%", targets: 0 },
            { width: "20%", targets: 1 },
            { width: "20%", targets: 2 },
            { width: "20%", targets: 3 },
            { width: "20%", targets: 4 },
            { width: "15%", "orderable": false,targets: 5 },
        ],
        fixedColumns: true
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

