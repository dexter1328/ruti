@extends('supplier.layout.main')
@section('content')
<style type="text/css">
	/*#sidebar-wrapper{
		display: none;
	}*/
	.quantity{
		width: 100px;
	}
	.image{
		display: none;
	}

</style>
<link href="https://cdn.datatables.net/fixedcolumns/3.3.0/css/fixedColumns.dataTables.min.css" rel="stylesheet" type="text/css">
<script src="https://cdn.datatables.net/fixedcolumns/3.3.0/js/dataTables.fixedColumns.min.js"></script>
<div class="row">
	<div class="col-lg-12">
		<div class="card">
			<div class="card-header">
				<div class="left"><span>Inventory</span></div>
			</div>
			<div class="card-body">
				<div class="row justify-content-end">
					<div class="col-lg-4">
						<div class="form-group">
							<label for="brand_id">Brand</label>
							<select name="brand_id" class="form-control" id="brand_id">
								<option value="">Select Brand</option>
							</select>
						</div>
					</div>
					<div class="col-lg-4">
						<div class="form-group">
							<label for="category_id">Category</label>
							<select name="category_id" class="form-control" id="category_id">
								<option value="">Select Category</option>
							</select>
						</div>
					</div>
		        </div>
				<div class="table-responsive">
					<table id="example" class="table table-bordered display" style="width: 100%">
						<thead>
							<!-- <th>Id</th> -->
							<th>Title</th>
							<th>Brand</th>
							<th>SKU</th>
							<th>Retail Price</th>
							<th>Wholesale Price</th>
							<th>Stock</th>
						</thead>
						<tbody>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
<script>

var store_id = "";
var brand_id = "";
var category_id = "";

$(document).ready(function() {

	getProduct();

	$("#store_id").change(function() {
		store_id = $(this).val();
		getBrands();
		getCategoriesDropDown();
		getProduct();
	});

	$("#brand_id").change(function() {
		brand_id = $(this).val();
		getProduct();
	});

	$("#category_id").change(function() {
		category_id = $(this).val();
		getProduct();
	});

});

function getBrands(){

	if(store_id != ''){
		$.ajax({
			type: "get",
			url: "{{ url('/get-brands') }}/"+store_id,
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
			dataType: 'json',
			success: function (data) {
				$('#brand_id').empty();
				$("#brand_id").append('<option value="">Select Brand</option>');
				$.each(data, function(i, val) {
					$("#brand_id").append('<option value="'+val.id+'">'+val.name+'</option>');
				});
			},
			error: function (data) {
			}
		});
	}
}

function getCategoriesDropDown(){

	if(store_id != ''){

		$.ajax({
			type: "get",
			url: "{{ url('/get-categories-dropdown') }}/"+store_id,
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
			dataType: 'json',
			success: function (data) {
				$('#category_id').empty();
				$("#category_id").append('<option value="">Select Parent</option>');
				$("#category_id").append(data.categories);
			},
			error: function (data) {
			}
		});
	}
}

function getProduct(){

	$('#example').DataTable().destroy();

	$('#example').removeAttr('width').DataTable({
		//"pageLength": 100,
		"processing": true,
		"serverSide": true,
		"ajax":{
			"url": "{{ url('supplier/products/get-inventory') }}",
			"dataType": "json",
			"type": "POST",
			"data":{ _token: "{{csrf_token()}}", store_id:store_id, brand_id:brand_id, category_id:category_id }
		},
		"columns": [
			{ "data": "title" },
			{ "data": "brand" },
			{ "data": "sku" },
			{ "data": "retail_price" },
			{ "data": "wholesale" },
			{ "data": "stock" },
		],
		columnDefs: [
            { width: "30%", targets: 0 },
            { width: "20%", targets: 1 },
            { width: "18%", targets: 2 },
            { width: "10%", targets: 3 },
            { width: "12%", targets: 4 },
            { width: "10%", targets: 5 },
        ],
        fixedColumns: true
	});
}

function updateQuatity(id)
{
	var quantity = $('#quantity_'+id).val();
	$.ajax({
		type: "post",
		url: "{{ url('supplier/products/update-quantity') }}",
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		},
		data: { id:id, quantity:quantity },
		dataType: 'json',
		success: function (data) {
			console.log(data);
		},
		error: function (data) {
		}
	});
}

function updateDiscount(id)
{
	var discount = $('#discount_'+id).val();
	$.ajax({
		type: "post",
		url: "{{ url('supplier/products/update-discount') }}",
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		},
		data: { id:id, discount:discount },
		dataType: 'json',
		success: function (data) {
			console.log(data);
		},
		error: function (data) {
		}
	});
}

function updatePrice(id)
{
    const price = $('#price_' + id).val();
    $.ajax({
		type: "post",
		url: "{{ url('supplier/products/update-price') }}",
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		},
		data: { id:id, price:price },
		dataType: 'json',
		success: function (data) {
			console.log(data);
		},
		error: function (data) {
		}
	});
}

</script>
@endsection
