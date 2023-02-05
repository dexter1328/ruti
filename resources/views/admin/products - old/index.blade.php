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
				<div class="left"><i class="fa fa-product-hunt"></i><span>Products</span></div>
				<div class="float-sm-right">        
					<a style="padding-bottom: 3px; padding-top: 4px;" href="{{ route('products.create') }}" class="btn btn-outline-primary btn-sm waves-effect waves-light m-1" title="Add New Service Provider">
						<i class="fa fa-product-hunt" style="font-size:15px;"></i> <span class="name">Add Product</span>
					</a>
				</div>
			</div>
			<div class="card-body">
				<div class="table-responsive">
					<table id="example" class="table table-bordered">
						<thead>
							<tr>
								<th>SR.NO</th>
								<th>Vendor</th>
								<th>Store</th>
								<th>Category</th>
								<th>Brand</th>
								<th>Title</th>
								<th>Type</th>
								<th>Status</th>
								<th>Actions</th>
							</tr>
						</thead>
						<tbody>
							@foreach($products as $key=> $product)
								<tr>
									<td>{{$key+1}}</td>
									<td>{{$product->owner_name}}</td>
									<td>{{$product->store_name}}</td>
									<td>{{$product->category_name}}</td>
									<td>{{$product->brand_name}}</td>
									<td>{{$product->title}}</td>
									<td>{{$product->type}}</td>
									<td>{{$product->status}}</td>
									<td class="action">
									<form id="deletefrm_{{$product->id}}" action="{{ route('products.destroy', $product->id) }}" method="POST" class="delete"  onsubmit="return confirm('Are you sure?');">
									@csrf
									@method('DELETE')
									<a href="{{url('admin/product-gallery/'.$product->id)}}" class="edit">
									<i class="icon-picture"></i>
									</a>
									<a href="{{ route('products.edit', $product->id) }}" class="edit">
									<i class="icon-note icons"></i>
									</a>
									<a href="javascript:void(0);" onclick="deleteRow('{{$product->id}}')"><i class="icon-trash icons"></i></a>
									</form>
									</td>
								</tr>
							@endforeach
						</tbody>
						<tfoot>
							<tr>
								<th>SR.NO</th>
								<th>Vendor</th>
								<th>Store</th>
								<th>Category</th>
								<th>Brand</th>
								<th>Title</th>
								<th>Type</th>
								<th>Status</th>
								<th>Actions</th>
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
				title: 'product-list',
				exportOptions: {
				columns: [ 0, 1, 2, 3, 4, 5, 6, 7]
				}
			},
			{
				extend: 'excelHtml5',
				title: 'product-list',
				exportOptions: {
				columns: [ 0, 1, 2, 3, 4, 5, 6, 7]
				}
			},
			{
				extend: 'pdfHtml5',
				title: 'product-list',
				exportOptions: {
				columns: [ 0, 1, 2, 3, 4, 5, 6, 7]
				}
			},
			{
				extend: 'print',
				title: 'product-list',
				autoPrint: true,
				exportOptions: {
				columns: [ 0, 1, 2, 3, 4, 5, 6, 7]
				}
			},
			'colvis'
		],
		columnDefs: [
			{ "orderable": false, "targets": 8 }
		]
	} );
	table.buttons().container()
	.appendTo( '#example_wrapper .col-md-6:eq(0)' );
} );
</script>
@endsection

