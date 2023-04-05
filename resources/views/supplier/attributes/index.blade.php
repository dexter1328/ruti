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
			<div class="card-header">
				<div class="left"><span>Attributes</span></div>
				<div class="float-sm-right">
					<a style="padding-bottom: 3px; padding-top: 4px;" href="{{ route('supplier.attributes.create') }}" class="btn btn-outline-primary btn-sm waves-effect waves-light m-1" title="Add Attribute">
						<span class="name">Add New Attribute</span>
					</a>
				</div>
			</div>
			<div class="card-body">
				<div class="table-responsive">
					<table id="example" class="table table-bordered" width="100%">
						<thead>
							<tr>
								<th width="10%">#</th>
								<th width="20%">Name</th>
								<th width="50%">Description</th>
								<th width="10%">Store</th>
								<th width="10%">Action</th>
							</tr>
						</thead>
						<tbody>
							@foreach($attributes as $key => $attribute)
								<tr>
									<td>{{$key+1}}</td>
									<td>{{$attribute->name}}</td>
									<td>{!! nl2br(e($attribute->description)) ?: '-' !!}</td>
									<td>{{$attribute->store}}</td>
									<td class="action">
										<form id="deletefrm_{{$attribute->id}}" action="{{ route('supplier.attributes.destroy', $attribute->id) }}" method="POST" onsubmit="return confirm('Are you sure?');">
											@csrf
											@method('DELETE')
											<a href="{{ route('supplier.attributes.edit', $attribute->id) }}" class="edit" data-toggle="tooltip" data-placement="bottom" title="Edit Attribute">
												<i class="icon-note icons"></i>
											</a>
											<a href="javascript:void(0);" onclick="deleteRow('{{$attribute->id}}')" data-toggle="tooltip" data-placement="bottom" title="Delete Attribute">
												<i class="icon-trash icons"></i>
											</a>
										</form>
									</td>
								</tr>
							@endforeach
						</tbody>
						<tfoot>
							<tr>
								<th>#</th>
								<th>Name</th>
								<th>Description</th>
								<th>Store</th>
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

	var table = $('#example').DataTable({
		lengthChange: false,
		buttons: [
			{
				extend: 'copy',
				title: 'Attribute List',
				exportOptions: {
				columns: [ 0, 1, 2]
				}
			},
			{
				extend: 'excelHtml5',
				title: 'Attribute List',
				exportOptions: {
				columns: [ 0, 1, 2]
				}
			},
			{
				extend: 'pdfHtml5',
				title: 'Attribute List',
				exportOptions: {
				columns: [ 0, 1, 2]
				}
			},
			{
				extend: 'print',
				title: 'Attribute List',
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
	//table.columns.adjust().draw();
	table.buttons().container().appendTo( '#example_wrapper .col-md-6:eq(0)' );
});

function deleteRow(id)
{
	$('#deletefrm_'+id).submit();
}
</script>
@endsection

