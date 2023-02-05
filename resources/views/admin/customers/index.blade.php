@extends('admin.layout.main')
@section('content')
<style type="text/css">
.modal-dialog{
    overflow-y: initial !important
}
.modal-body{
    height: 450px;
    overflow-y: auto;
}
.schedule-booking .row {
	    width: 100%;
	    margin: auto;
}
div#myModal {
	    width: 50%;
	    margin: auto;
	}
</style>
<div class="success-alert" style="display:none;"></div>
<div class="row">
	<div class="col-lg-12">
		<div class="card">
			<div class="card-header">
				<div class="left">
					<!-- <i class="fa fa-users"></i> --><span>Customers</span>
				</div>
				<div class="float-sm-right">        
					<a style="padding-bottom: 3px; padding-top: 4px;" href="{{ route('customer.create') }}" class="btn btn-outline-primary btn-sm waves-effect waves-light m-1" title="Add Customer">
						<!-- <i class="fa fa-users" style="font-size:15px;"></i> --> <span class="name">Add Customer</span>
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
								<th>E-mail</th>
								<th>Mobile</th>
								<th>DOB</th>
								<th>Total Orders</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
							@foreach($customers as $key=> $customer)
								<tr>
									<td>{{$key+1}}</td>
									<td><a href="{{ url('/admin/customer/view',$customer->user_id)}}" >{{$customer->first_name}}</a></td>
									<td>{{$customer->email}}</td>
									<td>{{$customer->mobile}}</td>
									<td>{{ $customer->dob ? date('d-m-Y', strtotime($customer->dob)) : '-' }}</td>
									<td><a href="JavaScript:void(0);" onclick="viewOrders({{$customer->user_id}})">{{$customer->count}} Orders </a></td>
									<td class="action">
									<form id="deletefrm_{{$customer->user_id}}" action="{{ route('customer.destroy', $customer->user_id) }}" method="POST" class="delete"  onsubmit="return confirm('Are you sure?');">
									@csrf
									@method('DELETE')
									<a href="{{ route('customer.edit', $customer->user_id) }}" class="edit" data-toggle="tooltip" data-placement="bottom" title="Edit Customer">
									<i class="icon-note icons"></i>
									</a>
									<a href="javascript:void(0);" onclick="deleteRow('{{$customer->user_id}}')" data-toggle="tooltip" data-placement="bottom" title="Delete Customer"><i class="icon-trash icons"></i></a>

									<!-- <a href="javascript:void(0);" onclick="changeStatus('{{$customer->user_id}}')" >
									 	<i class="fa fa-circle status_{{$customer->user_id}}" style="@if($customer->status=='active')color:#009933;@else color: #ff0000;@endif" id="active_{{$customer->user_id}}" title="{{$customer->status}}"></i>
									</a> -->
									
									</form>
									</td>
								</tr>
							@endforeach
						</tbody>
						<tfoot>
							<tr>
								<th>#</th>
								<th>Name</th>
								<th>E-mail</th>
								<th>Mobile</th>
								<th>DOB</th>
								<th>Total Orders</th>
								<th>Action</th>
							</tr>
						</tfoot>
					</table>
				</div>
			</div>
		</div>
	</div>
</div><!-- End Row-->

<div class="modal fade" id="orderListModal" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content schedule-booking" style="width: 56%;margin-left: 303px;">
            <div class="modal-header" style="margin-left:15px;">
                <div class="row">
                    <div class="col-sm-6"><h5 class="modal-title">Orders</h5></div>
                    <div class="col-sm-6"><button type="button" class="close" data-dismiss="modal">&times;</button></div>
                </div>
            </div>
            <div class="modal-body" id="assign-modal">
              	<table id="order-list" class="table table-striped">
                  	<thead>
                      	<tr>
                            <td>Order No</td>
                            <td>Date</td>
                            <td>View</td>
                      	</tr>
                      	<tbody class="discount_bookings">
                          
                      	</tbody>
                  	</thead>
              	</table>
            </div>
           <!--  <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div> -->
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
				title: 'Customer List',
				exportOptions: {
				columns: [ 0, 1,2,3,4,5]
				}
			},
			{
				extend: 'excelHtml5',
				title: 'Customer List',
				exportOptions: {
				columns: [ 0, 1, 2,3,4,5]
				}
			},
			{
				extend: 'pdfHtml5',
				title: 'Customer List',
				exportOptions: {
				columns: [ 0, 1, 2,3,4,5]
				}
			},
			{
				extend: 'print',
				title: 'Customer List',
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
            { width: "15%", targets: 2 },
            { width: "15%", targets: 3 },
            { width: "15%", targets: 4 },
            { width: "15%", targets: 5 },
            { width: "15%", "orderable": false,targets: 6 },
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

function viewOrders(id)
{
	$('#order-list').DataTable().destroy();
	var html ='';
    $.ajax({
       	url:'{{ url("admin/customer") }}/'+id,
        type: "GET",
        dataType: 'html',
        success: function (data) {
            var modal_data = $.parseJSON(data);
            $("#orderListModal").modal("show");
            $.each(modal_data, function( key, value ) {
            	var url = '{{ url("admin/orders") }}/'+value.id;
                html += '<tr><td>'+value.order_no+'</td><td>'+value.created_at+'</td><td><a href="'+url+'"><i class="icon-eye icons" data-toggle="tooltip" data-placement="bottom" title="View Order"></i></a></td></tr>';

            });
			$('#orderListModal .discount_bookings').html(html);
			$('#order-list').DataTable();
        },
        error: function (data) {
        }
    });
}

function changeStatus(id) {
    $.ajax({
        data: {
        "_token": "{{ csrf_token() }}",
        "id": id
        },
        url: "{{ url('admin/customer/customer-status') }}/"+id,
        type: "GET",
        dataType: 'json',
        success: function (data) {
			var status = '';
            $('.status_'+id).attr('title',data);
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
			suc_str +='<div class="alert-message"><span><strong>Success!</strong> Customer has been '+status+'.</span></div>';
			suc_str +='</div>';
			$('.success-alert').html(suc_str);
        },
        error: function (data) {
        }
    });
}
</script>
@endsection

