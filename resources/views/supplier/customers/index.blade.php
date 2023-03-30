@extends('supplier.layout.main')
@section('content')
<style>
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

@if(isset($vendor_paid_module->status) && $vendor_paid_module->status == 'yes')
<style>
	.dt-buttons.btn-group{
		display: block;
	}
</style>
@else
<style>
	.dt-buttons.btn-group{
		display: none;
	}
</style>
@endif
<div class="success-alert" style="display:none;"></div>
<div class="row">
	<div class="col-lg-12">
		<div class="card">
			<div class="card-header">
				<div class="left">
					<span>Customers</span>
				</div>
				@php /* @endphp
				<div class="float-sm-right">
					<a style="padding-bottom: 3px; padding-top: 4px;" href="{{ route('supplier.customer.create') }}" class="btn btn-outline-primary btn-sm waves-effect waves-light m-1" title="Add Customer">
						<span class="name">Add Customer</span>
					</a>
				</div>
				@php */ @endphp
			</div>
			<div class="card-body">
				<div class="table-responsive">
					<table id="example" class="table table-bordered">
						<thead>
							<tr>
								<th>#</th>
								<th>Name</th>
								@if(isset($vendor_paid_module->status) && $vendor_paid_module->status == 'yes')
									<th>E-mail</th>
									<th>Mobile</th>
								@endif
								<th>DOB</th>
								<th>Total Orders</th>
							</tr>
						</thead>
						<tbody>
							@if($customers->isNotEmpty())
							@foreach($customers as $key=> $customer)
								<tr>
									<td>{{$key+1}}</td>
									<td><a href="{{ url('supplier/customer/view',$customer->user_id)}}" >{{$customer->first_name}}</a></td>
									@if(isset($vendor_paid_module->status) && $vendor_paid_module->status == 'yes')
										<td>{{$customer->email}}</td>
										<td>{{$customer->mobile}}</td>
									@endif
									<td>{{ $customer->dob ? date('d-m-Y', strtotime($customer->dob)) : '-' }}</td>

									<td><a href="JavaScript:void(0);" onclick="viewOrders({{$customer->id}})">{{$customer->supply_orders_count}} Orders </a></td>
									@php /* @endphp
									@if(isset($vendor_paid_module->status) && $vendor_paid_module->status == 'yes')
									<td class="action">
										<form id="deletefrm_{{$customer->user_id}}" action="{{ route('supplier.customer.destroy', $customer->user_id) }}" method="POST" class="delete"  onsubmit="return confirm('Are you sure?');">
											@csrf
											@method('DELETE')
											<a href="{{ route('supplier.customer.edit', $customer->user_id) }}" class="edit" data-toggle="tooltip" data-placement="bottom" title="Edit">
												<i class="icon-note icons"></i>
											</a>
											<a href="javascript:void(0);" onclick="deleteRow('{{$customer->user_id}}')" data-toggle="tooltip" data-placement="bottom" title="Delete"><i class="icon-trash icons"></i></a>
											<a href="javascript:void(0);" onclick="changeStatus('{{$customer->user_id}}')" >
									 			<i class="fa fa-circle status_{{$customer->user_id}}" style="@if($customer->status=='active')color:#009933;@else color: #ff0000;@endif" id="active_{{$customer->user_id}}" data-toggle="tooltip" data-placement="bottom" title="Status"></i>
											</a>
										</form>
									</td>
									@endif
									@php */ @endphp
								</tr>
							@endforeach
							@endif
						</tbody>
						<tfoot>
							<tr>
								<th>#</th>
								<th>Name</th>
								@if(isset($vendor_paid_module->status) && $vendor_paid_module->status == 'yes')
									<th>E-mail</th>
									<th>Mobile</th>
								@endif
								<th>DOB</th>
								<th>Total Orders</th>
								@php /* @endphp
								@if(isset($vendor_paid_module->status) && $vendor_paid_module->status == 'yes')
								<th>Action</th>
								@endif
								@php */ @endphp
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
                  	</thead>
                    <tbody class="discount_bookings">

                    </tbody>
              	</table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
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
				title: 'Customer List',
				exportOptions: {
				columns: [ 0, 1,2,3,4]
				}
			},
			{
				extend: 'excelHtml5',
				title: 'Customer List',
				exportOptions: {
				columns: [ 0, 1, 2,3,4]
				}
			},
			{
				extend: 'pdfHtml5',
				title: 'Customer List',
				exportOptions: {
				columns: [ 0, 1, 2,3,4]
				}
			},
			{
				extend: 'print',
				title: 'Customer List',
				autoPrint: true,
				exportOptions: {
				columns: [ 0, 1, 2,3,4]
				}
			},
			'colvis'
		],
		/*columnDefs: [
			{ "orderable": false, "targets": 5 }
		]*/
	} );
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
        url: "{{ url('supplier/customer/customer-status') }}/"+id,
        type: "GET",
        dataType: 'json',
        success: function (data) {
            var status = '';
            // $('.status_'+id).attr('title',data);
            if(data == 'active'){
            	status = 'activated';
                $('.status_'+id).css('color','#009933');
            }else{
            	status = 'deactived';
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

function viewOrders(id)
{

	$('#order-list').DataTable().destroy();
	var html ='';
    $.ajax({
       	url:'{{ url("supplier/customer") }}/'+id,
        type: "GET",
        dataType: 'html',
        success: function (data) {
            var modal_data = $.parseJSON(data);
            $("#orderListModal").modal("show");
            $.each(modal_data, function( key, value ) {
            	var url = '{{ url("supplier/orders/view_order") }}/'+value.id;
                html += '<tr>' +
                    '<td>'+String(value.w2b_order.order_id).toUpperCase()+'</td>' +
                    '<td>'+value.w2b_order.created_at+'</td>' +
                    '<td>' +
                        '<a href="'+url+'">' +
                            '<i class="icon-eye icons" data-toggle="tooltip" data-placement="bottom" title="View Order"></i>' +
                        '</a>' +
                    '</td>' +
                '</tr>';

            });
			$('#orderListModal .discount_bookings').html(html);
			$('#order-list').DataTable();
        },
        error: function (data) {
        }
    });
}
</script>
@endsection

