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
				<div class="left"><!-- <i class="fa fa-trophy"></i> --><span>Reward Points</span></div>
				<div class="float-sm-right">
					<a style="padding-bottom: 3px; padding-top: 4px;" href="{{ route('reward_points.create') }}" class="btn btn-outline-primary btn-sm waves-effect waves-light m-1" title="Add Reward Point"> <!-- <i class="fa fa-trophy" style="font-size: 15px;"></i> --> <span class="name">Add Reward Point</span>
					</a>
				</div>
			</div>
			<div class="card-body">
				<div class="table-responsive">
					<table id="example" class="table table-bordered">
						<thead>
							<tr>
								<th>#</th>
								<th>Type</th>
								<th>Reward Points</th>
								<th>Exchange Rate/$1</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
							@foreach($reward_points as $key => $reward_point)
								<tr>
									<td>{{$key+1}}</td>
									<td>{{ucfirst($reward_point->reward_type)}}</td>
									<td>
										{{$reward_point->reward_points}}
										@if($reward_point->reward_type == 'invite')
											Gem
										@elseif($reward_point->reward_type == 'transaction')
											Coin
										@endif
									</td>
									<td>
										{{$reward_point->reward_point_exchange_rate}}
										(Value of
										@if($reward_point->reward_type == 'invite')
											Gem
										@elseif($reward_point->reward_type == 'transaction')
											Coin
										@endif
										${{$reward_point->reward_points/$reward_point->reward_point_exchange_rate}})
									</td>
									<td class="action">
										<form id="deletefrm_{{$reward_point->id}}" action="{{ route('reward_points.destroy', $reward_point->id) }}" method="POST" class="delete"  onsubmit="return confirm('Are you sure?');">
											@csrf
											@method('DELETE')
											<a href="{{ route('reward_points.edit', $reward_point->id) }}" class="edit" data-toggle="tooltip" data-placement="bottom" title="Edit RewardPoint">
												<i class="icon-note icons"></i>
											</a>
											<a href="javascript:void(0);" onclick="deleteRow('{{$reward_point->id}}')" data-toggle="tooltip" data-placement="bottom" title="Delete RewardPoint"><i class="icon-trash icons"></i></a>
											<a href="javascript:void(0);" onclick="changeStatus('{{$reward_point->id}}')" >
											 	<i class="fa fa-circle status_{{$reward_point->id}}" style="@if($reward_point->status=='active')color:#009933;@else color: #ff0000;@endif" id="active_{{$reward_point->id}}" data-toggle="tooltip" data-placement="bottom" title="Change Status"></i>
											</a>
										</form>
									</td>
								</tr>
							@endforeach
						</tbody>
						<tfoot>
							<tr>
								<th>#</th>
								<th>Type</th>
								<th>Reward Points</th>
								<th>Exchange Rate/$1</th>
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
				title: 'reward_point-list',
				exportOptions: {
				columns: [ 0, 1, 2]
				}
			},
			{
				extend: 'excelHtml5',
				title: 'reward_point-list',
				exportOptions: {
				columns: [ 0, 1, 2]
				}
			},
			{
				extend: 'pdfHtml5',
				title: 'reward_point-list',
				exportOptions: {
				columns: [ 0, 1, 2]
				}
			},
			{
				extend: 'print',
				title: 'reward_point-list',
				autoPrint: true,
				exportOptions: {
				columns: [ 0, 1, 2]
				}
			},
			'colvis'
		],
		columnDefs: [
			{ "orderable": false, "targets": 3 }
		]
	} );

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
        url: "{{ url('admin/reward_points') }}/"+id,
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
            suc_str +='<div class="alert-message"><span><strong>Success!</strong> Reward Point has been '+status+'.</span></div>';
            suc_str +='</div>';
            $('.success-alert').html(suc_str);
        },
        error: function (data) {
        }
    });
}
</script>
@endsection

