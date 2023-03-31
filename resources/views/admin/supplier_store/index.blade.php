@extends('admin.layout.main')
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
						<div class="left"><!-- <i class="fa fa-product-hunt"></i> --><span>Supplier Stores</span></div>
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
		                      		<a href="{{ url('admin/supplier_store/export/store') }}" class="btn btn-outline-primary btn-sm waves-effect waves-light m-1"><span class="name">Export</span></a>
		                        </div>
		                        <div class="col-xs-12 col-sm-3">
		                        	<a href="{{ route('supplier_store.create') }}" class="btn btn-outline-primary btn-sm waves-effect waves-light m-1" title="Add Store">
		                            <!-- <i class="fa fa-product-hunt" style="font-size:15px;"></i> --> <span class="name">Add Store</span>
		                        </a>
		                        </div>
							</div>
						</div>
					</div>
				</div>
				<!-- <div class="left"><span>Supplier Stores</span></div>
				<div class="float-sm-right">
					<a style="padding-bottom: 3px; padding-top: 4px;" href="{{ route('supplier_store.create') }}" class="btn btn-outline-primary btn-sm waves-effect waves-light m-1" title="Add Store">
						<span class="name">Add Store</span>
					</a>
				</div> -->
			</div>
			<div class="card-body">
				<div class="table-responsive">
					<table id="example" class="table table-bordered">
						<thead>
							<tr>
								<th>#</th>
								<th>Supplier</th>
								<th>Store Name</th>
								<th>Branch Admin</th>
								<th>Phone No</th>
								<th>Email</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
							@foreach($vendor_stores as $key=>$vendor_store)
								<tr>
									<td >{{$key+1}}</td>
									<td>{{$vendor_store->vendor_name}}</td>
									<td >{{$vendor_store->name}}</td>
									<td >{{$vendor_store->branch_admin}}</td>
									<td >{{$vendor_store->phone_number}}</td>
									<td >{{$vendor_store->email}}</td>
									<td class="action">

											<a href="{{ route('supplier_store.edit', $vendor_store->id) }}" class="edit" data-toggle="tooltip" data-placement="bottom" title="Edit Store">
												<i class="icon-note icons"></i>
											</a>

											<a href="javascript:void(0);" onclick="deleteRow('{{$vendor_store->id}}')" data-toggle="tooltip" data-placement="bottom" title="Delete Store">
												<i class="icon-trash icons"></i>
											</a>

											<a href="javascript:void(0);" onclick="changeStatus('{{$vendor_store->id}}')" >
											 	<i class="fa fa-circle status_{{$vendor_store->id}}" style="@if($vendor_store->status=='enable')color:#009933;@else color: #ff0000;@endif" id="active_{{$vendor_store->id}}" data-toggle="tooltip" data-placement="bottom" title="Change Status"></i>
											</a>

										<form id="deletefrm_{{$vendor_store->id}}" action="{{ route('supplier_store.destroy', $vendor_store->id) }}" method="POST" class="delete"  onsubmit="return confirm('Are you sure?');">
											@csrf
											@method('DELETE')
										</form>
									</td>
								</tr>
							@endforeach
						</tbody>
						<tfoot>
							<tr>
								<th >#</th>
								<th >Branch Admin</th>
								<th>Supplier</th>
								<th >Name</th>
								<th >Phone No</th>
								<th >Email</th>
								<th >Action</th>
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
				<form method="post" action="{{ url('admin/supplier_store/import-store') }}" enctype="multipart/form-data">
					@csrf
					<div class="form-group">
						<label for="input-1">Supplier<span class="text-danger">*</span></label>
						<select name="vendor" class="form-control" id="vendor">
                                <option value="">Select Supplier</option>
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
	var table = $('#example').DataTable( {
		lengthChange: false,
				buttons: [
			{
				extend: 'copy',
				title: 'Store List',
				exportOptions: {
				columns: [ 0, 1, 2, 3, 4, 5]
				}
			},
			{
				extend: 'excelHtml5',
				title: 'Store List',
				exportOptions: {
				columns: [ 0, 1, 2, 3, 4, 5]
				}
			},
			{
				extend: 'pdfHtml5',
				title: 'Store List',
				exportOptions: {
				columns: [ 0, 1, 2, 3, 4, 5]
				}
			},
			{
				extend: 'print',
				title: 'Store List',
				autoPrint: true,
				exportOptions: {
				columns: [ 0, 1, 2, 3, 4, 5]
				}
			},
			'colvis'
		],
		//columnDefs: [
			//{ "orderable": false, "targets": 6 }
		//]
		columnDefs: [
            { width: "4%", targets: 0 },
            { width: "17%", targets: 1 },
            { width: "14%", targets: 2 },
            { width: "15%", targets: 3 },
            { width: "14%", targets: 4 },
            { width: "23%", targets: 5 },
            { width: "13%","orderable": false, targets: 6 },
        ],
        fixedColumns: true
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
        url: "{{ url('admin/supplier_store') }}/"+id,
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

