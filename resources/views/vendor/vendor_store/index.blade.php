@extends('vendor.layout.main')
@section('content')
<style type="text/css">
	div#importModal {
	    width: 50%;
	    margin: 
	    0 auto;
	}
	.store-btn-right a,
	.store-btn-right button{width:100%;}
	.store-btn-right input.form-control {
	    padding: 2px;
	    border: 1px solid #003366;
	    position: relative;
	    top: 4px;
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
				<div class="row">
					<div class="col-3">
						<div class="left"><!-- <i class="fa fa-product-hunt"></i> --><span>Store</span></div>
					</div>
					<div class="col-9">
						<div class="store-btn-right"> 
		                	<div class="row">   
		                		<div class="col-xs-12 col-sm-3">
		                			<a href="{{url('/public/ezsiop-store-import.csv')}}" download="sample-store.csv" class="download-csv">Download Sample CSV</a>
		                		</div>
		                      	<div class="col-xs-12 col-sm-3">
		                      		<button class="btn btn-outline-primary btn-sm waves-effect waves-light m-1" data-toggle="modal" data-target="#importModal"><span class="name">Import</span></button>
		                        </div>
		                        <div class="col-xs-12 col-sm-3">
		                      		<a href="{{ url('vendor/stores/export/store') }}" class="btn btn-outline-primary btn-sm waves-effect waves-light m-1"><span class="name">Export</span></a>
		                        </div>
		                        <div class="col-xs-12 col-sm-3">
		                        	<a href="{{ route('vendor.stores.create') }}" class="btn btn-outline-primary btn-sm waves-effect waves-light m-1" title="Add Store">
		                            <!-- <i class="fa fa-product-hunt" style="font-size:15px;"></i> --> <span class="name">Add Store</span>
		                        </a>
		                        </div>
							</div>
						</div>
					</div>
				</div>
				<!-- <div class="left"><span>Stores</span></div>
				<div class="float-sm-right">        
					<a style="padding-bottom: 3px; padding-top: 4px;" href="{{ route('vendor.stores.create') }}" class="btn btn-outline-primary btn-sm waves-effect waves-light m-1" title="Add Store">
						<span class="name">Add Store</span>
					</a>
				</div> -->
			</div>
			<div class="card-body">
				<div class="table-responsive">
					<table id="store_tbl" class="table table-bordered">
						<thead>
							<tr>
								<th>#</th>
								<th>Branch Admin</th>
								<th>Name</th>
								<th>Phone</th>
								<th>Email</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
							@foreach($vendor_stores as $key=>$vendor_store)
								<tr>
									<td>{{$key+1}}</td>
									<td>{{$vendor_store->branch_admin}}</td>
									<td>{{$vendor_store->name}}</td>
									<td>{{$vendor_store->phone_number}}</td>
									<td>{{$vendor_store->email}}</td>
									<td class="action">
										<form id="deletefrm_{{$vendor_store->id}}" action="{{ route('vendor.stores.destroy', $vendor_store->id) }}" method="POST" class="delete"  onsubmit="return confirm('Are you sure?');">
											@csrf
											@method('DELETE')
											<a href="{{ route('vendor.stores.edit', $vendor_store->id) }}" class="edit" data-toggle="tooltip" data-placement="bottom" title="Edit Store">
												<i class="icon-note icons"></i>
											</a>
											<a href="javascript:void(0);" onclick="deleteRow('{{$vendor_store->id}}')" data-toggle="tooltip" data-placement="bottom" title="Delete Store"><i class="icon-trash icons"></i></a>
											<a href="javascript:void(0);" onclick="changeStatus('{{$vendor_store->id}}')" >
									 			<i class="fa fa-circle status_{{$vendor_store->id}}" style="@if($vendor_store->status=='enable')color:#009933;@else color: #ff0000;@endif" id="enable_{{$vendor_store->id}}" data-toggle="tooltip" data-placement="bottom" title="Change Status"></i>
											</a>
										</form>
									</td>
								</tr>
							@endforeach
						</tbody>
						<tfoot>
							<tr>
								<th>#</th>
								<th>Branch Admin</th>
								<th>Name</th>
								<th>Phone</th>
								<th>Email</th>
								<th>Action</th>
							</tr>
						</tfoot>
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
				<h5 class="modal-title">Import Store</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
			<div id="error"></div>
				<form method="post" action="{{ url('vendor/stores/import-store') }}" enctype="multipart/form-data">
					@csrf
					<div class="form-group">
						<label>File<span class="text-danger">*</span></label>
                        <input type="file" name="import_file" class="form-control">
                        @if ($errors->has('import_file')) 
                        	<span class="text-danger">{{ $errors->first('import_file') }}</span> 
                        @endif 
					</div>
					<div class="form-group">
						<button type="submit" class="btn btn-primary px-5" id="btnImport">Submit</button>
						<span id="processing" style="display: none;">Processing...</span>
					</div>
				</form> 
			</div>
		</div>
	</div>
</div>
<!-- import modal -->
<script>
$(document).ready(function() {
	// validation error of import
var errors = '<?php echo $errors; ?>';
var obj = $.parseJSON(errors);

if(!jQuery.isEmptyObject(obj) || $('#error').val() != ''){
	$('#importModal').modal('show');
}
$("#btnImport").click(function(){
		$('#btnImport').hide();
		$('#processing').show();
	});
// end validation error of import
	var table = $('#store_tbl').DataTable( {
		lengthChange: false,
			buttons: [
			{
				extend: 'copy',
				title: 'vendor-list',
				exportOptions: {
				columns: [ 0, 1, 2, 3, 4]
				}
			},
			{
				extend: 'excelHtml5',
				title: 'vendor-list',
				exportOptions: {
				columns: [ 0, 1, 2, 3, 4]
				}
			},
			{
				extend: 'pdfHtml5',
				title: 'vendor-list',
				exportOptions: {
				columns: [ 0, 1, 2, 3, 4]
				}
			},
			{
				extend: 'print',
				title: 'vendor-list',
				autoPrint: true,
				exportOptions: {
				columns: [ 0, 1, 2, 3, 4]
				}
			},
			'colvis'
		],
		columnDefs: [
			{ "orderable": false, "targets": 5 }
		]
	} );

	table.buttons().container()
	.appendTo( '#store_tbl_wrapper .col-md-6:eq(0)' );

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
        url: "{{ url('vendor/stores') }}/"+id,
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
            suc_str +='<div class="alert-message"><span><strong>Success!</strong> Store has been '+status+'.</span></div>';
            suc_str +='</div>';
            $('.success-alert').html(suc_str);
        },
        error: function (data) {
        }
    });
}
</script>

@endsection

