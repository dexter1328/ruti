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
				<div class="left"><span>Reviews</span></div>
				<div class="float-sm-right">        
					<a style="padding-bottom: 3px; padding-top: 4px;" href="{{ route('vendor.customer_reviews.create') }}" class="btn btn-outline-primary btn-sm waves-effect waves-light m-1" title="Add New Review">
						<span class="name">Add Review</span>
					</a>
				</div>
			</div>
			<div class="card-body">
				<div class="table-responsive">
					<table id="example" class="table table-bordered">
						<thead>
							<tr>
								<th>#</th>
								<th>Store</th>
								<th>Customer</th>
								<th>Review</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
							@foreach($customer_reviews as $key=> $customer_review)
								<tr>
									<td>{{$key+1}}</td>
									<td>{{$customer_review->store_name}}</td>
									<td>{{$customer_review->first_name}}</td>
									<td>{{$customer_review->review}}</td>
									<td class="action">
										<form id="deletefrm_{{$customer_review->id}}" action="{{ route('vendor.customer_reviews.destroy', $customer_review->id) }}" method="POST" class="delete"  onsubmit="return confirm('Are you sure?');">
											@csrf
											@method('DELETE')
											<a href="{{ route('vendor.customer_reviews.edit', $customer_review->id) }}" class="edit">
												<i class="icon-note icons"></i>
											</a>
											<a href="javascript:void(0);" onclick="deleteRow('{{$customer_review->id}}')"><i class="icon-trash icons"></i></a>
											<a href="javascript:void(0);" onclick="changeStatus('{{$customer_review->id}}')" >
									 			<i class="fa fa-circle status_{{$customer_review->id}}" style="@if($customer_review->status=='verified')color:#009933;@else color: #ff0000;@endif" id="verified_{{$customer_review->id}}" title="{{$customer_review->status}}"></i>
											</a>
									</form>
									</td>
								</tr>
							@endforeach
						</tbody>
						<tfoot>
							<tr>
								<th>#</th>
								<th>Store</th>
								<th>Customer</th>
								<th>Review</th>
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
				title: 'review-list',
				exportOptions: {
				columns: [ 0, 1,2,3]
				}
			},
			{
				extend: 'excelHtml5',
				title: 'review-list',
				exportOptions: {
				columns: [ 0, 1, 2,3]
				}
			},
			{
				extend: 'pdfHtml5',
				title: 'review-list',
				exportOptions: {
				columns: [ 0, 1, 2,3]
				}
			},
			{
				extend: 'print',
				title: 'review-list',
				autoPrint: true,
				exportOptions: {
				columns: [ 0, 1, 2,3]
				}
			},
			'colvis'
		],
		columnDefs: [
			{ "orderable": false, "targets": 4 }
		]
	});
	table.buttons().container()
	.appendTo( '#example_wrapper .col-md-6:eq(0)' );
});

function deleteRow(id)
{   
	$('#deletefrm_'+id).submit();
}

function changeStatus(id) {
    $.ajax({
        data: {
        "_token": "{{ csrf_token() }}",
        "id": id
        },
        url: "{{ url('vendor/customer_reviews') }}/"+id,
        type: "GET",
        dataType: 'json',
        success: function (data) {
             $('.status_'+id).attr('title',data);
            if(data == 'verified'){
                $('.status_'+id).css('color','#009933');
                
            }else{
                $('.status_'+id).css('color','#ff0000');
            }
        },
        error: function (data) {
        }
    });
}
</script>
@endsection

