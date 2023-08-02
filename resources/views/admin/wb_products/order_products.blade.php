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
				<div class="left"><!-- <i class="fa fa-group"></i> --><span>Ordered Products</span></div>
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
					<table id="examplewbp" class="table table-bordered">
						<thead>
							<tr>
								<th>#</th>
								<th >Product SKU</th>
								<th>Title</th>
								<th>Price</th>
								<th>Quantity</th>
								<th>Total Price(Incl. Taxes)</th>
							</tr>
						</thead>
						<tbody>
                            @foreach($products as  $key=> $product)

								<tr>
									<td>{{$loop->iteration}}</td>
									<td>{{$product->sku}}</td>
									<td>{{$product->title}}</td>
									<td>{{$product->price}}</td>
									<td>{{$product->quantity}}</td>
									<td>{{$product->total_price}}</td>

								</tr>
                                @endforeach
						</tbody>
						<tfoot>
							<tr>
								<th>#</th>
								<th >Product SKU</th>
								<th>Title</th>
								<th>Price</th>
								<th>Quantity</th>
								<th>Total Price(Incl. Taxes)</th>
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
	var table = $('#examplewbp').DataTable( {
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

