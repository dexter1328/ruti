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
				<div class="left"><!-- <i class="fa fa-picture-o"></i> --> <span>Banners</span></div>
				<div class="float-sm-right">    
					<a style="padding-bottom: 3px; padding-top: 4px;" href="{{ route('banners.create') }}" class="btn btn-outline-primary btn-sm waves-effect waves-light m-1" title="Add Banner">
						<!-- <i class="fa fa-picture-o" style="font-size:15px;"></i> --> <span class="name">Add Banner</span>
					</a>
				</div>
			</div>
			<div class="card-body">
				<div class="table-responsive">
					<table id="example" class="table table-bordered">
						<thead>
							<tr>
								<th>#</th>
								<th>Title</th>
								<th>Position</th>
								<th style="display:none;">Image</th>
								<th>Image</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
							@foreach($banners as $key => $banner)
								<tr>
									<td>{{$key+1}}</td>
									<td>{{$banner->banner_title}}</td>
									<td>{{$banner->position}}</td>
									<td style="display:none;">{{asset('public/images/banners').'/'.$banner->image}}</td>
									@if($banner->image)
										<td align="center"><img src="{{asset('public/images/banners').'/'.$banner->image}}"  width="100" height="auto"></td>
									@else
										<td><img src="{{asset('public/images/no-image.jpg')}}" width="50" height="50"></td>
									@endif
									<td class="action">
									<form id="deletefrm_{{$banner->id}}" action="{{ route('banners.destroy', $banner->id) }}" method="POST" class="delete"  onsubmit="return confirm('Are you sure?');">
									@csrf
									@method('DELETE')
									<a href="{{ route('banners.edit', $banner->id) }}" class="edit" data-toggle="tooltip" data-placement="bottom" title="Edit Banner">
									<i class="icon-note icons"></i>
									</a>
									<a href="javascript:void(0);" onclick="deleteRow('{{$banner->id}}')" data-toggle="tooltip" data-placement="bottom" title="Delete Banner"><i class="icon-trash icons"></i></a>

									<a href="javascript:void(0);" onclick="changeStatus('{{$banner->id}}')" >
									 	<i class="fa fa-circle status_{{$banner->id}}" style="@if($banner->status=='active')color:#009933;@else color: #ff0000;@endif" id="active_{{$banner->id}}" data-toggle="tooltip" data-placement="bottom" title="Change Status"></i>
									</a>

									</form>
									</td>
								</tr>
							@endforeach
						</tbody>
						<tfoot>
							<tr>
								<th>#</th>
								<th>Title</th>
								<th>Position</th>
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
</div>
<script>
$(document).ready(function() {
	var table = $('#example').DataTable( {
		lengthChange: false,
		buttons: [
			{
				extend: 'copy',
				title: 'Banner List',
				exportOptions: {
				columns: [ 0, 1, 2, 3, 4]
				}
			},
			{
				extend: 'excelHtml5',
				title: 'Banner List',
				exportOptions: {
				columns: [ 0, 1, 2, 3, 4]
				}
			},
			{
				extend: 'pdfHtml5',
				title: 'Banner List',
				exportOptions: {
				columns: [ 0, 1, 2, 3, 4]
				}
			},
			{
				extend: 'print',
				title: 'Banner List',
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
        url: "{{ url('admin/banners') }}/"+id,
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
            suc_str +='<div class="alert-message"><span><strong>Success!</strong> Banner has been '+status+'.</span></div>';
            suc_str +='</div>';
            $('.success-alert').html(suc_str);
        },
        error: function (data) {
        }
    });
}
</script>
@endsection
