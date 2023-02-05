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
				<div class="left"><!-- <i class="fa fa-file"></i> --> <span>Pages</span></div>
				<div class="float-sm-right">    
					<a style="padding-bottom: 3px; padding-top: 4px;" href="{{ route('pages.create') }}" class="btn btn-outline-primary btn-sm waves-effect waves-light m-1" title="Add Page">
						<!-- <i class="fa fa-file" style="font-size:15px;"></i> --> <span class="name">Add Page</span>
					</a>
				</div>
			</div>
			<div class="card-body">
				<div class="table-responsive">
					<table id="example" class="table table-bordered">
						<thead>
							<tr>
								<th>#</th>
								<th>Page</th>
								<th style="display: none;">Image</th>
								<th>Image</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
							@foreach($pages as $key => $page)
								<tr>
									<td>{{$key+1}}</td>
									<td>{{$page->title}}</td>
									<td style="display: none;">{{asset('public/images/page').'/'.$page->image}}</td>
                                    <td align="center"><img src="{{asset('public/images/page').'/'.$page->image}}" width="100" height="auto"></td>
									<td class="action">
									<form id="deletefrm_{{$page->id}}" action="{{ route('pages.destroy', $page->id) }}" method="POST" class="delete"  onsubmit="return confirm('Are you sure?');">
									@csrf
									@method('DELETE')
									<a href="{{ route('pages.edit', $page->id) }}" class="edit" data-toggle="tooltip" data-placement="bottom" title="Edit Page">
									<i class="icon-note icons"></i>
									</a>

									<a href="javascript:void(0);" onclick="deleteRow('{{$page->id}}')" data-toggle="tooltip" data-placement="bottom" title="Delete Page"><i class="icon-trash icons"></i></a>

								    <a href="javascript:void(0);" onclick="changeStatus('{{$page->id}}')" ><i class="fa fa-circle status_{{$page->id}}" style="@if($page->status=='active')color:#009933;@else color: #ff0000;@endif" id="active_{{$page->id}}" data-toggle="tooltip" data-placement="bottom" title="Change Status"></i></a>

									</form>
									</td>
								</tr>
							@endforeach
						</tbody>
						<tfoot>
							<tr>
								<th>#</th>
								<th>Page</th>
								<th style="display: none;">Image</th>
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
				title: 'page List',
				exportOptions: {
				columns: [ 0, 1, 2, 3]
				}
			},
			{
				extend: 'excelHtml5',
				title: 'page List',
				exportOptions: {
				columns: [ 0, 1, 2, 3]
				}
			},
			{
				extend: 'pdfHtml5',
				title: 'page List',
				exportOptions: {
				columns: [ 0, 1, 2, 3]
				}
			},
			{
				extend: 'print',
				title: 'page List',
				autoPrint: true,
				exportOptions: {
				columns: [ 0, 1, 2, 3]
				}
			},
			'colvis'
		],
		columnDefs: [
        { "orderable": false, "targets": 4 }
      ]
	} );

	table.buttons().container()
	.appendTo( '#example_wrapper .col-md-6:eq(0)' );

} );
function deleteRow(id){   
	$('#deletefrm_'+id).submit();
}

function changeStatus(id) {
    $.ajax({
        data: {
        "_token": "{{ csrf_token() }}",
        "id": id
        },
        url: "{{ url('admin/pages') }}/"+id,
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
            suc_str +='<div class="alert-message"><span><strong>Success!</strong> Page has been '+status+'.</span></div>';
            suc_str +='</div>';
            $('.success-alert').html(suc_str);
        },
        error: function (data) {
        }
    });
}
    
</script>
@endsection
