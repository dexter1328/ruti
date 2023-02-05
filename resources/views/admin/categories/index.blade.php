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
				<div class="left"><!-- <i class="fa fa-list"></i> --><span>Categories</span></div>
				<div class="float-sm-right">        
					<a style="padding-bottom: 3px; padding-top: 4px;" href="{{ route('categories.create') }}" class="btn btn-outline-primary btn-sm waves-effect waves-light m-1" title="Add Category">
					<!-- <i class="fa fa-list" style="font-size:15px;"></i> --> <span class="name">Add New Category</span>
					</a>
				</div>
			</div>
			<div class="card-body">
				<div class="table-responsive">
					<table id="example" class="table table-bordered category-table">
						<thead>
							<tr>
								<!--<th width="10%">SR.NO</th>-->
								<th>Name</th>
								<!-- <th>Description</th> -->
								<!--<th width="10%">Parent</th>-->
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
							{!! $categories !!}
							@php /* @endphp
							@foreach($categories as $key => $category)
								<tr>
									<td>{{$key+1}}</td>
									<td>{{$category->name}}</td>
									<td>{!! nl2br(e($category->description)) ?: '-' !!}</td>
									<td>{{$category->parent}}</td>
									<td class="action">
										<form id="deletefrm_{{$category->id}}" action="{{ route('categories.destroy', $category->id) }}" method="POST" onsubmit="return confirm('Are you sure?');">
											@csrf
											@method('DELETE')
											<a href="{{ route('categories.edit', $category->id) }}" class="edit" data-toggle="tooltip" data-placement="bottom" title="Edit Category">
												<i class="icon-note icons"></i>
											</a>
											<a href="javascript:void(0);" onclick="deleteRow('{{$category->id}}')" data-toggle="tooltip" data-placement="bottom" title="Delete Category">
												<i class="icon-trash icons"></i>
											</a>
										</form>
									</td>
								</tr>
							@endforeach
							@php */ @endphp
						</tbody>
						<tfoot>
							<tr>
								<!--<th width="10%">SR.NO</th>-->
								<th>Name</th>
								<!-- <th>Description</th> -->
								<!--<th width="10%">Parent</th>-->
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
				columns: [ 0, 1]
				}
			},
			{
				extend: 'excelHtml5',
				title: 'Category List',
				exportOptions: {
				columns: [ 0, 1]
				}
			},
			{
				extend: 'pdfHtml5',
				title: 'Category List',
				exportOptions: {
				columns: [ 0, 1]
				}
			},
			{
				extend: 'print',
				title: 'Category List',
				autoPrint: true,
				exportOptions: {
				columns: [ 0, 1]
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

