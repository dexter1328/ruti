@extends('admin.layout.main')
@section('content')
<style type="text/css">
	div#importModal {
	    width: 50%;
	    margin: 
	    0 auto;
	}
	.vendor-btn-right a,
	.vendor-btn-right button{width:100%;}
	.vendor-btn-right input.form-control {
	    padding: 2px;
	    border: 1px solid #003366;
	    position: relative;
	    top: 4px;
	}
	.card-img-top {
	    width: 50%;
	    height: auto;
	    margin: 10px auto;
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
@if(session()->get('error-data'))
 	<input type="hidden" id="error" value="{{ session()->get('error-data') }}"></span>
@endif
@if(session()->get('success-data'))
	<!-- <div class="alert alert-success alert-dismissible" role="alert">
		<button type="button" class="close" data-dismiss="alert">×</button>
		<div class="alert-icon">
			<i class="fa fa-check"></i>
		</div>
		<div class="alert-message">
			<span><strong>Success!</strong> {{ session()->get('success-data')['message'] }}</span>
		</div>
	</div> -->
	@if(!empty(session()->get('success-data')['emails']))
		<div class="alert alert-danger alert-dismissible" role="alert">
			<button type="button" class="close" data-dismiss="alert">×</button>
			<div class="alert-message">
				<span><strong>Error!</strong> These email are already exist.</span>
				<ul>
					@foreach(session()->get('success-data')['emails'] as $value)
						<li>{{ $value }}</li>
					@endforeach
				</ul>
			</div>
		</div>
	@else
		<div class="alert alert-success alert-dismissible" role="alert">
		<button type="button" class="close" data-dismiss="alert">×</button>
		<div class="alert-icon">
			<i class="fa fa-check"></i>
		</div>
		<div class="alert-message">
			<span><strong>Success!</strong> {{ session()->get('success-data')['message'] }}</span>
		</div>
	</div>
	@endif
@endif
<div class="success-alert" style="display:none;"></div>
<div class="row">
	<div class="col-lg-12">
		<div class="card">
			<div class="card-header">
				<!-- <div class="left"><span>Vendors</span></div>
				<div class="float-sm-right">        
					<a style="padding-bottom: 3px; padding-top: 4px;" href="{{ route('vendor.create') }}" class="btn btn-outline-primary btn-sm waves-effect waves-light m-1" title="Add Vendor">
						<span class="name">Add Vendor</span>
					</a>
				</div> -->
				<div class="row">
					<div class="col-3">
						<div class="left"><!-- <i class="fa fa-product-hunt"></i> --><span>Vendors</span></div>
					</div>
					<div class="col-9">
						<div class="vendor-btn-right"> 
		                	<div class="row">   
		                		<div class="col-xs-12 col-sm-3">
		                			<a href="{{url('/public/ezsiop-vendor-import.csv')}}" download="sample-vendor.csv" class="download-csv">Download Sample CSV</a>
		                		</div>
		                      	<div class="col-xs-12 col-sm-3">
		                      		<button class="btn btn-outline-primary btn-sm waves-effect waves-light m-1" data-toggle="modal" data-target="#importModal"><span class="name">Import</span></button>
		                        </div>
		                        <div class="col-xs-12 col-sm-3">
		                      		<a href="{{ route('admin.export.vendor') }}" class="btn btn-outline-primary btn-sm waves-effect waves-light m-1"><span class="name">Export</span></a>
		                        </div>
		                        <div class="col-xs-12 col-sm-3">
		                        	<a href="{{ route('vendor.create') }}" class="btn btn-outline-primary btn-sm waves-effect waves-light m-1" title="Add Vendor">
		                            <!-- <i class="fa fa-product-hunt" style="font-size:15px;"></i> --> <span class="name">Add Vendor</span>
		                        </a>
		                        </div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="card-body">
				<div class="table-responsive">
					<table id="example" class="table table-bordered">
						<thead>
							<tr>
								<!-- <th>#</th> -->
								<th>Name</th>
								<th>Zip Code</th>
								<th>Mobile No</th>
								<th>Email</th>
								<th>Action</th>
							</tr>
						</thead>
						
						<!-- <tfoot>
							<tr>
								<th>#</th>
								<th>Owner</th>
								<th>Pincode</th>
								<th>Phone No</th>
								<th>Email</th>
								<th>Action</th>
							</tr>
						</tfoot> -->
					</table>
				</div>
			</div>
		</div>
	</div>
</div><!-- End Row-->

<!-- import modal -->
<div class="modal fade" id="importModal">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Import Vendor</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
			<div id="error"></div>
				<form method="post" action="{{ url('admin/vendor/import-vendor') }}" enctype="multipart/form-data">
					@csrf
					<div class="form-group">
						<label>File<span class="text-danger">*</span></label>
                        <input type="file" name="import_file" id="import_file" class="form-control">
                        @if ($errors->has('import_file')) 
                        	<span class="text-danger">{{ $errors->first('import_file') }}</span> 
                        @endif 
                        <label style="margin-top:10px;">Note:</label>File must be csv.
						<span class="text-danger" id="file_preview_error"></span>
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
<!-- import modal -->
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
					<table id="previewtable" class="table table-bordered">
						<thead><tr><th>Image</th><th>Name</th><th>Email</th><th>Phone No</th><th>Mobile No</th><th>Address</th><th>City</th><th>State</th><th>Country</th><th>Zip Code</th><th>Expiry Date</th><th>Membership</th><th>Admin Commision</th><th>Status</th></tr></thead><tbody class="previewtbody"></tbody>
						<tfoot><tr><th>Image</th><th>Name</th><th>Email</th><th>Phone No</th><th>Mobile No</th><th>Address</th><th>City</th><th>State</th><th>Country</th><th>Zip Code</th><th>Expiry Date</th><th>Membership</th><th>Admin Commision</th><th>Status</th></tr></tfoot>
					</table>
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

if(!jQuery.isEmptyObject(obj) || $('#error').val() != ''){
	$('#importModal').modal('show');
}
// end validation error of import
$(document).ready(function() {
	$("#btnImport").click(function(){
		$('#btnImport').hide();
		$('#processing').show();
	});
	$("#btnPreview").click(function(){
		// $("#previewModal").modal('show');
		
		// alert($("#vendor").val());
		
		if($('#import_file').val() == '')
		{	
			$('#file_preview_error').html('Please Select File');
			
		}else{
			$('#file_preview_error').html(' ');
		}
		

		if($('#import_file').val() != ''){
			var form_data = new FormData();
			var files = $('#import_file')[0].files;
			form_data.append('file',files[0]);
			$.ajax({
	              url: "{{ url('admin/vendor/get_vendor_import_preview') }}",
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
	               	// str += '<div class="row">';
	               	// str += '';
	               	$.each(data, function(i, val) {
	              		str += '<tr><td><img class="card-img-top" src="'+val.image+'" alt="Vendor image"></td><td>'+val.name+'</td><td>'+val.email+'</td><td>'+val.phone_number+'</td><td>'+val.mobile_number+'</td><td>'+val.address+'</td><td>'+val.city+'</td><td>'+val.state+'</td><td>'+val.country+'</td><td>'+val.pincode+'</td><td>'+val.expiry_date+'</td><td>'+val.membership+'</td><td>'+val.admin_commision+'</td><td>'+val.status+'</td></tr>';

	              		/*str += '<div class="col-12 col-md-6 col-lg-4"><div class="card"><img class="card-img-top" src="'+val.image+'" alt="Card image cap"><div class="card-body"><h4 class="card-title"><a href="#" title="View Product">'+val.name+'</a></h4><div class="row"><div class="col"><p>email</p><p>Phone No</p><p>tax</p><p>Mobile No</p><p>Address</p><p>Expiry Date</p><p>Membership</p><p>Admin Commision</p><p>Website Link</p><p>Status</p><p>Role</p></div><div class="col"><p>'+val.email+'</p><p>'+val.phone_number+'</p><p>'+val.mobile_number+'</p><p>'+val.address+'</p><p>'+val.city+'</p><p>'+val.state+'</p><p>'+val.country+'</p><p>'+val.pincode+'</p><p>'+val.expiry_date+'</p><p>'+val.membership+'</p><p>'+val.admin_commision+'</p><p>'+val.status+'</p></div></div></div></div></div>';*/
	                });
	                	// str += '</tbody';
	                $('#previewtable .previewtbody').html(str);
	                
	                $('#previewtable').DataTable();
	              }
	        });
		}
	});
	/*var table = $('#example').DataTable( {
		lengthChange: false,
			buttons: [
			{
				extend: 'copy',
				title: 'Vendor List',
				exportOptions: {
				columns: [ 0, 1, 2, 3, 4]
				}
			},
			{
				extend: 'excelHtml5',
				title: 'Vendor List',
				exportOptions: {
				columns: [ 0, 1, 2, 3, 4]
				}
			},
			{
				extend: 'pdfHtml5',
				title: 'Vendor List',
				exportOptions: {
				columns: [ 0, 1, 2, 3, 4]
				}
			},
			{
				extend: 'print',
				title: 'Vendor List',
				autoPrint: true,
				exportOptions: {
				columns: [ 0, 1, 2, 3, 4]
				}
			},
			'colvis'
		],
		//columnDefs: [
			//{ "orderable": false, "targets": 5 }
		//],
		columnDefs: [
            { width: "6%", targets: 0 },
            { width: "18%", targets: 1 },
            { width: "18%", targets: 2 },
            { width: "18%", targets: 3 },
            { width: "25%", targets: 4 },
            { width: "15%","orderable": false, targets: 5 },
        ],
        fixedColumns: true
	} );

	table.buttons().container()
	.appendTo( '#example_wrapper .col-md-6:eq(0)' );*/
	var table = $('#example').DataTable({
        "processing": true,
        "serverSide": true,
        "lengthChange": false,
        "ajax":{
			"url": "{{ url('admin/vendor/view/vendor_datatable') }}",
			"dataType": "json",
			"type": "POST",
			"data":{ _token: "{{csrf_token()}}"}
               },
        "columns": [
            { "data": "name" },
            { "data": "pincode" },
            { "data": "mobile_number" },
            { "data": "email" },
            { "data": "action" }
        ],
        "dom" : 'Bfrtip',
        buttons: [
			{
				extend: 'copy',
				title: 'Vendor List',
				exportOptions: {
				columns: [ 0, 1,2,3,4]
				}
			},
			{
				extend: 'excelHtml5',
				title: 'Vendor List',
				exportOptions: {
				columns: [ 0, 1, 2,3,4]
				}
			},
			{
				extend: 'pdfHtml5',
				title: 'Vendor List',
				exportOptions: {
				columns: [ 0, 1, 2,3,4]
				}
			},
			{
				extend: 'print',
				title: 'Vendor List',
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
// $(document).ready(function() {
// 	$('#previewtable').DataTable({
//         'paging'      : true,
// 		'lengthChange': true,
// 		'searching'   : true,
// 		'ordering'    : true,
// 		'info'        : true,
// 		'autoWidth'   : true,
// 		"columnDefs": [
// 		{ "orderable": false, "targets": 9 }
// 		]
//     });
   
// } );
function deleteRow(id)
{   
	$('#deletefrm_'+id).submit();
}

function changeStatus(id) {
    $.ajax({
        data: {
        "_token": "{{ csrf_token() }}",
        "id": id
        },
        url: "{{ url('admin/vendor') }}/"+id,
        type: "GET",
        dataType: 'json',
        success: function (data) {
         	var status = '';
            // $('.status_'+id).attr('title',data);
            if(data == 'active'){
                status = 'activated';
                $('.status_'+id).css('color','#009933');
                
            }else{
                status = 'deactivated';
                $('.status_'+id).css('color','#ff0000');
            }
            $('.success-alert').show();
            var suc_str = '';
            suc_str += '<div class="alert alert-success alert-dismissible" role="alert">';
            suc_str +='<button type="button" class="close" data-dismiss="alert">×</button>';
            suc_str +='<div class="alert-icon"><i class="fa fa-check"></i></div>';
            suc_str +='<div class="alert-message"><span><strong>Success!</strong> Vendor has been '+status+'.</span></div>';
            suc_str +='</div>';
            $('.success-alert').html(suc_str);
        },
        error: function (data) {
        }
    });
}

function exportVendor()
{
	$.ajax({
		url: "{{ url('admin/vendor/export/vendor') }}",
		type: 'get',
		headers: {
		'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		},

		contentType: false,
		processData: false,
		success: function(response){
	              
	    }	
	});
}
</script>
@endsection

