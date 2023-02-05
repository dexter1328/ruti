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
<div class="success-alert" style="display:none;"></div>
<div class="row">
	<div class="col-lg-12">
		<div class="card">
			<div class="card-header">
				<div class="left"><!-- <i class="fa fa-tags"></i> --><span>Brands</span></div>
				<div class="float-sm-right">        
					<a style="padding-bottom: 3px; padding-top: 4px;" href="{{ route('brand.create') }}" class="btn btn-outline-primary btn-sm waves-effect waves-light m-1" title="Add Brand">
						<!-- <i class="fa fa-tags" style="font-size:15px;"></i> --> <span class="name">Add Brand</span>
					</a>
				</div>
			</div>
			<div class="card-body">
				<div class="table-responsive">
					<table id="example" class="table table-bordered">
						<thead>
							<tr>
								<th>#</th>
								<th>Vendor</th>
								<th>Store</th>
								<th>Name</th>
								<th style="display:none;">Image</th>
								<th>Image</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
							@foreach($brands as $key=> $brand)
								<tr>
									<td>{{$key+1}}</td>
									<td>{{$brand->vendor}}</td>
									<td>{{$brand->store}}</td>
									<td>{{$brand->name}}</td>
									<td style="display:none;">{{asset('public/images/brands').'/'.$brand->image}}</td>
									@if($brand->image)
										<td><img src="{{asset('public/images/brands').'/'.$brand->image}}" width="50" height="50"></td>
									@else
										<td><img src="{{asset('public/images/no-image.jpg')}}" width="50" height="50"></td>
									@endif
									<td class="action">
										<form id="deletefrm_{{$brand->id}}" action="{{ route('brand.destroy', $brand->id) }}" method="POST" class="delete"  onsubmit="return confirm('Are you sure?');">
											@csrf
											@method('DELETE')
											<a href="{{ route('brand.edit', $brand->id) }}" class="edit" data-toggle="tooltip" data-placement="bottom" title="Edit Brand">
											  <i class="icon-note icons"></i>
											</a>
											<a href="javascript:void(0);" onclick="deleteRow('{{$brand->id}}')" data-toggle="tooltip" data-placement="bottom" title="Delete Brand"><i class="icon-trash icons"></i></a>

											<a href="javascript:void(0);" onclick="changeStatus('{{$brand->id}}')" >
											 	<i class="fa fa-circle status_{{$brand->id}}" style="@if($brand->status=='enable')color:#009933;@else color: #ff0000;@endif" id="active_{{$brand->id}}" data-toggle="tooltip" data-placement="bottom" title="Change Status"></i>
											</a>	
										</form>
									</td>
								</tr>
							@endforeach
						</tbody>
						<tfoot>
							<tr>
								<th>#</th>
								<th>Vendor</th>
								<th>Store</th>
								<th>Name</th>
								<th style="display:none;">Image</th>
								<th>Image</th>
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
$(document).ready(function() {
	var table = $('#example').DataTable( {
		lengthChange: false,
		buttons: [
			{
				extend: 'copy',
				title: 'Brand List',
				exportOptions: {
				columns: [ 0, 1,2,3,4,5]
				}
			},
			{
				extend: 'excelHtml5',
				title: 'Brand List',
				exportOptions: {
				columns: [ 0, 1, 2,3,4,5]
				}
			},
			{
				extend: 'pdfHtml5',
				title: 'Brand List',
				exportOptions: {
				columns: [ 0, 1, 2,3,4,5]
				}
			},
			{
				extend: 'print',
				title: 'Brand List',
				autoPrint: true,
				exportOptions: {
				columns: [ 0, 1, 2,3,4,5]
				}
			},
			'colvis'
		],
		//columnDefs: [
			//{ "orderable": false, "targets": 6 }
		//]
		columnDefs: [
            { width: "5%", targets: 0 },
            { width: "20%", targets: 1 },
            { width: "20%", targets: 2 },
            { width: "20%", targets: 3 },
            { width: "20%", targets: 4 },
            { width: "15%", "orderable": false,targets: 5 },
        ],
        fixedColumns: true
		});
	
	table.buttons().container()
	.appendTo( '#example_wrapper .col-md-6:eq(0)' );
});

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
        url: "{{ url('admin/brand') }}/"+id,
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
			suc_str +='<div class="alert-message"><span><strong>Success!</strong> Brand has been '+status+'.</span></div>';
			suc_str +='</div>';
			$('.success-alert').html(suc_str);
        },
        error: function (data) {
        }
    });
}
</script>
@endsection

