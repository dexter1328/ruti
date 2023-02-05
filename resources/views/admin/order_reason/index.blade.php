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
				<div class="left"><!-- <i class="fa fa-user"></i> --> <span>Return/Cancel Order Reasons</span></div>
				<div class="float-sm-right">		
					<a style="padding-bottom: 3px; padding-top: 4px;" href="{{ route('order_reason.create') }}" class="btn btn-outline-primary btn-sm waves-effect waves-light m-1" title="Add Reason">
						<!-- <i class="icon-user-follow icons"></i> --> <span class="name">Add Reason</span>
					</a>
				</div>
			</div>
			<div class="card-body">
					<div class="table-responsive">
						<table id="example" class="table table-bordered">
							<thead>
								<tr>
									<th>#</th>
									<th>Reason</th>
									<th>Type</th>
									<th>Action</th>
								</tr>
							</thead>
							<tbody>
								@foreach($order_reasons as $key => $order_reason)
									<tr>
										<td>{{$key+1}}</td>
										<td>{{$order_reason->reason}}</td>
										<td>{{$order_reason->type}}</td>
										<td class="action">
											<form id="deletefrm_{{$order_reason->id}}" action="{{ route('order_reason.destroy', $order_reason->id) }}" method="POST" class="delete"  onsubmit="return confirm('Are you sure?');">
												@csrf
												@method('DELETE')
												<a href="{{ route('order_reason.edit', $order_reason->id) }}" class="edit" data-toggle="tooltip" data-placement="bottom" title="Edit OrderReason">
													<i class="icon-note icons"></i>
												</a>

												<a href="javascript:void(0);" onclick="deleteRow('{{$order_reason->id}}')" data-toggle="tooltip" data-placement="bottom" title="Delete OrderReason"><i class="icon-trash icons"></i>
												</a>

											</form>
										</td>
									</tr>
								@endforeach
							</tbody>
							<tfoot>
								<tr>
									<th>#</th>
									<th>Reason</th>
									<th>Type</th>
									<th>Action</th>
								</tr>
							</tfoot>
						</table>
					</div>
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
                title: 'Order Reason List',
                exportOptions: {
                    columns: [ 0, 1, 2]
                }
            },
            {
                extend: 'excelHtml5',
                title: 'Order Reason List',
                exportOptions: {
                    columns: [ 0, 1, 2]
                }
            },
            {
                extend: 'pdfHtml5',
                title: 'Order Reason List',
                exportOptions: {
                    columns: [ 0, 1, 2]
                }
            },
            {
                extend: 'print',
                title: 'Order Reason List',
                exportOptions: {
                    columns: [ 0, 1, 2]
                }
            },
            'colvis'
        ],
        columnDefs: [
        	{ "orderable": false, "targets": 3 }
      	]
      	/*columnDefs: [
            { width: "5%", targets: 0 },
            { width: "15%", targets: 1 },
            { width: "50%", targets: 2 },
            { width: "15%", targets: 3 },
            { "orderable": false, width: "15%", targets: 4 },
        ],*/
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
	        url: "{{ url('admin/admins') }}/"+id,
	        type: "GET",
	        dataType: 'json',
	        success: function (data) {
	            $('.status_'+id).attr('title',data);
	            if(data == 'active'){
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
