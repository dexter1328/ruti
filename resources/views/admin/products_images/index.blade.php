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
				<div class="left"><!-- <i class="fa fa-picture-o"></i> --><span>Product Images</span></div>
				<div class="float-sm-right">        
					<a style="padding-bottom: 3px; padding-top: 4px;" href="{{url('admin/addimage/'.$product->id)}}" class="btn btn-outline-primary btn-sm waves-effect waves-light m-1" title="Add Product Images">
						<!-- <i class="fa fa-picture-o" style="font-size:15px;"></i> --> <span class="name">Add Image</span>
					</a>
				</div>
			</div>
			<div class="card-body">
				<div class="table-responsive">
					<table id="example" class="table table-bordered">
						<thead>
							<tr>
								<th>#</th>
								<th style="display:none">Images</th>
								<th>Images</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
							@foreach($product_images as $key=>$product_image)
								<tr>
									<td>{{$key+1}}</td>
									<td style="display:none">{{asset('public/images/product_images').'/'.$product_image->image}}</td>
									<td><img src="{{asset('public/images/product_images').'/'.$product_image->image}}" width="50" height="50"></td>
									<td class="action">
									<form id="deletefrm_{{$product_image->id}}" action="{{ route('product_images.destroy', $product_image->id) }}" method="POST" class="delete"  onsubmit="return confirm('Are you sure?');">
									@csrf
									@method('DELETE')
									<a href="{{ route('product_images.edit', $product_image->id) }}" class="edit">
									<i class="icon-note icons"></i>
									</a>
									<a href="javascript:void(0);" onclick="deleteRow('{{$product_image->id}}')"><i class="icon-trash icons"></i></a>
									</form>
									</td>
								</tr>
							@endforeach
						</tbody>
						<tfoot>
							<tr>
								<th>#</th>
								<th style="display:none">Images</th>
								<th>Images</th>
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
				title: 'Image List',
				exportOptions: {
				columns: [ 0, 1]
				}
			},
			{
				extend: 'excelHtml5',
				title: 'Image List',
				exportOptions: {
				columns: [ 0, 1]
				}
			},
			{
				extend: 'pdfHtml5',
				title: 'Image List',
				exportOptions: {
				columns: [ 0, 1]
				}
			},
			{
				extend: 'print',
				title: 'Image List',
				autoPrint: true,
				exportOptions: {
				columns: [ 0, 1]
				}
			},
			'colvis'
		],
		columnDefs: [
			{ "orderable": false, "targets": 2 }
		]
	} );

	table.buttons().container()
	.appendTo( '#example_wrapper .col-md-6:eq(0)' );

} );
function deleteRow(id)
{   
	$('#deletefrm_'+id).submit();
}
</script>
@endsection

