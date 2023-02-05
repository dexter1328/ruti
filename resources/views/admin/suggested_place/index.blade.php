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
				<div class="left"><span>Suggested Place</span> </div>
				<div class="float-sm-right"> 
				</div>
			</div>
			<div class="card-body">
				<div class="table-responsive">
					<table id="example" class="table table-bordered">
						<thead>
							<tr>
								<th>#</th>
								<th>Customer</th>
								<th>Store</th>
								<th>Email</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
							@foreach($suggested_places as $key => $suggested_place)
								<tr>
									<td>{{$key+1}}</td>
									<td>{{$suggested_place->first_name}} {{$suggested_place->last_name}}</td>
									<td>{{$suggested_place->store}}</td>
									<td>{{$suggested_place->email}}</td>
									<td class="action">
										<form id="deletefrm_{{$suggested_place->id}}" action="{{ route('suggested-place.destroy', $suggested_place->id) }}" method="POST" class="delete"  onsubmit="return confirm('Are you sure?');">
											@csrf
											@method('DELETE')
											<a href="{{ route('suggested-place.edit', $suggested_place->id) }}" class="edit" data-toggle="tooltip" data-placement="bottom" title="Edit Suggested Place">
											<i class="icon-note icons"></i>
											</a>
											<a href="{{ route('suggested-place.show', $suggested_place->id) }}" class="edit" data-toggle="tooltip" data-placement="bottom" title="View Suggested Place">
											<i class="icon-eye icons"></i>
											</a>
											<a href="javascript:void(0);" onclick="deleteRow('{{$suggested_place->id}}')" data-toggle="tooltip" data-placement="bottom" title="Delete Suggested Place"><i class="icon-trash icons"></i></a>

										</form>
									</td>
								</tr>
							@endforeach
						</tbody>
						<tfoot>
							<tr>
								<th>#</th>
								<th>Customer</th>
								<th>Store</th>
								<th>Email</th>
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
        // buttons: [ 'copy', 'excel', 'pdf', 'print', 'colvis' ],
        buttons: [
        	{
                extend: 'copy',
                title: 'Suggested Place List',
                exportOptions: {
                    columns: [ 0, 1, 2, 3]
                }
            },
            {
                extend: 'excelHtml5',
                title: 'Suggested Place List',
                exportOptions: {
                    columns: [ 0, 1, 2, 3]
                }
            },
            {
                extend: 'pdfHtml5',
                title: 'Suggested Place List',
                exportOptions: {
                    columns: [ 0, 1, 2, 3]
                }
            },
            {
                extend: 'print',
                title: 'Suggested Place List',
                exportOptions: {
                    columns: [ 0, 1, 2, 3]
                }
            },
            'colvis'
        ],
        columnDefs: [
        	{ "orderable": false, "targets": 4 }
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
function deleteRow(id){   
	$('#deletefrm_'+id).submit();
}
</script>
@endsection 