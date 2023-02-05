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
				<div class="left"><!-- <i class="fa fa-star"></i> --><span>Reviews</span></div>
				<div class="float-sm-right">        
					<a style="padding-bottom: 3px; padding-top: 4px;" href="{{ route('customer_reviews.create') }}" class="btn btn-outline-primary btn-sm waves-effect waves-light m-1" title="Add Review">
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
								<th>Vendor</th>
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
									<td>{{$customer_review->owner_name}}</td>
									<td>{{$customer_review->store_name}}</td>
									<td>{{$customer_review->first_name}}</td>
									<td>{{$customer_review->review}}</td>
									<td class="action">
									<form id="deletefrm_{{$customer_review->id}}" action="{{ route('customer_reviews.destroy', $customer_review->id) }}" method="POST" class="delete"  onsubmit="return confirm('Are you sure?');">
									@csrf
									@method('DELETE')
									<a href="{{ route('customer_reviews.edit', $customer_review->id) }}" class="edit">
									<i class="icon-note icons"></i>
									</a>
									<a href="javascript:void(0);" onclick="deleteRow('{{$customer_review->id}}')"><i class="icon-trash icons"></i></a>

									<a href="javascript:void(0);" onclick="changeStatus('{{$customer_review->id}}')" >
								 		<i class="fa fa-circle status_{{$customer_review->id}}" style="@if($customer_review->status=='verified')color:#009933;@else color: #ff0000;@endif" id="active_{{$customer_review->id}}" title="{{$customer_review->status}}"></i>
									</a>

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
            { width: "15%", targets: 1 },
            { width: "20%", targets: 2 },
            { width: "20%", targets: 3 },
            { width: "20%", targets: 4 },
            { width: "20%", "orderable": false,targets: 5 },
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

function changeStatus(id) {
    $.ajax({
        data: {
        "_token": "{{ csrf_token() }}",
        "id": id
        },
        url: "{{ url('admin/customer_reviews') }}/"+id,
        type: "GET",
        dataType: 'json',
        success: function (data) {
             $('.status_'+id).attr('title',data);
            if(data == 'verified'){
                $('.status_'+id).css('color','#009933');
                
            }else{
                $('.status_'+id).css('color','#ff0000');
            }
            $('.success-alert').show();
			var suc_str = '';
			suc_str += '<div class="alert alert-success alert-dismissible" role="alert">';
			suc_str +='<button type="button" class="close" data-dismiss="alert">×</button>';
			suc_str +='<div class="alert-icon"><i class="fa fa-check"></i></div>';
			suc_str +='<div class="alert-message"><span><strong>Success!</strong> Review has been '+data+'.</span></div>';
			suc_str +='</div>';
			$('.success-alert').html(suc_str);
        },
        error: function (data) {
        }
    });
}
</script>
@endsection

