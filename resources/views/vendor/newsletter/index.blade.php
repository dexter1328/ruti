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
				<div class="left"> <span>Newsletters</span> </div>
				<div class="float-sm-right"> 
					<a style="padding-bottom: 3px; padding-top: 4px;" href="{{ route('vendor.newsletters.create') }}" class="btn btn-outline-primary btn-sm waves-effect waves-light m-1" title="Add New Newsletter"> <span class="name">Add Newsletter</span> </a> 
				</div>
			</div>
			<div class="card-body">
				<div class="table-responsive">
					<table id="example" class="table table-bordered">
						<thead>
							<tr>
								<th>#</th>
								<th>Subject</th>
								<th>Status</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
							@foreach($newsletters as $key => $newsletter)
								<tr>
									<td>{{$key+1}}</td>
									<td>{{$newsletter->subject_name}}</td>
									<td>{{$newsletter->status}}</td>
									<td class="action">
									<form id="deletefrm_{{$newsletter->id}}" action="{{ route('vendor.newsletters.destroy', $newsletter->id) }}" method="POST" class="delete"  onsubmit="return confirm('Are you sure?');">
									@csrf
									@method('DELETE')
									
										<a href="{{ url('vendor/newsletters/get-user-newsletters', $newsletter->id) }}" data-toggle="tooltip" data-placement="bottom" title="View Newsletter"><i class="icon-eye icons"></i></a>

									<a href="{{ route('vendor.newsletters.edit', $newsletter->id) }}" class="edit" data-toggle="tooltip" data-placement="bottom" title="Edit Newsletter">
									<i class="icon-note icons"></i>
									</a>
									<a href="javascript:void(0);" onclick="deleteRow('{{$newsletter->id}}')" data-toggle="tooltip" data-placement="bottom" title="Delete Newsletter"><i class="icon-trash icons"></i></a>

									@if(isset($vendor_paid_module->status) && $vendor_paid_module->status == 'yes')
										<a href="{{ route('vendor.newsletters.show', $newsletter->id) }}" data-toggle="tooltip" data-placement="bottom" title="Send Newsletter"><i class="icon-paper-plane icons"></i></a>
									@endif
									</form>
									</td>
								</tr>
							@endforeach
						</tbody>
						<tfoot>
							<tr>
								<th>#</th>
								<th>Subject</th>
								<th>Status</th>
								<th>Action</th>
							</tr>
						</tfoot>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- End Row--> 
<script>
$(document).ready(function() {

	var table = $('#example').DataTable( {
		lengthChange: false,
		buttons: [
			{
				extend: 'copy',
				title: 'Newsletter List',
				exportOptions: {
				columns: [ 0, 1,2]
				}
			},
			{
				extend: 'excelHtml5',
				title: 'Newsletter List',
				exportOptions: {
				columns: [ 0, 1, 2]
				}
			},
			{
				extend: 'pdfHtml5',
				title: 'Newsletter List',
				exportOptions: {
				columns: [ 0, 1, 2]
				}
			},
			{
				extend: 'print',
				title: 'Newsletter List',
				autoPrint: true,
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

} );
function deleteRow(id){   
	$('#deletefrm_'+id).submit();
}
</script>
@endsection 