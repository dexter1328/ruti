@extends('supplier.layout.main')
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
@elseif(session()->get('error'))
<div class="alert alert-danger alert-dismissible" role="alert">
	<button type="button" class="close" data-dismiss="alert">×</button>
	<div class="alert-icon">
		<i class="fa fa-times"></i>
	</div>
	<div class="alert-message">
		<span><strong>Error!</strong> {{ session()->get('error') }}</span>
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
	{{--@if(!empty(session()->get('success-data')['barcodes']))
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
	@endif --}}
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
                                    <a href="{{ route('supplier.products.create') }}" class="btn btn-outline-primary btn-sm waves-effect waves-light m-1" title="Add Product">
		                                <span class="name">Add Product</span>
		                            </a>
		                        </div>
                                <div class="col-xs-12 col-sm-3">
                                    <a href="{{ route('supplier.products.create') }}" class="btn btn-outline-primary btn-sm waves-effect waves-light m-1" title="Add Product">
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
					<table id="example" class="table table-bordered display" style="width: 100%">
						<thead>
							<tr>
								<th>SKU</th>
								<th>Product Title</th>
								<th>Brand</th>
								<th>Category</th>
								<th>Retail Price</th>
								<th>Wholesale Price</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
						</tbody>

					</table>

				</div>
{{--				<nav aria-label="...">--}}
{{--					@if ($products->lastPage() > 1)--}}
{{--						<ul class="pagination justify-content-center">--}}
{{--							<li class="page-item {{ $products->currentPage() == 1 ? 'disabled' : '' }}">--}}
{{--								<a class="page-link" href="{{ $products->url($products->currentPage() - 1) }}"--}}
{{--									tabindex="-1">Previous</a>--}}
{{--							</li>--}}
{{--							@for ($i = 1; $i <= $products->lastPage(); $i++)--}}
{{--								<li class="page-item {{ $products->currentPage() == $i ? 'active' : '' }}"><a--}}
{{--										class="page-link" href=" {{ $products->url($i) }}">{{ $i }}</a></li>--}}
{{--							@endfor--}}
{{--							<li--}}
{{--								class="page-item {{ $products->currentPage() == $products->lastPage() ? 'disabled' : '' }}">--}}
{{--								<a class="page-link" href="{{ $products->url($products->currentPage() + 1) }}">Next</a>--}}
{{--							</li>--}}
{{--						</ul>--}}
{{--					@endif--}}
{{--				</nav>--}}
{{--				<span class="text-info ml-1 mb-1" > Showing {{ $products->firstItem() }} to {{ $products->lastItem() }}--}}
{{--					of total {{ $products->total() }} products</span>--}}
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


	const table = $('#example').DataTable({
        "processing": true,
        "serverSide": true,
        "lengthChange": false,
        "ajax":{
			"url": "{{ url('supplier/products/view_product_datatable') }}",
			"dataType": "json",
			"type": "POST",
			"data":{ _token: "{{csrf_token()}}"}
               },
        "columns": [
            { "data": "sku" },
            { "data": "title" },
            { "data": "brand" },
            { "data": "supplier_category_1" },
            { "data": "retail_price" },
            { "data": "wholesale" },
            { "data": "action", "orderable": false, "searchable": false },
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
	 table.buttons().container().appendTo( '#example_wrapper .col-md-6:eq(0)' );

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
		url: "{{ url('supplier/products/product-status') }}/"+id,
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

