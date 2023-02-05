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
				<div class="left"><!-- <i class="fa fa-group"></i> --><span>{{ucfirst($type)}} Memberships</span></div>
				<div class="float-sm-right">    
					@php /* @endphp    
					<a style="padding-bottom: 3px; padding-top: 4px;" href="{{ route('membership.create', $type) }}" class="btn btn-outline-primary btn-sm waves-effect waves-light m-1" title="Add Membership">
						<!-- <i class="fa fa-group" style="font-size: 15px;"></i> --> <span class="name">Add Membership</span>
					@php */ @endphp    
					</a>
				</div>
			</div>
			<div class="card-body">
				<div class="table-responsive">
					<table id="example" class="table table-bordered">
						<thead>
							<tr>
								<th>#</th>
								<th>Name</th>
								<th>Price</th>
								<th class="text-center">Action</th>
							</tr>
						</thead>
						<tbody>
							@foreach($memberships as  $key=> $membership)
								<tr>
									<td>{{$key+1}}</td>
									<td>{{$membership->name}}</td>
									<td>${{$membership->price?:0}}</td>
									<td class="action">
										<a href="{{ route('membership.edit', $membership->id) }}" class="edit" data-toggle="tooltip" data-placement="bottom" title="Edit Membership">
											<i class="icon-note icons"></i>
										</a>
										@php /* @endphp
										<form id="deletefrm_{{$membership->id}}" action="{{ route('membership.destroy', $membership->id) }}" method="POST" class="delete"  onsubmit="return confirm('Are you sure?');">
											@csrf
											@method('DELETE')
											<a href="{{ route('membership.edit', $membership->id) }}" class="edit" data-toggle="tooltip" data-placement="bottom" title="Edit Membership">
												<i class="icon-note icons"></i>
											</a>
											<a href="javascript:void(0);" onclick="deleteRow('{{$membership->id}}')" data-toggle="tooltip" data-placement="bottom" title="Delete Membership">
												<i class="icon-trash icons"></i>
											</a>

											<a href="javascript:void(0);" onclick="changeStatus('{{$membership->id}}')" >
											 	<i class="fa fa-circle status_{{$membership->id}}" style="@if($membership->status=='active')color:#009933;@else color: #ff0000;@endif" id="active_{{$membership->id}}" data-toggle="tooltip" data-placement="bottom" title="Change Status"></i>
											</a>
										</form>
										@php */ @endphp
									</td>
								</tr>
							@endforeach
						</tbody>
						<tfoot>
							<tr>
								<th>#</th>
								<th>Name</th>
								<th>Price</th>
								<th class="text-center">Action</th>
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
				title: 'Membership List',
				exportOptions: {
				columns: [ 0, 1, 2]
				}
			},
			{
				extend: 'excelHtml5',
				title: 'Membership List',
				exportOptions: {
				columns: [ 0, 1, 2]
				}
			},
			{
				extend: 'pdfHtml5',
				title: 'Membership List',
				exportOptions: {
				columns: [ 0, 1, 2]
				}
			},
			{
				extend: 'print',
				title: 'Membership List',
				autoPrint: true,
				exportOptions: {
				columns: [ 0, 1, 2]
				}
			},
			'colvis'
		],
		columnDefs: [
			{ "orderable": false, "targets": 3}
		]
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
        url: "{{ url('admin/membership') }}/"+id,
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
            suc_str +='<div class="alert-message"><span><strong>Success!</strong> Membership has been '+status+'.</span></div>';
            suc_str +='</div>';
            $('.success-alert').html(suc_str);
        },
        error: function (data) {
        }
    });
}
</script>
@endsection

