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
				<div class="left"><span>Configurations</span></div>
				<div class="float-sm-right">        
					<a style="padding-bottom: 3px; padding-top: 4px;" href="{{route('vendor.vendor_configuration.create')}}" class="btn btn-outline-primary btn-sm waves-effect waves-light m-1" title="Add Configuration">
						<span class="name">Add Configuration</span>
					</a>
				</div>
			</div>
			<div class="card-body">
				<div class="table-responsive">
					<table id="example" class="table table-bordered">
						<thead>
							<tr>
								<th>Vendor</th>
								<th>Payment Gateway</th>
								<th>Client Id</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
							@foreach($vendor_configurations as $vendor_configuration)
							<tr>
								<td>{{$vendor_configuration->name}}</td>
								<td>{{$vendor_configuration->payment_gateway}}</td>
								<td>{{$vendor_configuration->client_id}}</td>
								<td class="action">
									<form id="deletefrm_{{$vendor_configuration->id}}" 
										action="{{ route('vendor.vendor_configuration.destroy', $vendor_configuration->id) }}" method="POST" class="delete"  onsubmit="return confirm('Are you sure?');">
									@csrf
									@method('DELETE')
									<a href="{{ route('vendor.vendor_configuration.edit', $vendor_configuration->id) }}" class="edit">
									<i class="icon-note icons"></i>
									</a>
									<a href="javascript:void(0);" onclick="deleteRow('{{$vendor_configuration->id}}')"><i class="icon-trash icons"></i></a>
									</form>
									</td>
							</tr>
							@endforeach
						</tbody>
						<tfoot>
							<tr>
								<th>Vendor</th>
								<th>Payment Gateway</th>
								<th>Client Id</th>
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
				title: 'Configuration List',
				exportOptions: {
				columns: [ 0, 1,2]
				}
			},
			{
				extend: 'excelHtml5',
				title: 'Configuration List',
				exportOptions: {
				columns: [ 0, 1, 2]
				}
			},
			{
				extend: 'pdfHtml5',
				title: 'Configuration List',
				exportOptions: {
				columns: [ 0, 1, 2]
				}
			},
			{
				extend: 'print',
				title: 'Configuration List',
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

