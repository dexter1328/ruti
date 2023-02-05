@extends('admin.layout.main')
@section('content')

<style type="text/css">
	/*div.dataTables_wrapper {
        width: 800px !important;
        margin: 0 auto !important;
    }*/
</style>

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
<div class="success-alert" style="display:none;"></div>
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
				<span><strong>Error!</strong> These barcoces are already exist.</span><br><br>
					@foreach(session()->get('success-data')['barcodes'] as $barcode)
						{{ $barcode }},
					@endforeach
			</div>
		</div>
	@endif
@endif
<style type="text/css">
	/*div.dataTables_wrapper {
        width: 1000px;
        margin: 0 auto;
    }*/
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
	    margin: 0 auto;
	}
	.text-danger{
		position: relative;
/*		top:5px;*/
	}
	div#previewModal {
	    width: 90%;
	    margin: 0 auto;
	}
</style>

<div class="row">
	<div class="col-lg-12">
		<div class="card">
			<div class="card-header">
				<div class="row">
					<div class="col-3">
						<div class="left"><!-- <i class="fa fa-product-hunt"></i> --><span>Products</span></div>
					</div>
					<div class="col-9">
						<div class="product-btn-right"> 
		                	<div class="row">      
		                		<div class="col-xs-12 col-sm-3">
		                			@if(has_permission(Auth::user()->role_id,'import_product','read'))   
		                			<a href="{{url('/public/ezsiop-product-import.csv')}}" download="sample-product.csv" class="download-csv">Download Sample CSV</a>
		                			@endif
		                		</div>
		                      	<div class="col-xs-12 col-sm-3">
		                      		@if(has_permission(Auth::user()->role_id,'import_product','write'))   
		                      		<button class="btn btn-outline-primary btn-sm waves-effect waves-light m-1" data-toggle="modal" data-target="#importModal"><i class="fa fa-upload" style="font-size:15px;"></i> <span class="name">Import</span></button>
		                      		@endif
		                        </div>
		                        <div class="col-xs-12 col-sm-3">
		                      		<a href="{{ url('admin/products/export-product') }}" class="btn btn-outline-primary btn-sm waves-effect waves-light m-1"><span class="name">Export</span></a>
		                        </div>
		                        <div class="col-xs-12 col-sm-3">
		                        	  <a href="{{ route('products.create') }}" class="btn btn-outline-primary btn-sm waves-effect waves-light m-1" title="Add Product">
		                            <!-- <i class="fa fa-product-hunt" style="font-size:15px;"></i> --> <span class="name">Add Product</span>
		                        </a>
		                        </div>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="card-body">
				<div class="table-responsive">
					<table id="example" class="table table-bordered display" style="width: 100%">
						<thead>
							<tr>
								<th>Vendor</th>
								<th>Store</th>
								<th>Title</th>
								<th>Action</th>
							</tr>
						</thead>

					</table>
				</div>
			</div>
		</div>
	</div>
</div><!-- End Row-->

<!-- modal -->

<div class="modal fade" id="importModal">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Import Product</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
			<div id="error"></div>
				<form method="post" action="{{ url('admin/products/import-product') }}" enctype="multipart/form-data" id="import-product">
					@csrf
					<div class="form-group">
						<label for="input-1">Vendor<span class="text-danger">*</span></label>
						<select name="vendor" class="form-control" id="vendor">
                                <option value="">Select Vendor</option>
                                @foreach($vendors as $vendor)
                                    <option value="{{$vendor->id}}" {{ (old("vendor") == $vendor->id ? "selected":"") }}>{{$vendor->name}}</option>
                                @endforeach
                        </select>
                        <span class="text-danger" id="vendor_preview_error"></span>
                        @if ($errors->has('vendor')) 
                            <span class="text-danger" id="vendor_error">{{ $errors->first('vendor') }}</span>
                    	@endif 
					</div>
					<div class="form-group">
						<label>Store<span class="text-danger">*</span></label>
                        <select name="store" id="store" class="form-control">
                            <option value="">Select Store</option>
                        </select>
                        <span class="text-danger" id="store_preview_error"></span>
                        @if ($errors->has('store')) 
                        	<span class="text-danger" id="store_error">{{ $errors->first('store') }}</span> 
                        @endif 
					</div>
					<div class="form-group">
						<label for="input-3">File<span class="text-danger">*</span></label>
						<input type="file" name="import_file" id="import_file" class="form-control" accept=".csv">
						
						@if(session()->get('error-data'))
							<span class="text-danger">{{ session()->get('error-data') }}</span>
						@endif
						@if ($errors->has('import_file'))
							<span class="text-danger">{{ $errors->first('import_file') }}</span>
						@endif
						<label style="margin-top:10px;">Note:</label>File must be csv.</br>
						<span class="text-danger" id="file_preview_error"></span>
						<span class="text-danger" id="file_extension_preview_error"></span>
					</div>
					<div class="form-group">
						<button type="button" class="btn btn-primary px-5" id="btnPreview">Preview</button>
						<button type="submit" class="btn btn-primary px-5" id="btnImport">Submit</button>
						<span id="processing" style="display: none;">Processing...</span>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
	
               
<!-- end modal -->
<!-- preview modal -->
<div class="modal fade" id="previewModal">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Preview</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div id="preview_div">
					
    			</div>
			</div>
		</div>
	</div>
</div>
<!-- end preview modal -->
<script>

// validation error of import
var errors = '<?php echo $errors; ?>';
var obj = $.parseJSON(errors);
// console.log(errors);
if(!jQuery.isEmptyObject(obj) || $('#error').val() != ''){
	$('#importModal').modal('show');
}

var vendor_id = "{{old('vendor')}}";
var store_id = "{{old('store')}}";
$(document).ready(function() {

	$("#btnImport").click(function(){
		$('#btnImport').hide();
		$('#processing').show();
	});
	$("#btnPreview").click(function(){
		// $("#previewModal").modal('show');
		
		// alert($("#vendor").val());
		if($("#vendor option:selected" ).val() == ''){
			
			$("#vendor_preview_error").html('Please Select Vendor');
		}else{
			$("#vendor_preview_error").html('');
		}
		if($("#store option:selected" ).val() == ''){
			$('#store_preview_error').html('Please Select Store');
		}else{
			$('#store_preview_error').html('');
		}
		
		if($('#import_file').val() == '')
		{	
			$('#file_preview_error').html('Please Select File');
			
		}else{
			$('#file_preview_error').html(' ');
		}
		

		if($("#vendor option:selected" ).val() != '' && $("#store option:selected" ).val() != '' && $('#import_file').val() != ''){
			var form_data = new FormData();
			var files = $('#import_file')[0].files;
			form_data.append('file',files[0]);
			form_data.append('vendor',$("#vendor").val());
			form_data.append('store',$("#store").val());
			$.ajax({
	              url: "{{ url('/admin/products/get_import_preview') }}",
	              type: 'post',
	              data: form_data,
	              headers: {
	                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	            	},
	            	
	              contentType: false,
	              processData: false,
	              success: function(response){
	              
	              	$("#previewModal").modal('show');
	              	var data = JSON.parse(response);
	              	var str = '';
	              	str +='<table id="preview_table"  class="table table-bordered display nowrap">';
					str +='<thead>';
					str +='<tr>';
					str +='<th>Image</th>';
					str +='<th>Title</th>';
					str +='<th>Sku</th>';
					str +='<th>Barcode</th>';
					str +='<th>Tax</th>';
					str +='<th>Status</th>';
					str +='<th>Quantity</th>';
					str +='<th>Lowstock</th>';
					str +='<th>Discount</th>';
					str +='<th>Brand</th>';
					str +='<th>Category</th>';
					str +='<th>Season</th>';
					str +='<th>Aisle</th>';
					str +='<th>Shelf</th>';
					str +='<th>Price</th>';
					str +='</tr>';
					str +='</thead>';
					str +='<tbody class="previewtbody">';
	               	$.each(data, function(i, val) {
	              		str += '<tr><td><img src="'+val.images+'" height="50" width="50"></td><td>'+val.title+'</td><td>'+val.sku+'</td><td>'+val.barcode+'</td><td>'+val.tax+'</td><td>'+val.status+'</td><td>'+val.quantity+'</td><td>'+val.lowstock_threshold+'</td><td>'+val.discount+'</td><td>'+val.brand+'</td><td>'+val.categories+'</td><td>'+val.season+'</td><td>'+val.aisle+'</td><td>'+val.shelf+'</td><td>$'+val.price+'</td></tr>';
	                });
	                str +='</tbody>';
	               	str +='</table>';
	                // $('#preview_table .previewtbody').html(str);
	                $('#preview_div').html(str);
	                $('#preview_table').DataTable( {
				        "scrollX": true
				    } );
	              	$(window).trigger('resize');
	              }
	        });
		}
	});
	
	 /*$('#preview_table').DataTable( {
        "scrollX": true
    } );*/

	// setTimeout(function(){ $(window).trigger('resize'); }, 500);
	var table = $('#example').DataTable({
        "processing": true,
        "serverSide": true,
        "lengthChange": false,
        "ajax":{
			"url": "{{ url('admin/products/view_product_datatable') }}",
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
	setTimeout(function(){ getStores(); }, 500);

 	$("#vendor").change(function() {
        vendor_id = $(this).val();
        getStores();
    });

} );

function getStores(){

    if(vendor_id != ''){
        $.ajax({
            type: "get",
            url: "{{ url('/get-stores') }}/"+vendor_id,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            dataType: 'json',
            success: function (data) {
                $('#store').empty();
                $("#store").append('<option value="">Select Store</option>');
                $.each(data, function(i, val) {
                    $("#store").append('<option value="'+val.id+'">'+val.name+'</option>');
                });
                if($("#store option[value='"+store_id+"']").length > 0){
                   $('#store').val(store_id);
                }
            },
            error: function (data) {
            }
        });
    }else{
        $("#vendor").val('');
    }
}

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
		url: "{{ url('admin/products/product-status') }}/"+id,
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

</script>
@endsection

