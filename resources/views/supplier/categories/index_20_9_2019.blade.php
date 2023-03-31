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
				<div class="left"><i class="fa fa-list"></i><span>Categories</span></div>
				<div class="float-sm-right">        
					<a style="padding-bottom: 3px; padding-top: 4px;" href="{{ route('categories.create') }}" class="btn btn-outline-primary btn-sm waves-effect waves-light m-1" title="Add New Category">
					<i class="fa fa-list" style="font-size:15px;"></i> <span class="name">Add New Category</span>
					</a>
				</div>
			</div>
			<div class="card-body">
				<div class="table-responsive">
					<table id="example" class="table table-bordered" width="100%">
						<thead>
							<tr>
								<!-- <th width="10%">SR.NO</th>
								<th width="20%">Name</th>
								<th width="60%">Description</th>
								<th width="10%">Actions</th> -->
								<th width="10%">SR.NO</th>
								<th width="10%">Parent</th>
								<th width="20%">Name</th>
								<th width="60%">Description</th>
							</tr>
						</thead>
						<tbody>
							<!-- @foreach($items as $key => $value)
								<tr>
									<td></td>
									<td></td>
									<td></td>
									<td class="action">
										
									</td>
								</tr>
							@endforeach -->
							@php /* @endphp
							@foreach($categories as $key => $category)
								<tr>
									<td>{{$key+1}}</td>
									<td>{{$category->parent}}</td>
									<td>{{$category->name}}</td>
									<td>{!! nl2br(e($category->description)) ?: '-' !!}</td>
								</tr>
							@endforeach
							<!-- @foreach($categories as $key => $category)
								<tr>
									<td>{{$key+1}}</td>
									<td>{{$category->name}}</td>
									<td>{!! nl2br(e($category->description)) ?: '-' !!}</td>
									<td class="action">
										<form id="deletefrm_{{$category->id}}" action="{{ route('categories.destroy', $category->id) }}" method="POST" onsubmit="return confirm('Are you sure?');">
											@csrf
											@method('DELETE')
											<a href="{{ route('categories.edit', $category->id) }}" class="edit">
												<i class="icon-note icons"></i>
											</a>
											<a href="javascript:void(0);" onclick="deleteRow('{{$category->id}}')">
												<i class="icon-trash icons"></i>
											</a>
										</form>
									</td>
								</tr>
							@endforeach -->
							@php */ @endphp
						</tbody>
						<tfoot>
							<tr>
								<th width="10%">SR.NO</th>
								<th width="10%">Parent</th>
								<th width="20%">Name</th>
								<th width="60%">Description</th>
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
				title: 'category-list',
				exportOptions: {
				columns: [ 0, 1, 2]
				}
			},
			{
				extend: 'excelHtml5',
				title: 'category-list',
				exportOptions: {
				columns: [ 0, 1, 2]
				}
			},
			{
				extend: 'pdfHtml5',
				title: 'category-list',
				exportOptions: {
				columns: [ 0, 1, 2]
				}
			},
			{
				extend: 'print',
				title: 'category-list',
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

