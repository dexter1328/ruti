@extends('supplier.layout.main')
@section('content')
<style type="text/css">
	#example1 input.check-row {
    	position: relative;
    	top: 2px;
	}
	/*print*/
	@media screen {
		#printSection {
			display: none;
		}
	}
	@media print {
		body * {
			visibility:hidden;
		}
		#printSection, #printSection * {
			visibility:visible;
		}
		#printSection {
			position:absolute;
			left:0;
			top:0;
		}
	}
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
<div class="row">
	<div class="col-lg-12">
		<div class="card">
			<div class="card-header">
				<div class="row">
					<div class="col-lg-6">
						<div class="left"><span>Generate Barcodes</span></div>
					</div>
					<div class="col-lg-6">
						<div class="row">
							<div class="col-12 col-sm-2">
							</div>
							<div class="col-12 col-sm-6">
								<select class="form-control" id="store" name="store">
									<option value="">Select Store</option>
									@foreach($vendor_stores as $vendor_store)
										<option value="{{$vendor_store->id}}">{{$vendor_store->name}}</option>
									@endforeach
								</select>
							</div>
							<div class="col-12 col-sm-4">
								<button type="button" class="btn btn-primary" id="generateBarcodeBtn">Generate Barcodes</button>
							</div>
						</div>
					</div>
				</div>
				<!-- <div class="left"><i class="fa fa-barcode"></i><span>Generate Barcodes</span></div>
				<div class="float-sm-right">
					<button type="button" class="btn btn-primary" id="generateBarcodeBtn">Generate Barcodes</button>
				</div> -->
			</div>
			<div class="card-body">
				<div class="table-responsive">
					<table id="example1" class="table table-bordered display" style="width: 100%">
						<thead>
							<tr>
								<th><input type="checkbox" class="barcode" id="main-check"></th>
								<th>Product</th>
								<th>Quantity</th>
							</tr>
						</thead>
						<tbody>
					</table>

				</div>
			</div>
		</div>
	</div>
</div><!-- End Row-->
<!-- modal -->

<div id="myModal" class="modal fade barcode-modal" role="dialog">
  	<div class="modal-dialog">
    	<div class="modal-content">
      		<div class="modal-header">
        		<h4 class="modal-title">Print Barcode</h4>
        		<button id="btnPrint" class="btn btn-primary">Print</button>
      		</div>
      		<div class="modal-body">
      			<div id="printThis"></div>
      		</div>
      		<div class="modal-footer">
        		<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      		</div>
    	</div>
  	</div>
</div>

<!-- end modal -->

<script>
var store_id = "";
$(document).ready(function() {

	getProduct();

	$("#store").change(function() {
		store_id = $(this).val();
		getProduct();
	});

	$('.barcode').click(function() {
		var checked = $(this).prop('checked');
		$('.check-row').prop('checked', checked);
	});

	$('#generateBarcodeBtn').click(function(){

		var barcodes = [];
		$.each($("input[name='barcode']:checked"), function(){
			barcodes.push($(this).val());
		});

		$.ajax({
			type: "post",
			url: "{{ url('supplier/products/print-barcode') }}",
			dataType: 'html',
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
			data: {
				"barcodes": barcodes
			},
			success: function (data) {
				$('#printThis').html(data);
				$("#myModal").modal('show');
			},
			error: function (error) {
			}
		});
	});

	$('#myModal').on('hidden.bs.modal', function () {
		$('.barcode').prop('checked', false);
		$('.check-row').prop('checked', false);
	});

	$(".table-responsive").on("click",".page-item", function(){
		$('.barcode').prop('checked', false);
	});

	$('#btnPrint').click(function(){

		var elem = document.getElementById("printThis");
		var domClone = elem.cloneNode(true);
		var $printSection = document.getElementById("printSection");

		if (!$printSection) {
			var $printSection = document.createElement("div");
			$printSection.id = "printSection";
			document.body.appendChild($printSection);
		}

		$printSection.innerHTML = "";
		$printSection.appendChild(domClone);
		window.print();
	});
});

function getProduct(){

	$('#example1').DataTable().destroy();

	$('#example1').removeAttr('width').DataTable({
		"pageLength": 25,
		"processing": true,
		"serverSide": true,
		"ajax":{
			"url": "{{ url('supplier/products/get-barcode-products') }}",
			"dataType": "json",
			"type": "POST",
			"data":{ _token: "{{csrf_token()}}" , store_id:store_id},
		},
		"columns": [
			//{ "data": "id" },
			{ "data": "checkbox" },
			{ "data": "products" },
			{ "data": "quantity" },
		],
		columnDefs: [
			{ orderable: false, className: 'select-checkbox', width: "5%", targets: 0 },
			{ width: "85%", targets: 1 },
			{ width: "10%", targets: 2 },
		],
        select: {
            style:    'os',
            selector: 'td:first-child'
        },
        order: [[ 1, 'asc' ]],
        fixedColumns: true
	});
}
</script>
@endsection

