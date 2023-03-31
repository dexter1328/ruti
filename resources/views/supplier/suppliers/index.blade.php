@extends('supplier.layout.main')
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
				<div class="row justify-content-between">
					<div class="col-3">
						<div class="left"><span>Employees</span></div>
					</div>
					<div class="col-9">
						<div class="vendor-btn-right">
		                	<div class="row justify-content-end">
		                        <div class="col-xs-12 col-sm-3">
		                        	<a href="{{ route('suppliers.create') }}" class="btn btn-outline-primary btn-sm waves-effect waves-light m-1" title="Add Employee">
                                        <span class="name">Add Employee</span>
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
								<th>Name</th>
								<th>Mobile</th>
								<th>Email</th>
								<th>Role</th>
								<th>Action</th>
							</tr>
						</thead>

						<tfoot>
							<tr>
								<th>Name</th>
								<th>Mobile</th>
								<th>Email</th>
								<th>Role</th>
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
				url: "{{ url('/supplier/suppliers/get_vendor_import_preview') }}",
				type: 'post',
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				},
				data: form_data,
				contentType: false,
				processData: false,
				success: function(response){

					var str = '';
					$("#previewModal").modal('show');
					var result = JSON.parse(response);
					console.log(result);
					if(result.error != '') {

						str += '<tr>';
							str += '<td colspan="10" align="center">'+result.error+'</td>';
						str += '</tr>';
					} else {

						$.each(result.data, function(i, val) {

							var image = '';
							if(val.image != '') {

								regexp =  /^(?:(?:https?|ftp):\/\/)?(?:(?!(?:10|127)(?:\.\d{1,3}){3})(?!(?:169\.254|192\.168)(?:\.\d{1,3}){2})(?!172\.(?:1[6-9]|2\d|3[0-1])(?:\.\d{1,3}){2})(?:[1-9]\d?|1\d\d|2[01]\d|22[0-3])(?:\.(?:1?\d{1,2}|2[0-4]\d|25[0-5])){2}(?:\.(?:[1-9]\d?|1\d\d|2[0-4]\d|25[0-4]))|(?:(?:[a-z\u00a1-\uffff0-9]-*)*[a-z\u00a1-\uffff0-9]+)(?:\.(?:[a-z\u00a1-\uffff0-9]-*)*[a-z\u00a1-\uffff0-9]+)*(?:\.(?:[a-z\u00a1-\uffff]{2,})))(?::\d{2,5})?(?:\/\S*)?$/;
								if (regexp.test(val.image)) {
									image = '<img class="card-img-top" src="'+val.image+'">';
								}
							}

							str += '<tr>';
								str += '<td>'+val.name+'</td>';
								str += '<td>'+val.email+'</td>';
								str += '<td>'+val.phone_number+'</td>';
								str += '<td>'+val.mobile_number+'</td>';
								str += '<td>'+val.address+'</td>';
								str += '<td>'+val.city+'</td>';
								str += '<td>'+val.state+'</td>';
								str += '<td>'+val.country+'</td>';
								str += '<td>'+val.pincode+'</td>';
								str += '<td>'+image+'</td>';
							str += '</tr>';
						});
					}
					$('#previewtable .previewtbody').html(str);

					$('#previewtable').DataTable({ 'order': [] });
				}
			});
		}
	});
	var table = $('#example').DataTable({
        "processing": true,
        "serverSide": true,
        "lengthChange": false,
        "ajax":{
			"url": "{{ url('supplier/suppliers/view/supplier_datatable') }}",
			"dataType": "json",
			"type": "POST",
			"data":{ _token: "{{csrf_token()}}"}
               },
        "columns": [
            { "data": "name" },
            { "data": "phone_no" },
            { "data": "email" },
            { "data": "role" },
            { "data": "action" }
        ],
        "dom" : 'Bfrtip',
        buttons: [
			{
				extend: 'copy',
				title: 'Supplier List',
				exportOptions: {
				columns: [ 0, 1,2,3,4]
				}
			},
			{
				extend: 'excelHtml5',
				title: 'Supplier List',
				exportOptions: {
				columns: [ 0, 1, 2,3,4]
				}
			},
			{
				extend: 'pdfHtml5',
				title: 'Supplier List',
				exportOptions: {
				columns: [ 0, 1, 2,3,4]
				}
			},
			{
				extend: 'print',
				title: 'Supplier List',
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

function changeStatus(id) {
    $.ajax({
        data: {
        "_token": "{{ csrf_token() }}",
        "id": id
        },
        url: "{{ url('supplier/suppliers') }}/"+id,
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
            suc_str +='<div class="alert-message"><span><strong>Success!</strong> Supplier has been '+status+'.</span></div>';
            suc_str +='</div>';
            $('.success-alert').html(suc_str);
        },
        error: function (data) {
        }
    });
}
</script>
@endsection

