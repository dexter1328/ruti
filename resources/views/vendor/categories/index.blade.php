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
				<div class="left"><span>Categories</span></div>
				<div class="float-sm-right">        
					<a style="padding-bottom: 3px; padding-top: 4px;" href="{{ route('vendor.categories.create') }}" class="btn btn-outline-primary btn-sm waves-effect waves-light m-1" title="Add Category">
						<span class="name">Add New Category</span>
					</a>
				</div>
			</div>
			<div class="card-body">
				<div class="table-responsive">
					<table id="example" class="table table-bordered category-table">
						<thead>
							<tr>
								<th>Name</th>
								<th>Description</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
							{!! $categories !!}
						</tbody>
						<tfoot>
							<tr>
								<th>Name</th>
								<th>Description</th>
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
		ordering: false,
		buttons: [
			{
				extend: 'copy',
				title: 'Category List',
				exportOptions: {
				columns: [ 0, 1, 2]
				}
			},
			{
				extend: 'excelHtml5',
				title: 'Category List',
				exportOptions: {
				columns: [ 0, 1, 2]
				}
			},
			{
				extend: 'pdfHtml5',
				title: 'Category List',
				exportOptions: {
				columns: [ 0, 1, 2]
				}
			},
			{
				extend: 'print',
				title: 'Category List',
				autoPrint: true,
				exportOptions: {
				columns: [ 0, 1, 2]
				}
			},
			'colvis'
		],
		columnDefs: [
			{
				targets: 0,
				className: 'dt-body-left'
			}
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

