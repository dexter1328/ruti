@extends('supplier.layout.main')
@section('content')
<style type="text/css">
	div#myModal {
	    width: 50%;
	    margin: auto;
	}
	.schedule-booking .row {
	    width: 100%;
	    margin: auto;
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
<div class="success-alert" style="display:none;"></div>
<div class="row">
	<div class="col-lg-12">
		<div class="card">
			<div class="card-header">
				<div class="left"><span>Supplier Coupons</span></div>
				<div class="float-sm-right">
					<a style="padding-bottom: 3px; padding-top: 4px;" href="{{ route('supplier.supplier_coupons.create') }}" class="btn btn-outline-primary btn-sm waves-effect waves-light m-1" title="Add Coupon">
							<span class="name">Add Coupon</span>
						</a>
				</div>
			</div>
			<div class="card-body">
				<div class="table-responsive">
					<table id="example" class="table table-bordered">
						<thead>
							<tr>
								<th>#</th>
								<th>Supplier</th>
								<th>Store</th>
								<th>Coupon Code</th>
								<th>Type</th>
								<th>Discount</th>
								<th>Verified</th>
								<th>Used Coupon</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
							@foreach($vendor_coupans as $key=> $vendor_coupan)
								<tr>
									<td>{{$key+1}}</td>
									<td>{{$vendor_coupan->owner_name}}</td>
									<td>{{$vendor_coupan->store_name}}</td>
									<td>{{$vendor_coupan->coupon_code}}</td>
									<td>{{$vendor_coupan->type}}</td>
									<td>{{$vendor_coupan->discount}}</td>
									<td>@if($vendor_coupan->coupon_status == 'unverified')No @else Yes @endif</td>
									@if($vendor_coupan->count_used_coupon != 0)
                                    	<td><a href="JavaScript:void(0);" onclick="viewUsedCoupon('{{$vendor_coupan->id}}')">							{{$vendor_coupan->count_used_coupon}} Order </a>
                                    	</td>
                                	@else
                                    	<td>−</td>
                                	@endif

										<td class="action">
											<form id="deletefrm_{{$vendor_coupan->id}}" action="{{ route('supplier.supplier_coupons.destroy', $vendor_coupan->id) }}" method="POST" class="delete"  onsubmit="return confirm('Are you sure?');">
											@csrf
											@method('DELETE')
											<!-- <a href="{{ route('supplier.supplier_coupons.edit', $vendor_coupan->id) }}" class="edit" data-toggle="tooltip" data-placement="bottom" title="Edit Coupon">
											<i class="icon-note icons"></i>
											</a> -->
											<a href="javascript:void(0);" onclick="deleteRow('{{$vendor_coupan->id}}')" data-toggle="tooltip" data-placement="bottom" title="Delete Coupon"><i class="icon-trash icons"></i></a>
											<!-- <a href="javascript:void(0);" onclick="changeStatus('{{$vendor_coupan->id}}')" >
									 			<i class="fa fa-circle status_{{$vendor_coupan->id}}" style="@if($vendor_coupan->status=='enable')color:#009933;@else color: #ff0000;@endif" id="enable_{{$vendor_coupan->id}}" data-toggle="tooltip" data-placement="bottom" title="Status"></i>
											</a> -->
											</form>
										</td>

								</tr>
							@endforeach
						</tbody>
						<tfoot>
							<tr>
								<th>#</th>
								<th>Supplier</th>
								<th>Store</th>
								<th>Coupon Code</th>
								<th>Type</th>
								<th>Discount</th>
								<th>Verified</th>
								<th>Used Coupon</th>
								<th>Action</th>

							</tr>
						</tfoot>
					</table>
				</div>
			</div>
		</div>
	</div>
</div><!-- End Row-->

<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content schedule-booking">
            <div class="modal-header">
                <div class="row">
                    <div class="col-sm-6"><h5 class="modal-title">Orders</h5></div>
                    <div class="col-sm-6"><button type="button" class="close" data-dismiss="modal">&times;</button></div>
                </div>
            </div>
            <div class="modal-body" id="assign-modal">
              <table class="table table-bordered table-striped" id="discount_code_table" style="width:100%;">
                  <thead>
                      <tr>
                            <td>Customer</td>
                      </tr>
                      <tbody class="discount_bookings">

                      </tbody>
                  </thead>
              </table>

            </div>
            <div class="modal-footer">
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
				title: 'Coupon List',
				exportOptions: {
				columns: [ 0, 1, 2, 3, 4, 5, 6, 7]
				}
			},
			{
				extend: 'excelHtml5',
				title: 'Coupon List',
				exportOptions: {
				columns: [ 0, 1, 2, 3, 4, 5, 6, 7]
				}
			},
			{
				extend: 'pdfHtml5',
				title: 'Coupon List',
				exportOptions: {
				columns: [ 0, 1, 2, 3, 4, 5, 6, 7]
				}
			},
			{
				extend: 'print',
				title: 'Coupon List',
				autoPrint: true,
				exportOptions: {
				columns: [ 0, 1, 2, 3, 4, 5, 6, 7]
				}
			},
			'colvis'
		],
		columnDefs: [
			{ "orderable": false, "targets": 8 }
		]
	});

	table.buttons().container()
	.appendTo( '#example_wrapper .col-md-6:eq(0)' );

} );

function viewUsedCoupon(id)
{
    $.ajax({
        url: "{{url('supplier/supplier_coupons/view_used_coupon')}}/"+id,
        type: "GET",
        dataType: 'html',
        success: function (data) {
            var modal_data = $.parseJSON(data);
            $('#myModal').modal('show');
            $("#discount_code_table").dataTable().fnDestroy();
            var html ='';
            $.each(modal_data, function( key, value ) {
                html += '<tr><td>'+value.first_name+' '+value.last_name+'</td></tr>';
            });
            $('#myModal .discount_bookings').html(html);
            $('#discount_code_table').DataTable({
                'paging'      : true,
                'lengthChange': true,
                'searching'   : true,
                'ordering'    : true,
                'info'        : true,
            });
        },
        error: function (data) {
        }
    });
}
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
        url: "{{ url('supplier/supplier_coupons') }}/"+id,
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
            suc_str +='<div class="alert-message"><span><strong>Success!</strong> Coupon has been '+status+'.</span></div>';
            suc_str +='</div>';
            $('.success-alert').html(suc_str);
        },
        error: function (data) {
        }
    });
}
</script>
@endsection

