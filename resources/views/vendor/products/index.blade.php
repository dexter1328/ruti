@extends('vendor.layout.main')
@section('content')

<style type="text/css">
	.card-img-top {
    width: 50%;
    height: auto;
    margin: 10px auto;
}
/*.btn-group.show{
	width:91% !important;
}
.multiselect.dropdown-toggle.btn.btn-default{
	width:100% !important;
}*/
</style>
<div class="success-alert" style="display:none;"></div>
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
@if(session()->get('error-data'))
 	<input type="hidden" id="error" value="{{ session()->get('error-data') }}"></span>
@endif
@if(session()->get('success-data'))
	<div class="alert alert-success alert-dismissible" role="alert">
		<button type="button" class="close" data-dismiss="alert">×</button>
		<div class="alert-icon">
			<i class="fa fa-check"></i>
		</div>
		<div class="alert-message">
			<span><strong>Success!</strong> {{ session()->get('success-data')['message'] }}</span>
		</div>
	</div>
	@if(!empty(session()->get('success-data')['barcodes']))
		<div class="alert alert-danger alert-dismissible" role="alert">
			<button type="button" class="close" data-dismiss="alert">×</button>
			<div class="alert-message">
				<span><strong>Error!</strong> These barcoces are already exist.</span>
				<ul>
					@foreach(session()->get('success-data')['barcodes'] as $barcode)
						<li>{{ $barcode }}</li>
					@endforeach
				</ul>
			</div>
		</div>
	@endif
@endif
<style type="text/css">
	div.dataTables_wrapper {
        width: 100%;
        margin: 0 auto;
    }
	.product-btn-right a,
	.product-btn-right button{width:100%;}
	.product-btn-right input.form-control {
	    padding: 2px;
	    border: 1px solid #003366;
	    position: relative;
	    top: 4px;
	}
	div#importModal {
	    width: 50%;
	    margin:
	    0 auto;
	}
	.text-danger{
		position: relative;
		/*top:5px;*/
	}
</style>
<div class="row">
	<div class="col-lg-12">
		<div class="card">
			<div class="card-header">
				<div class="row">
					<div class="col-3">
						<div class="left"><!-- <i class="fa fa-product-hunt"></i> -->
                            <span>Products</span>
                        </div>
					</div>
					<div class="col-9">
						<div class="product-btn-right">
		                	<div class="row justify-content-end">
		                        <div class="col-xs-12 col-sm-3">
                                    <a href="{{ route('vendor.products.create') }}" class="btn btn-outline-primary btn-sm waves-effect waves-light m-1" title="Add Product">
		                                <span class="name">Add Product</span>
		                            </a>
		                        </div>
                                <div class="col-xs-12 col-sm-3">
                                    <a href="{{route('vendor.inventory.upload')}}" class="btn btn-outline-primary btn-sm waves-effect waves-light m-1" title="Add Product">
		                                <span class="name">Import</span>
		                            </a>
		                        </div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="card-body">
				<div class="table-responsive">
					<table id="example_demo" class="table table-bordered display" style="width: 100%">
						<thead style="background: black;">
							<tr >
								<th>SKU</th>
								<th>Product Title</th>
								<th>Brand</th>
								<th>Category</th>
								<th>Retail Price</th>
								<th>Stock</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
                            @foreach ($products as $product)

                            <tr>
                                <td>{{$product->sku}}</td>
                                <td>{{$product->title}}</td>
                                <td>{{$product->brand ? $product->brand : 'Not Specified'}}</td>
                                <td>{{$product->w2b_category_1}}</td>
                                <td>{{$product->retail_price}}</td>
                                <td>{{$product->stock}}</td>
                                <td>
                                    <form method="POST" action="{{ route('vendor.products.destroy', $product->id) }}">
                                        <a href="{{ route('vendor.products.edit', $product->id) }}" class="btn btn-primary btn-sm">Edit</a>&nbsp;
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this post?')">Delete</button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach

						</tbody>

					</table>

				</div>

			</div>
            <div class="justify-content-end float-right" style="float:right">
            {!! $products->links() !!}

            </div>


		</div>
	</div>
</div><!-- End Row-->

<script>

// validation error of import
var errors = '<?php echo $errors; ?>';
var obj = $.parseJSON(errors);

if(!jQuery.isEmptyObject(obj) || $('#error').val() != ''){
	$('#importModal').modal('show');
}
// end validation error of import

$(document).ready(function() {

	$('#store').multiselect({
		nonSelectedText: 'Select Store',
		buttonWidth: '91%',
		allSelectedText: 'All',
      	maxHeight: 300,
      	includeSelectAllOption: true

	});

	$("#btnImport").click(function(){
		$('#btnImport').hide();
		$('#processing').show();
	});

	$("#btnPreview").click(function(){

		if($("#store option:selected" ).val() == '') {
			$('#store_preview_error').html('Please Select Store');
		} else {
			$('#store_preview_error').html('');
		}

		if($('#import_file').val() == '') {
			$('#file_preview_error').html('Please Select File');
		} else {
			$('#file_preview_error').html(' ');
		}


		if($("#store option:selected" ).val() != '' && $('#import_file').val() != '') {

			var form_data = new FormData();
			var files = $('#import_file')[0].files;
			form_data.append('file',files[0]);
			form_data.append('store',$("#store").val());
			$.ajax({
				url: "{{ url('/vendor/products/get_import_preview') }}",
				type: 'post',
				data: form_data,
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				},
				contentType: false,
				processData: false,
				success: function(response) {

					var str = '';
					$("#previewModal").modal('show');
					var result = JSON.parse(response);
					// console.log(result);
					if(result.error != '') {

						console.log(result.error);
						str += '<tr>';
							str += '<td colspan="6" align="center">'+result.error+'</td>';
						str += '</tr>';
					} else {

						var columns = 0;
						$.each(result.data, function(i, val) {

							var arr_count = countInObject(result.data[i]);
							if(arr_count > columns) {
								columns = arr_count;
							}

							str += '<tr>';
								// str += '<td class="dt-control"></td>';
								str += '<td>'+val.title+'</td>';
								str += '<td>'+val.quantity+'</td>';
								str += '<td>'+val.discount+'%</td>';
								str += '<td>'+val.brand+'</td>';
								str += '<td>'+val.categories+'</td>';
								str += '<td>$'+val.price+'</td>';
							str += '</tr>';
							// str += '<tr><td><img src="'+val.images+'" height="50" width="50"></td><td>'+val.title+'</td><td>'+val.sku+'</td><td>'+val.barcode+'</td><td>'+val.tax+'</td><td>'+val.status+'</td><td>'+val.quantity+'</td><td>'+val.lowstock_threshold+'</td><td>'+val.discount+'</td><td>'+val.brand+'</td><td>'+val.categories+'</td><td>'+val.season+'</td><td>'+val.aisle+'</td><td>'+val.shelf+'</td><td>$'+val.price+'</td></tr>';
						});
						console.log(columns);
					}

					$('#preview_table .previewtbody').html(str);
					var preview_table = $('#preview_table').DataTable({ 'order': [] });

					/*$('#preview_table tbody').off('click').on('click', 'td.dt-control', function () {
						var tr = $(this).closest('tr');
						var row = preview_table.row( tr );

						if ( row.child.isShown() ) {
							// This row is already open - close it
							row.child.hide();
							tr.removeClass('shown');
						}
						else {
							// Open this row
							row.child( format(row.data()) ).show();
							tr.addClass('shown');
						}
					} );*/
				}
			});
		}
	});

	var table = $('#example').DataTable({
        "processing": true,
        "serverSide": true,
        "lengthChange": false,
        "ajax":{
			"url": "{{ url('vendor/products/view_product_datatable') }}",
			"dataType": "json",
			"type": "POST",
			"data":{ _token: "{{csrf_token()}}"}
               },
        "columns": [
            { "data": "vendor" },
            { "data": "store" },
            { "data": "title" },
            { "data": "action" }
        ],
        "dom" : 'Bfrtip',
        buttons: [
			{
				extend: 'copy',
				title: 'Product List',
				exportOptions: {
				columns: [ 0, 1,2,3,4]
				}
			},
			{
				extend: 'excelHtml5',
				title: 'Product List',
				exportOptions: {
				columns: [ 0, 1, 2,3,4]
				}
			},
			{
				extend: 'pdfHtml5',
				title: 'Product List',
				exportOptions: {
				columns: [ 0, 1, 2,3,4]
				}
			},
			{
				extend: 'print',
				title: 'Product List',
				autoPrint: true,
				exportOptions: {
				columns: [ 0, 1, 2,3,4]
				}
			},
			'colvis'
		]

    });
	 table.buttons().container()
	.appendTo( '#example_wrapper .col-md-6:eq(0)' );

} );

function deleteRow(id)
{
    $('#deletefrm_'+id).submit();
}

function changeStatus(id){

	$.ajax({
		data: {
			"_token": "{{ csrf_token() }}",
			"id": id
		},
		url: "{{ url('vendor/products/product-status') }}/"+id,
		type: "GET",
		dataType: 'json',
		success: function (data) {
			var status = '';
            // $('.status_'+id).attr('title',data);
            if(data == 'enable'){
            	status = 'enabled';
                $('.status_'+id).css('color','#009933');

            }else{
            	status = 'disabled';
                $('.status_'+id).css('color','#ff0000');
            }
            $('.success-alert').show();
            var suc_str = '';
            suc_str += '<div class="alert alert-success alert-dismissible" role="alert">';
            suc_str +='<button type="button" class="close" data-dismiss="alert">×</button>';
            suc_str +='<div class="alert-icon"><i class="fa fa-check"></i></div>';
            suc_str +='<div class="alert-message"><span><strong>Success!</strong> Product has been '+status+'.</span></div>';
            suc_str +='</div>';
            $('.success-alert').html(suc_str);
		},
		error: function (data) {
		}
	});
}

function countInObject(obj)
{
	var count = 0;
	// iterate over properties, increment if a non-prototype property
	for(var key in obj) if(obj.hasOwnProperty(key)) count++;
	return count;
}

function format ( d ) {
    // `d` is the original data object for the row
    return '<table cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;">'+
        '<tr>'+
            '<td>Description:</td>'+
            '<td>'+d.description+'</td>'+
        '</tr>'+
        '<tr>'+
            '<td>SKU:</td>'+
            '<td>'+d.sku+'</td>'+
        '</tr>'+
    '</table>';
}
</script>
@endsection

